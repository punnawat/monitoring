<?php

class Availability extends CI_Controller {   
    
    public function index() {
        $header['title'] = 'Availability Report';
        $header['current_page_item'] = 'availability';
        
        
        $this->load->view('layout_header', $header);
        $this->load->view('availability');
        $this->load->view('layout_footer');
    }
    
    
  

}
