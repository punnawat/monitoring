<?php

class Users_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getById($id) {
        $query = $this->db->get_where('users', array('username' => $id));
        return $query->row_array();
    }

    
}

?>
