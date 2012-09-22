<?php

class Bandwidth extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $header['title'] = 'Bandwidth Monitoring';
        $header['current_page_item'] = 'bandwidth';
        
        $this->load->view('layout_header', $header);
        $this->load->view('bandwidth');
        $this->load->view('layout_footer');
    }
    
    public function search() {
        $header['title'] = 'Bandwidth Monitoring';
        $header['current_page_item'] = 'bandwidth';
        
        $this->load->model('device_model');
        $data['results'] = $this->device_model->search();
        
        $this->load->view('layout_header', $header);
        $this->load->view('bandwidth', $data);
        $this->load->view('layout_footer');
    }
    
    public function view() {
        $header['title'] = 'Bandwidth Monitoring';
        $header['current_page_item'] = 'bandwidth';

        $this->load->model('device_model');
        $d = $this->device_model->getById($this->uri->segment(3));
        $data['device'] = $d;
        $data['log'] = $this->device_model->getInterfaces($this->uri->segment(3));
        
        
        $this->load->view('layout_header', $header);
        $this->load->view('bandwidth_detail', $data);
        $this->load->view('layout_footer');
    }   
    
    public function view_graph() {
        $header['title'] = 'Bandwidth Monitoring';
        $header['current_page_item'] = 'bandwidth';

        $this->load->model('device_model');     
        $device_id = $this->input->post('txtDeviceID');
        $log_id = $this->input->post('txtLogID');
        //$startDate = $this->input->post('txtStartDate');
        //$endDate = $this->input->post('txtEndDate');
        
        $data['device'] = $this->device_model->getById($device_id);
        $data['log'] = $this->device_model->getInterfaces($device_id);
        
        $interface = $this->device_model->getInterfaceByLogID($log_id);
        $data['interface_bw'] = $this->device_model->getInterfaceBW($device_id,$interface['interface_name']);
        $data['interface_name'] = $interface['interface_name'];
        $this->load->view('layout_header', $header);
        $this->load->view('bandwidth_detail', $data);
        $this->load->view('layout_footer');
    }

}
