<?php

class Network_availability extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $header['title'] = 'Network Availability Report';
        $header['current_page_item'] = 'navailability';
                
        $this->load->model('device_model');
        $this->load->library("pagination");
        
        $config["base_url"] = site_url('network_availability/index');
        $config["total_rows"] = $this->device_model->countAllAval();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->device_model->getAllAval($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data["result_aval"] = array();
        $index = 0;
        foreach ($data["results"]->result_array() as $row)  {            
            $row["aval"] = $this->device_model->getAval($row["id"]);
            $data["result_aval"][$index++] = $row;
        }
        
        $this->load->view('layout_header', $header);
        $this->load->view('network_availability', $data);
        $this->load->view('layout_footer');
    }
    
    public function view() {      
        $this->load->model('device_model');
        $row = $this->device_model->getById($this->uri->segment(3));
        $row["aval"] = $this->device_model->getAval($this->uri->segment(3));
        $data["result_aval"] = $row;
        $data["logs"] = $this->device_model->getNotAval($this->uri->segment(3));
        
        $header['title'] = 'Network Availability Report';
        $header['current_page_item'] = 'navailability';
        
        $this->load->view('layout_header', $header);
        $this->load->view('network_availability_detail', $data);
        $this->load->view('layout_footer');
    }
    
    public function search() {
        $header['title'] = 'Network Availability Report';
        $header['current_page_item'] = 'navailability';
        
        $this->load->model('device_model');
        $data['results'] = $this->device_model->search();
        $data["links"] = "";
        
        $data["result_aval"] = array();
        $index = 0;
        foreach ($data["results"]->result_array() as $row)  {            
            $row["aval"] = $this->device_model->getAval($row["id"]);
            $data["result_aval"][$index++] = $row;
        }
        
        $this->load->view('layout_header', $header);
        $this->load->view('network_availability', $data);
        $this->load->view('layout_footer');
    }
  

}
