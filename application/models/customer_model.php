<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer_model extends CI_Model
{
  function check_user( $username)
  {
    $sql = "SELECT COUNT(USERNAME)as 'no' FROM customer WHERE USERNAME = '$username'";
    $query = $this->db->query($sql)->result();
    foreach ($query as $row) {
      return $row->no;
    }
  }

  function insert($table, $data = array())
  {
    $this->db->insert($table, $data);
    return true;
  }

  function findall()
  {
    $sql = "SELECT * FROM customer";
    return  $this->db->query($sql)->result();
  }
}
