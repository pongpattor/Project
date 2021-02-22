<?php
defined('BASEPATH') or exit('No direct script access allowed');

class test_model extends CI_Model
{
    public function insert(){
        $sql = "INSERT INTO test(fn,ln) VALUES('tor','ppt')";
        $query = $this->db->query($sql);
        echo '<pre>';
        print_r($this->db->last_query($query));
        echo '</pre>';
    }

    public function update(){
        $sql = "UPDATE test 
                SET fn= 'ppt',ln = 'tor'
                WHERE id = '4'";
        $query = $this->db->query($sql);
        echo '<pre>';
        print_r($this->db->last_query($query));
        echo '</pre>';
    }
}