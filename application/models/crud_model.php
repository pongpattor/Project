<?php
defined('BASEPATH') or exit('No direct script access allowed');

class crud_model extends CI_Model
{


    function insert($table, $data = array())
    {
        $this->db->insert($table, $data);
    }

    function findall($table)
    {
        $sql = "SELECT * FROM $table";
        return $this->db->query($sql)->result();
    }
    function find($table, $where, $data)
    {
        $sql = "SELECT * FROM $table where $where = '$data'";
        return $this->db->query($sql)->result();
    }

    function update($table,$data=array(),$where,$whereData){
        $this->db->where($where,$whereData);
        $this->db->update($table,$data);
    }
}
