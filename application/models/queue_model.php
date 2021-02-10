<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue_model extends CI_Model
{
    public function queueTime(){
        $sql = "SELECT QUEUETYPE_TIME FROM queuetype
        WHERE QUEUETYPE_ID = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    
}
