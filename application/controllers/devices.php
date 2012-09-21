<?php

class Devices extends CI_Controller {   
    
    public function index() {
        $this->load->model('device_model');
        $this->load->library("pagination");
        
        $config["base_url"] = site_url('devices/index');
        $config["total_rows"] = $this->device_model->countAll();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->device_model->getAll($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $header['title'] = 'Network Devices Information';
        $header['current_page_item'] = 'devices';
        $this->load->view('layout_header', $header);
        $this->load->view('devices_list', $data);
        $this->load->view('layout_footer');

    }

    public function edit() {
        $header['title'] = 'Network Devices Information';
        $header['current_page_item'] = 'devices';
                
        $this->load->model('device_model');
        $result = $this->device_model->getById($this->uri->segment(3));
        
        $this->load->view('layout_header', $header);
        $this->load->view('devices_form', $result);
        $this->load->view('layout_footer');
    }
    
    public function del() {  
        $this->load->model('device_model');
        $this->device_model->del();        
        redirect('devices/index');
    }
    
    public function add() {  
        $header['title'] = 'Network Devices Information';
        $header['current_page_item'] = 'devices';
        $this->load->view('layout_header', $header);
        $this->load->view('devices_form');
        $this->load->view('layout_footer');
    }

    public function save_success() {
        $header['title'] = 'Network Devices Information';
        $header['current_page_item'] = 'devices';
        $result['status_msg'] = 'success'; 
        $this->load->view('layout_header', $header);
        $this->load->view('devices_form', $result);
        $this->load->view('layout_footer');
    }
    
    public function save() {
        $header['title'] = 'Network Devices Information';
        $header['current_page_item'] = 'devices';
        
        $this->form_validation->set_rules('device_name', 'Device Name', 'trim|required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'trim|required');
        $this->form_validation->set_rules('snmp_comm_str', 'SNMP Community String', 'trim|required');
        $this->form_validation->set_rules('location_floor', 'Floor', '');
        $this->form_validation->set_rules('location_rack', 'Rack', '');
        $this->form_validation->set_rules('location_room', 'Room', '');
        $this->form_validation->set_rules('location_building', 'Building', '');
        $this->form_validation->set_rules('monitor_yn', 'Monitor ?', '');
        $this->form_validation->set_rules('bandwidth_yn', 'Bandwidth Report ?', '');
               

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout_header', $header);
            $this->load->view('devices_form');
            $this->load->view('layout_footer');
        } else {
            
            // save data
            $this->load->model('device_model');
            
            if($this->input->post('device_id') == '') {
                // new device
                $id = $this->device_model->insert();
            } else {
                // update device
                $this->device_model->update();
                $id = $this->input->post('device_id');
            }
            
            $this->device_model->getById($id);
            redirect('devices/save_success');
            
        }
    }

}
