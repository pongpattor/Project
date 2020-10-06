<?php
defined('BASEPATH') or exit('No direct script access allowed');

class crud_model extends CI_Model
{


    public function insert($table, $data = array())
    {
        $this->db->insert($table, $data);
    }

    public function findall($table)
    {
        $sql = "SELECT * FROM $table";
        return $this->db->query($sql)->result();
    }

   public function find($table,$select){
        $sql = "SELECT $select FROM $table";
        return $this->db->query($sql)->result();
    }

    public function findwhere($table, $where, $data)
    {
        $sql = "SELECT * FROM $table where $where = '$data'";
        return  $this->db->query($sql)->result();
        
    }
    public function findSelectWhere($table,$select,$where,$data){
        $sql = "SELECT $select FROM $table WHERE $where = $data";
        return $this->db->query($sql)->result();
    }
    public function findColumns($columns, $table)
    {
           $sql = "SELECT $columns FROM $table";
           return $this->db->query($sql)->result();
    }



    public function countAll($table)
    {
           $sql = "SELECT COUNT(*) as row FROM $table";
           return $this->db->query($sql)->result();
    }

    public function update($table, $data = array(), $where, $whereData)
    {
        $this->db->where($where, $whereData);
        $this->db->update($table, $data);
    }

    public function delete($table, $where, $data)
    {
        $sql = "DELETE FROM $table WHERE $where = '$data'";
        $this->db->query($sql);
    }


}
