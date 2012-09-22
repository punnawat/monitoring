<?php

class Server_availability extends CI_Controller {   
    
    public function index() {
        if(!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $header['title'] = 'Server Availability Report';
        $header['current_page_item'] = 'savailability';
        
        $this->load->model('server_model');
        $this->load->library("pagination");
        
        $config["base_url"] = site_url('server_availability/index');
        $config["total_rows"] = $this->server_model->countAllAval();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->server_model->getAllAval($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data["result_aval"] = array();
        $index = 0;
        foreach ($data["results"]->result_array() as $r)  {     
            if ($r['http_yn'] == 'Y') {
                $r["aval_http"] = $this->server_model->getAval($r["id"], 'HTTP');
            } else  {
                $r["aval_http"] = "";
            }
            
            if ($r['https_yn'] == 'Y') {
                $r["aval_https"] = $this->server_model->getAval($r["id"], 'HTTPS');
            } else  {
                $r["aval_https"] = "";
            }
            
            if ($r['ftp20_yn'] == 'Y') {
                $r["aval_ftp20"] = $this->server_model->getAval($r["id"], 'FTP:20');
            } else  {
                $r["aval_ftp20"] = "";
            }
            
            if ($r['ftp21_yn'] == 'Y') {
                $r["aval_ftp21"] = $this->server_model->getAval($r["id"], 'FTP:21');
            } else  {
                $r["aval_ftp21"] = "";
            }
            
            if ($r['smtp_yn'] == 'Y') {
                $r["aval_smtp"] = $this->server_model->getAval($r["id"], 'SMTP');
            } else  {
                $r["aval_smtp"] = "";
            }
            
            if ($r['tcp_port'] != NULL && $r['tcp_port'] != '') {
                $dataArr = explode(",", $r['tcp_port']);
                foreach ($dataArr as $d) {
                    $r["aval_tcp_".trim($d)] = $this->server_model->getAval($r["id"], "TCP:" . trim($d));
                }
            }                     
            
            $data["result_aval"][$index++] = $r;
        }
        
        $this->load->view('layout_header', $header);
        $this->load->view('server_availability', $data);
        $this->load->view('layout_footer');
    }
    
    public function view() {      
        $this->load->model('server_model');
        $r = $this->server_model->getById($this->uri->segment(3)); 
        
        if ($r['http_yn'] == 'Y') {
            $r["aval_http"] = $this->server_model->getAval($r["id"], 'HTTP');
        } else  {
            $r["aval_http"] = "";
        }

        if ($r['https_yn'] == 'Y') {
            $r["aval_https"] = $this->server_model->getAval($r["id"], 'HTTPS');
        } else  {
            $r["aval_https"] = "";
        }

        if ($r['ftp20_yn'] == 'Y') {
            $r["aval_ftp20"] = $this->server_model->getAval($r["id"], 'FTP:20');
        } else  {
            $r["aval_ftp20"] = "";
        }

        if ($r['ftp21_yn'] == 'Y') {
            $r["aval_ftp21"] = $this->server_model->getAval($r["id"], 'FTP:21');
        } else  {
            $r["aval_ftp21"] = "";
        }

        if ($r['smtp_yn'] == 'Y') {
            $r["aval_smtp"] = $this->server_model->getAval($r["id"], 'SMTP');
        } else  {
            $r["aval_smtp"] = "";
        }

        if ($r['tcp_port'] != NULL && $r['tcp_port'] != '') {
            $dataArr = explode(",", $r['tcp_port']);
            foreach ($dataArr as $d) {
                $r["aval_tcp_".trim($d)] = $this->server_model->getAval($r["id"], "TCP:" . trim($d));
            }
        }                     
            
        $data["result_aval"] = $r;
  
        
        $data["logs"] = $this->server_model->getNotAval($this->uri->segment(3));
        
        $header['title'] = 'Server Availability Report';
        $header['current_page_item'] = 'savailability';
        
        $this->load->view('layout_header', $header);
        $this->load->view('server_availability_detail', $data);
        $this->load->view('layout_footer');
    }
    
    public function search() {
        $header['title'] = 'Server Availability Report';
        $header['current_page_item'] = 'savailability';
        
        $this->load->model('server_model');
        $data['results'] = $this->server_model->search();
        $data["links"] = "";
        
        $data["result_aval"] = array();
        $index = 0;
        foreach ($data["results"]->result_array() as $r)  {     
            if ($r['http_yn'] == 'Y') {
                $r["aval_http"] = $this->server_model->getAval($r["id"], 'HTTP');
            } else  {
                $r["aval_http"] = "";
            }
            
            if ($r['https_yn'] == 'Y') {
                $r["aval_https"] = $this->server_model->getAval($r["id"], 'HTTPS');
            } else  {
                $r["aval_https"] = "";
            }
            
            if ($r['ftp20_yn'] == 'Y') {
                $r["aval_ftp20"] = $this->server_model->getAval($r["id"], 'FTP:20');
            } else  {
                $r["aval_ftp20"] = "";
            }
            
            if ($r['ftp21_yn'] == 'Y') {
                $r["aval_ftp21"] = $this->server_model->getAval($r["id"], 'FTP:21');
            } else  {
                $r["aval_ftp21"] = "";
            }
            
            if ($r['smtp_yn'] == 'Y') {
                $r["aval_smtp"] = $this->server_model->getAval($r["id"], 'SMTP');
            } else  {
                $r["aval_smtp"] = "";
            }
            
            if ($r['tcp_port'] != NULL && $r['tcp_port'] != '') {
                $dataArr = explode(",", $r['tcp_port']);
                foreach ($dataArr as $d) {
                    $r["aval_tcp_".trim($d)] = $this->server_model->getAval($r["id"], "TCP:" . trim($d));
                }
            }                     
            
            $data["result_aval"][$index++] = $r;
        }
        
        $this->load->view('layout_header', $header);
        $this->load->view('server_availability', $data);
        $this->load->view('layout_footer');
    }
  

}
