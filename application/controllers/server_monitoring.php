<?php

class Server_monitoring extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $header['title'] = 'Server Monitoring';
        $header['current_page_item'] = 'smonitor';
        $this->load->model('server_model');          
        
        // load server
        $data['servers'] = $this->server_model->getOnlyMonitor();
        
        $this->load->view('layout_header', $header);
        $this->load->view('server_monitoring', $data);
        $this->load->view('layout_footer');
    }
    
    public function clear_log() {
        
        $this->load->model('server_model');
        $this->server_model->clear_log(); 
        redirect('server_monitoring');
    }   
  

}
