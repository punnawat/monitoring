<?php

class Real_time extends CI_Controller {

    public function index() {
        $header['title'] = 'Real Time Monitoring';
        $header['current_page_item'] = 'realtime';
        
        if($this->session->userdata('rt_start_time') == null )
            $this->session->set_userdata('rt_start_time', date('Y-m-d H:i').':00');
       
        $this->load->view('layout_header', $header);
        $this->load->view('real_time');
        $this->load->view('layout_footer');
    }

    public function view() {
        $header['title'] = 'Real Time Monitoring';
        $header['current_page_item'] = 'realtime';

        $this->load->model('device_model');
        $d = $this->device_model->getById($this->uri->segment(3));
        $data['device'] = $d;
        $data['log'] = $this->device_model->getInterfaces($this->uri->segment(3));
        
        $this->load->view('layout_header', $header);
        $this->load->view('real_time_detail', $data);
        $this->load->view('layout_footer');
    }
    
    public function view_graph() {
        $header['title'] = 'Real Time Monitoring';
        $header['current_page_item'] = 'realtime';

        $this->load->model('device_model');     
        $device_id = $this->uri->segment(3);
        $log_id = $this->uri->segment(4);
        $data['device'] = $this->device_model->getById($device_id);
        $data['log'] = $this->device_model->getInterfaces($device_id);
        
        $interface = $this->device_model->getInterfaceByLogID($log_id);
        $data['interface_bw'] = $this->device_model->getInterfaceRtBw($interface['interface_name']);
        $data['interface_name'] = $interface['interface_name'];
        $this->load->view('layout_header', $header);
        $this->load->view('real_time_detail', $data);
        $this->load->view('layout_footer');
    }

    public function search() {
        $header['title'] = 'Real Time Monitoring';
        $header['current_page_item'] = 'realtime';
        
        $this->load->model('device_model');
        $data['results'] = $this->device_model->search();
        
        $this->load->view('layout_header', $header);
        $this->load->view('real_time', $data);
        $this->load->view('layout_footer');
    }
    
    public function walk($host, $community) {
        snmp_set_quick_print(true);

        $initOid = "interfaces.ifTable";
        $arr = snmp2_real_walk($host, $community, $initOid);
        $log = array();
        $log['interface_name'] = array();
        $log['bandwidth_in'] = array();
        $log['bandwidth_out'] = array();
        foreach ($arr as $oid => $val) {
            if (strpos($oid, "ifDescr.") != FALSE) {
                $log['interface_name'][] = $val;
            } else if (strpos($oid, "ifInOctets.") != FALSE) {
                $log['bandwidth_in'][] = $val;
            } else if (strpos($oid, "ifOutOctets.") != FALSE) {
                $log['bandwidth_out'][] = $val;
            }
        }
        return $log;
    }

}
