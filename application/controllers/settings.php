<?php

class Settings extends CI_Controller {   
    
    public function index() {        
        $this->form_validation->set_rules('refresh_time', 'Refresh Time', 'trim|required');
        
        $this->load->model('setting_model');        
        $result['refresh_time'] = $this->setting_model->getById('refresh_time'); 
		$result['alarm'] = $this->setting_model->getById('alarm');     		
        $header['title'] = 'Settings Information';
        $header['current_page_item'] = 'settings';
        $this->load->view('layout_header', $header);
        $this->load->view('settings_form', $result);
        $this->load->view('layout_footer');

    }


    public function save() {
        $header['title'] = 'Settings Information';
        $header['current_page_item'] = 'settings';
        
        $this->form_validation->set_rules('refresh_time', 'Refresh Time', 'trim|required');
		$this->form_validation->set_rules('alarm', 'Alarm Time', 'trim|required');        

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout_header', $header);
            $this->load->view('settings_form');
            $this->load->view('layout_footer');
        } else {
            
            // save data
            $this->load->model('setting_model');
            
            $this->setting_model->update();
                    
            
            $result['refresh_time'] = $this->setting_model->getById('refresh_time'); 
			$result['alarm'] = $this->setting_model->getById('alarm');   
            $result['status_msg'] = 'success';            
            
            
            $this->load->view('layout_header', $header);
            $this->load->view('settings_form', $result);
            $this->load->view('layout_footer');
            
        }
    }

}
