<?php
defined('BASEPATH') or exit('No direct script access allowed');

class seat_model extends CI_Model
{

    //Department Start
    public function desk($search = '', $limit, $offset)
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,zone.ZONE_NAME
        FROM seat LEFT JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID 
        where seat.SEAT_TYPE = '1' 
        AND seat.SEAT_STATUS != '0'
        AND
        (
            seat.SEAT_ID LIKE  ? OR
            seat.SEAT_NAME LIKE ? OR
            seat.SEAT_AMOUNT LIKE ? OR
            zone.ZONE_NAME LIKE ?
        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAlldesk($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM seat LEFT JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID 
        where seat.SEAT_TYPE = '1' 
        AND seat.SEAT_STATUS != '0'
        AND
        (
            seat.SEAT_ID LIKE  ? OR
            seat.SEAT_NAME LIKE ? OR
            seat.SEAT_AMOUNT LIKE ? OR
            zone.ZONE_NAME LIKE ?
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function checkSeatName($seatName)
    {
        $sql = "SELECT COUNT(*)  AS cnt FROM seat
                WHERE SEAT_NAME = '$seatName'
                AND SEAT_STATUS != '0'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function editDesk($deskID)
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE FROM seat LEFT JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID
                WHERE SEAT_ID = '$deskID'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
