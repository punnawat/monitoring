<?php

class Device_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function mapData() {
        $data = array(
            'device_name' => $this->input->post('device_name'),
            'ip_address' => $this->input->post('ip_address'),
            'snmp_comm_str' => $this->input->post('snmp_comm_str'),
            'location_floor' => $this->input->post('location_floor'),
            'location_rack' => $this->input->post('location_rack'),
            'location_room' => $this->input->post('location_room'),
            'location_building' => $this->input->post('location_building'),
            'monitor_yn' => $this->input->post('monitor_yn') == 'Y' ? 'Y' : 'N',
            'bandwidth_yn' => $this->input->post('bandwidth_yn') == 'Y' ? 'Y' : 'N',
            //'updated_by' => $this->input->post(''),
            'updated_date' => date("Y-m-d H:i:s.u"),
        );
        return $data;
    }

    function getById($id) {
        $query = $this->db->get_where('devices', array('id' => $id));
        return $query->row_array();
    }

    function scanLog($q) {
        $r = null;
        $logs = $q->result_array();
        //print_r($logs);
        if ($logs != NULL && count($logs) > 0) {
            if (($logs[0]['status'] == 'DOWN') ||
                    ($logs[0]['status'] == 'UP' && count($logs) >= 2 && $logs[1]['status'] == 'DOWN')) {
                $r = array('log_date_down' => '', 'log_date_up' => '');
                
                $down_count = 0;

                $last_down_time = "";
                if ($logs[0]['status'] == 'DOWN') {
                    $last_down_time = $logs[0]['updated_date'];
                    $down_count++;
                }

                $last_up_time = "";
                if ($logs[0]['status'] == 'UP') {                    
                    $r['log_date_up'] = $logs[0]['updated_date'];
                }

                if (count($logs) > 1) {
                    for ($i = 1; $i < count($logs); $i++) {
                        $l = $logs[$i];
                        if ($l['status'] == 'DOWN') {
                            $down_count++;
                            $last_down_time = $l['updated_date'];
                        } else {
                            break;
                        }
                    }
                }

                if ($down_count >= 5) {                    
                    $r['log_date_down'] = $last_down_time;
                } 
            }
        }
//        print_r($r);
        return $r;
    }

    function getOnlyMonitor() {
        $query = $this->db->get_where('devices', array('monitor_yn' => 'Y'));
        $rows = $query->result_array();

        $result = array();
        $result_index = 0;

        foreach ($rows as $r) {
            $result[$result_index] = $r;
            $this->db->order_by("updated_date", "desc");
            $q = $this->db->get_where('log_check_devices', array('device_id' => $r['id']));
            $log_result = $this->scanLog($q);
            
            if($log_result != null) {               
                $result[$result_index]['log_ping_date_down'] = $log_result['log_date_down'];
                $result[$result_index]['log_ping_date_up'] = $log_result['log_date_up'];
            } else {                
                $result[$result_index]['log_ping_date_down'] = "";
                $result[$result_index]['log_ping_date_up'] = "";
            }            
            $result_index++;
        }

        //print_r($result);
        return $result;
    }

    function clear_log() {
        $this->db->truncate('log_check_devices');
    }

    function getAllBW() {
        return $this->db->get_where('devices', array('bandwidth_yn' => 'Y'));
    }

    function search() {
        if ($this->input->post('txtKeyword') != null) {
            $this->db->like('device_name', $this->input->post('txtKeyword'));
            $this->db->or_like('ip_address', $this->input->post('txtKeyword'));
            return $this->db->get_where('devices', array('bandwidth_yn' => 'Y'));
        }
        return $this->getAllBW();
    }

    function getInterfaces($deviceID) {
        return $this->db->query("SELECT id,device_id,interface_name,bandwidth_in,bandwidth_out,updated_date  
                                FROM mon_log_check_bandwidth  
                                WHERE device_id = " . $deviceID .
                        " and updated_date = (select updated_date from mon_log_check_bandwidth WHERE device_id = " . $deviceID . " order by updated_date desc limit 1)");
    }

    function getInterfaceByLogID($logID) {
        $query = $this->db->get_where('log_check_bandwidth', array('id' => $logID));
        return $query->row_array();
    }

    function getInterfaceRtBw($device_id, $interfaceName) {
        $sql = " (SELECT id,device_id,interface_name,bandwidth_in,bandwidth_out,updated_date ";
        $sql .= " FROM mon_log_check_bandwidth ";
        $sql .= " WHERE interface_name = '" . $interfaceName . "' ";
        $sql .= " and device_id	 = " . $device_id . " ";
        $sql .= " and updated_date < '" . $this->session->userdata('rt_start_time') . "'";
        $sql .= " order by updated_date desc limit 2) ";
        $sql .= " UNION ";
        $sql .= " (SELECT id,device_id,interface_name,bandwidth_in,bandwidth_out,updated_date ";
        $sql .= " FROM mon_log_check_bandwidth ";
        $sql .= " WHERE interface_name = '" . $interfaceName . "' ";
        $sql .= "   and updated_date > '" . $this->session->userdata('rt_start_time') . "')";
        return $this->db->query($sql);
        ;
    }

    function getInterfaceBW($device_id, $interfaceName) {
        $this->db->order_by("updated_date", "asc");

        $criteria = array('interface_name' => $interfaceName, 'device_id' => $device_id);
        if($this->input->post('txtStartDate') != null)
            $criteria['updated_date >= '] = $this->input->post('txtStartDate'). ' 00:00:00';
        if($this->input->post('txtEndDate') != null)
            $criteria['updated_date <= '] = $this->input->post('txtEndDate'). ' 23:59:59';
            
        $query = $this->db->get_where('log_check_bandwidth', $criteria);
        //print_r($this->db->last_query());
        return $query;
    }

    function getAll($limit, $start) {
        return $query = $this->db->get('devices', $limit, $start);
    }

    function countAll() {
         return $this->db->count_all("devices");
    }
    
    function getAllAval($limit, $start) {
        $this->db->limit($limit, $start);
        $criteria = array('monitor_yn' => 'Y');
        return $this->db->get_where('devices', $criteria);
    }

    function countAllAval() {
        $this->db->where('monitor_yn', 'Y');
        $this->db->from('devices');        
        return $this->db->count_all_results();
    }

    function getAval($id) {
        $this->db->where('device_id', $id);
        $this->db->where('status', 'UP');
        $this->db->from('log_check_devices');        
        $up = $this->db->count_all_results();
        
        $this->db->where('device_id', $id);
        $this->db->where('status', 'DOWN');
        $this->db->from('log_check_devices');        
        $down = $this->db->count_all_results();
        if($up + $down == 0)
            return 0;
        return $up * 100.0 / ($up + $down);
    }
    
    function getNotAval($id) {
        $this->db->where('device_id', $id);
        $this->db->where('status', 'DOWN');
        $this->db->order_by("updated_date", "desc");
        $this->db->from('log_check_devices');        
        
        return $this->db->get();
    }
    
    function insert() {
        $this->db->insert('devices', $this->mapData());
        return $this->db->insert_id();
    }

    function update() {
        $this->db->where('id', $this->input->post('device_id'));
        $this->db->update('devices', $this->mapData());
    }

    function del() {
        $this->db->delete('devices', array('id' => $this->input->post('device_id')));
    }

}

?>
