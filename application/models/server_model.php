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

   
    
    function search() {
        if ($this->input->post('txtKeyword') != null) {
            $this->db->like('server_name', $this->input->post('txtKeyword'));
            $this->db->or_like('ip_address', $this->input->post('txtKeyword'));
            return $this->db->get_where('servers', array('monitor_yn' => 'Y'));
        }
        return $this->getAllAval(999, 0);
    }
    
    function getById($id) {
        $query = $this->db->get_where('servers', array('id' => $id));
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
        $query = $this->db->get_where('servers', array('monitor_yn' => 'Y'));
        $rows = $query->result_array();

        $result = array();
        $result_index = 0;
        
        $isShow = false;
        foreach ($rows as $r) {
            $result[$result_index] = $r;
            if ($r['http_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'HTTP'));
                $log_result = $this->scanLog($q); 
                if($log_result != null) {               
                    $result[$result_index]['status_http_down'] = $log_result['log_date_down'];  
                    $result[$result_index]['status_http_up'] = $log_result['log_date_up'];  $isShow = true;
                } else {                
                    $result[$result_index]['status_http_down'] = "";
                    $result[$result_index]['status_http_up'] = "";
                }                
            }
            
            if ($r['https_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'HTTPS'));
                $log_result = $this->scanLog($q);
                if($log_result != null) {               
                    $result[$result_index]['status_https_down'] = $log_result['log_date_down'];
                    $result[$result_index]['status_https_up'] = $log_result['log_date_up']; $isShow = true;
                } else {                
                    $result[$result_index]['status_https_down'] = "";
                    $result[$result_index]['status_https_up'] = "";
                }
            }
            
            if ($r['ftp20_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'FTP:20'));
                $log_result = $this->scanLog($q);
                if($log_result != null) {               
                    $result[$result_index]['status_ftp20_down'] = $log_result['log_date_down'];
                    $result[$result_index]['status_ftp20_up'] = $log_result['log_date_up']; $isShow = true;
                } else {                
                    $result[$result_index]['status_ftp20_down'] = "";
                    $result[$result_index]['status_ftp20_up'] = "";
                }
            }
            
            if ($r['ftp21_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'FTP:21'));
                $log_result = $this->scanLog($q);
                if($log_result != null) {               
                    $result[$result_index]['status_ftp21_down'] = $log_result['log_date_down'];
                    $result[$result_index]['status_ftp21_up'] = $log_result['log_date_up']; $isShow = true;
                } else {                
                    $result[$result_index]['status_ftp21_down'] = "";
                    $result[$result_index]['status_ftp21_up'] = "";
                }
            }
            
            if ($r['smtp_yn'] == 'Y') {
                $this->db->order_by("updated_date", "desc");
                $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                      'service' => 'SMTP'));
                $log_result = $this->scanLog($q);
                if($log_result != null) {               
                    $result[$result_index]['status_smtp_down'] = $log_result['log_date_down'];
                    $result[$result_index]['status_smtp_up'] = $log_result['log_date_up'];  $isShow = true;
                } else {                
                    $result[$result_index]['status_smtp_down'] = "";
                    $result[$result_index]['status_smtp_up'] = "";
                }
            }
            
            if ($r['tcp_port'] != NULL && $r['tcp_port'] != '') {
                $dataArr = explode(",", $r['tcp_port']);
                foreach ($dataArr as $d) {
                    $this->db->order_by("updated_date", "desc");
                    $q = $this->db->get_where('log_check_services', array('server_id' => $r['id'],
                                                                            'service' => "TCP:" . trim($d)));
                    $log_result = $this->scanLog($q);
                    if($log_result != null) {               
                        $result[$result_index]['status_tcp_down'. trim($d)] = $log_result['log_date_down'];
                        $result[$result_index]['status_tcp_up'. trim($d)] = $log_result['log_date_up']; $isShow = true;
                    } else {                
                        $result[$result_index]['status_tcp_down'. trim($d)] = "";
                        $result[$result_index]['status_tcp_up'. trim($d)] = "";
                    }                                      
                }                
            }
            $result[$result_index]['is_show'] = $isShow;
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

    function countAll() {
        return $this->db->count_all("servers");
    }
    
    function getAllAval($limit, $start) {
        $this->db->limit($limit, $start);
        $criteria = array('monitor_yn' => 'Y');
        return $this->db->get_where('servers', $criteria);
    }

    function countAllAval() {
        $this->db->where('monitor_yn', 'Y');
        $this->db->from('servers');        
        return $this->db->count_all_results();
    }

    function getAval($id, $service) {
        $this->db->where('server_id', $id);
        $this->db->where('status', 'UP');
        $this->db->where('service', $service);
        $this->db->from('log_check_services');        
        $up = $this->db->count_all_results();
        
        $this->db->where('server_id', $id);
        $this->db->where('status', 'DOWN');
        $this->db->where('service', $service);
        $this->db->from('log_check_services');        
        $down = $this->db->count_all_results();
        if($up + $down == 0)
            return 0;
        return $up * 100.0 / ($up + $down);
    }
    
    function getNotAval($id) {
        $this->db->where('server_id', $id);        
        $this->db->where('status', 'DOWN');
        $this->db->order_by("updated_date", "desc");
        $this->db->from('log_check_services');        
        
        return $this->db->get();
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
