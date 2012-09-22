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
        
        public function login()
	{
            $this->load->model('users_model');
            $u = $this->users_model->getById($this->input->post('txtUsername'));
            
            if($u!= null && count($u) > 0 && $this->input->post('txtUsername') != null && $this->input->post('txtPassword') != null &&  md5($this->input->post('txtUsername')) == $u["password"]) {
                $sess_array = array('username' => $u["username"]);
                $this->session->set_userdata('logged_in', $sess_array);
                redirect('server_monitoring');
            } else {
                $header['title'] = 'Welcome';
                $header['current_page_item'] = 'main';
                $this->load->view('layout_header', $header);                        
                $this->load->view('welcome');
                $this->load->view('layout_footer');
            }
            
	}
        
        public function logout()
	{
            $this->session->unset_userdata('logged_in');
            $this->session->sess_destroy();
            //session_destroy();
            redirect('welcome');
	}
}
