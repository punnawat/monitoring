<?php

class Setting_model extends CI_Model {      
    
    function __construct() {
        parent::__construct();
    }
    
    function mapData() 
    {
        $data = array(
                'values' => $this->input->post('refresh_time'),                
                //'updated_by' => $this->input->post(''),
                'updated_date' => date("Y-m-d H:i:s.u"),                
                );        
        return $data;        
    }
    
    function getById($id) 
    {        
        $query = $this->db->get_where('settings', array('keys' => $id));
        return $query->row_array();
    }
    
    
    function update()
    {        
        $this->db->where('keys', $this->input->post('refresh_key'));
        $this->db->update('settings', $this->mapData());
        
    }
    
    
}

?>
