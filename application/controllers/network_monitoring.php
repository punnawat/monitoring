<?php

class Network_monitoring extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $header['title'] = 'Network Monitoring';
        $header['current_page_item'] = 'dmonitor';
        $this->load->model('device_model');          
        
        // load server
        $data['servers'] = $this->device_model->getOnlyMonitor();
        
        $this->load->view('layout_header', $header);
        $this->load->view('device_monitoring', $data);
        $this->load->view('layout_footer');
    }
    
    public function clear_log() {
        
        $this->load->model('device_model');
        $this->device_model->clear_log(); 
        redirect('network_monitoring');
    }   
  

}
