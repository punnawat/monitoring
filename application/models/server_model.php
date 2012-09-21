<?php

class Server_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function mapData() {
        $data = array(
            'server_name' => $this->input->post('server_name'),
            'ip_address' => $this->input->post('ip_address'),
            'location_floor' => $this->input->post('location_floor'),
            'location_rack' => $this->input->post('location_rack'),
            'location_room' => $this->input->post('location_room'),
            'location_building' => $this->input->post('location_building'),
            'monitor_yn' => $this->input->post('monitor_yn') == 'Y' ? 'Y' : 'N',
            'http_yn' => $this->input->post('http_yn') == 'Y' ? 'Y' : 'N',
            'https_yn' => $this->input->post('https_yn') == 'Y' ? 'Y' : 'N',
            'ftp20_yn' => $this->input->post('ftp20_yn') == 'Y' ? 'Y' : 'N',
            'ftp21_yn' => $this->input->post('ftp21_yn') == 'Y' ? 'Y' : 'N',
            'smtp_yn' => $this->input->post('smtp_yn') == 'Y' ? 'Y' : 'N',
            'tcp_port' => $this->input->post('tcp_port'),
            //'updated_by' => $this->input->post(''),
            'updated_date' => date("Y-m-d H:i:s.u"),
        );
        return $data;
    }

    function getById($id) {
        $query = $this->db->get_where('servers', array('id' => $id));
        return $query->row_array();
    }

    function scanLog($q) {   
        $r = array();        
        $logs = $q->result_array();
        
        if ($logs != NULL && count($logs) > 0) {  
            if ($logs[0]['status'] == 'UP') {
                $r['log_status'] = 'UP';
                $r['log_date'] = $logs[0]['updated_date'];                
            } else {
                $down_count = 0;
                $last_down_time = $logs[count($logs)-1]['updated_date'];
                $last_up_time = $logs[count($logs)-1]['updated_date'];
                foreach ($logs as $l) {
                    //echo $l['status'];
                    if ($l['status'] == 'DOWN') {
                        //print_r($l);
                        $down_count++;
                        $last_down_time = $l['updated_date'];
                    } else {        
                        
                        $last_up_time = $l['updated_date'];
                        break;
                    }
                }
                if ($down_count >= 5) {
                    $r['log_status'] = 'DOWN';
                    $r['log_date'] = $last_down_time;                   
                } else {
                    $r['log_status'] = 'UP';
                    $r['log_date'] = $last_up_time;                    
                }
            }
        }       
        return $r;
    }

    function getOnlyMonitor() {
        $query = $this->db->get_where('servers', array('monitor_yn' => 'Y'));
        $rows = $query->result_array();

        $result = array();
        $result_index = 0;
        

        foreach ($rows as $r) {
            $result[$result_index] = $r;
            if ($r['http_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'HTTP'));
                $log_result = $this->scanLog($q);                
                $result[$result_index]['status_http'] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                $result[$result_index]['log_http_date'] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                //$result_index++; 
            }
            
            if ($r['https_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'HTTPS'));
                $log_result = $this->scanLog($q);
                $result[$result_index]['status_https'] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                $result[$result_index]['log_https_date'] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                //$result_index++; 
            }
            
            if ($r['ftp20_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'FTP:20'));
                $log_result = $this->scanLog($q);
                $result[$result_index]['status_ftp20'] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                $result[$result_index]['log_ftp20_date'] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                //$result_index++; 
            }
            
            if ($r['ftp21_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'FTP:21'));
                $log_result = $this->scanLog($q);
                $result[$result_index]['status_ftp21'] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                $result[$result_index]['log_ftp21_date'] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                //$result_index++; 
            }
            
            if ($r['smtp_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'SMTP'));
                $log_result = $this->scanLog($q);
                $result[$result_index]['status_smtp'] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                $result[$result_index]['log_smtp_date'] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                //$result_index++; 
            }
            
            if ($r['tcp_port'] != NULL && $r['tcp_port'] != '') {
                $dataArr = explode(",", $r['tcp_port']);
                foreach ($dataArr as $d) {
                    $this->db->order_by("updated_date", "desc");
                    $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                            'service' => "TCP:" . trim($d)));
                    $log_result = $this->scanLog($q);
                    $result[$result_index]['status_tcp' . trim($d)] = isset($log_result['log_status']) ? $log_result['log_status'] : "DOWN";
                    $result[$result_index]['log_tcp_date' . trim($d)] = isset($log_result['log_date']) ? $log_result['log_date'] : "";
                     
                }                
            }
            $result_index++;
        }

        //print_r($result);
        return $result;
    }
    
    function clear_log() {
        $this->db->truncate('log_check_services'); 
    }

    function getAll($limit, $start) {
        return $query = $this->db->get('servers', $limit, $start);
    }

    public function countAll() {
        return $this->db->count_all("servers");
    }

    function insert() {
        $this->db->insert('servers', $this->mapData());
        return $this->db->insert_id();
    }

    function update() {
        $this->db->where('id', $this->input->post('device_id'));
        $this->db->update('servers', $this->mapData());
    }

    function del() {
        $this->db->delete('servers', array('id' => $this->input->post('device_id')));
    }

}

?>
