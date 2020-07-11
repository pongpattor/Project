<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer_model extends CI_Model
{

  public function insert($table, $data = array())
  {
    $sql = "SELECT COUNT(USERNAME) as'co' FROM $table where USERNAME = '".$data['USERNAME']."'";
    $data= $this->db->query($sql)->result();
    foreach($data as $row){
      if($row->co >0){
        return false;
      }
      else{
        $this->db->insert($table,$data);
        return true;
      }
    }
  }

  public function findall()
  {
    $sql = "SELECT * FROM customer";
    return  $this->db->query($sql)->result();
  }
}
