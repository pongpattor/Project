<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer_model extends CI_Model
{

  public function insert($table, $data = array())
  {
    if($this->db->insert($table, $data))
    {
      return true;
    }
    else{
      return false;
    }
    
  }

  public function findall()
  {
    $sql = "SELECT * FROM customer";
    return  $this->db->query($sql)->result();
  }
}
