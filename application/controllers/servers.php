<?php

class Servers extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }

        $this->load->model('server_model');
        $this->load->library("pagination");
        
        $config["base_url"] = site_url('servers/index');
        $config["total_rows"] = $this->server_model->countAll();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->server_model->getAll($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $header['title'] = 'Network Servers Information';
        $header['current_page_item'] = 'servers';
        $this->load->view('layout_header', $header);
        $this->load->view('servers_list', $data);
        $this->load->view('layout_footer');

    }

    public function edit() {
        $header['title'] = 'Network Servers Information';
        $header['current_page_item'] = 'servers';
                
        $this->load->model('server_model');
        $result = $this->server_model->getById($this->uri->segment(3));
        
        $this->load->view('layout_header', $header);
        $this->load->view('servers_form', $result);
        $this->load->view('layout_footer');
    }
    
    public function del() {  
        $this->load->model('server_model');
        $this->server_model->del();        
        redirect('servers/index');
    }
    
    public function add() {  
        $header['title'] = 'Network Servers Information';
        $header['current_page_item'] = 'servers';
        $this->load->view('layout_header', $header);
        $this->load->view('servers_form');
        $this->load->view('layout_footer');
    }

    public function save_success() {
        $header['title'] = 'Network Servers Information';
        $header['current_page_item'] = 'servers';
        $result['status_msg'] = 'success'; 
        $this->load->view('layout_header', $header);
        $this->load->view('servers_form', $result);
        $this->load->view('layout_footer');
    }
    
    public function save() {
        $header['title'] = 'Network Servers Information';
        $header['current_page_item'] = 'servers';
        
        $this->form_validation->set_rules('server_name', 'Servers Name', 'trim|required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'trim|required');        
        $this->form_validation->set_rules('location_floor', 'Floor', '');
        $this->form_validation->set_rules('location_rack', 'Rack', '');
        $this->form_validation->set_rules('location_room', 'Room', '');
        $this->form_validation->set_rules('location_building', 'Building', '');
        $this->form_validation->set_rules('monitor_yn', 'Monitor ?', '');
        
        $this->form_validation->set_rules('http_yn', 'HTTP ?', '');
        $this->form_validation->set_rules('https_yn', 'HTTPS ?', '');
        $this->form_validation->set_rules('ftp20_yn', 'FTP Port No. 20 ?', '');
        $this->form_validation->set_rules('ftp21_yn', 'FTP Port No. 21 ?', '');
        $this->form_validation->set_rules('smtp_yn', 'SMTP ?', '');
        $this->form_validation->set_rules('tcp_port', 'TCP Port', '');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout_header', $header);
            $this->load->view('servers_form');
            $this->load->view('layout_footer');
        } else {
            
            // save data
            $this->load->model('server_model');
            
            if($this->input->post('device_id') == '') {
                // new servers
                $id = $this->server_model->insert();
            } else {
                // update servers
                $this->server_model->update();
                $id = $this->input->post('device_id');
            }
            
            $this->server_model->getById($id);
            
            redirect('servers/save_success');
        }
    }

}
