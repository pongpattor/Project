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

    public function selectDesk(){
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,zone.ZONE_NAME FROM seat
        JOIN zone ON seat.SEAT_ZONE =  zone.ZONE_ID
        WHERE seat.SEAT_TYPE = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    
}
