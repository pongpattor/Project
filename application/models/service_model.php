<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service_model extends CI_Model
{
    public function deskEmpty()
    {
        $sql = "SELECT SEAT_ID,SEAT_NAME,SEAT_AMOUNT,SEAT_ZONE FROM seat
        WHERE SEAT_STATUS = '1'
        AND SEAT_TYPE = '1'
        AND SEAT_ACTIVE = '1'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        GROUP BY queueseat.QS_SEATID )";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function karaokeEmpty()
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE,
        karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE
        FROM seat 
        INNER JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
        WHERE SEAT_STATUS = '1'
        AND SEAT_TYPE = '2'
        AND SEAT_ACTIVE = '1'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        GROUP BY queueseat.QS_SEATID )";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
