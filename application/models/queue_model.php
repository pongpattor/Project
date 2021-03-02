<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue_model extends CI_Model
{
    public function queueTime()
    {
        $sql = "SELECT QUEUETYPE_TIME FROM queuetype
        WHERE QUEUETYPE_ID = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function selectDesk()
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_AMOUNT,.seat.SEAT_NAME,zone.ZONE_NAME FROM seat JOIN zone
        ON seat.SEAT_ZONE = zone.ZONE_ID
        WHERE seat.SEAT_QUEUE = 1
        AND seat.SEAT_ACTIVE =1 
        AND seat.SEAT_STATUS = 1
        AND seat.SEAT_TYPE = 1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function selectKaraoke()
    {
        $sql = "SELECT * FROM ZONE JOIN (SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,
        seat.SEAT_ZONE,karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE FROM seat JOIN karaoke
        ON seat.SEAT_ID = karaoke.KARAOKE_ID
        WHERE seat.SEAT_STATUS = 1
        AND seat.SEAT_ACTIVE = 1
        AND seat.SEAT_QUEUE = 1) as karaoke
        ON karaoke.SEAT_ZONE = zone.ZONE_ID";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
