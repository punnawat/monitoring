<?php 

class Welcome extends CI_Controller {
	
	public function index()
	{
            $header['title'] = 'Welcome';
            $header['current_page_item'] = 'main';
            $this->load->view('layout_header', $header);                        
            $this->load->view('welcome');
            $this->load->view('layout_footer');
	}
}
