<?php
defined('BASEPATH') or exit('No direct script access allowed');

class crud_model extends CI_Model{


    public function insert($table,$data=array()){
        $this->db->insert($table,$data);
    }

    public function findall($table){
        $sql = "SELECT * FROM $table";
        return $this->db->query($sql)->result();

    }

}