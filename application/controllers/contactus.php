<?php 

class Contactus extends CI_Controller {
	
	public function index()
	{
            $header['title'] = 'Contact US';
            $header['current_page_item'] = 'contactus';
            $this->load->view('layout_header', $header);                        
            $this->load->view('contactus');
            $this->load->view('layout_footer');
	}
}
