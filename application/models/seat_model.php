<?php
defined('BASEPATH') or exit('No direct script access allowed');

class seat_model extends CI_Model
{

    //Department Start
    public function desk($search, $deskActive, $limit, $offset)
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ACTIVE,SEAT_QUEUE,zone.ZONE_NAME
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
        AND seat.SEAT_ACTIVE IN ($deskActive)
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

    public function countAlldesk($search, $deskActive)
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
        AND seat.SEAT_ACTIVE IN ($deskActive)
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

    public function editDesk($deskID)
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ACTIVE,seat.SEAT_ZONE,seat.SEAT_QUEUE FROM seat LEFT JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID
                WHERE SEAT_ID = '$deskID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function karaoke($search, $karaokeActive, $limit, $offset)
    {
        $sql = "SELECT * FROM ZONE 
        RIGHT JOIN (SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE,seat.SEAT_ACTIVE,
                     karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE,seat.SEAT_QUEUE 
                FROM seat JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
                WHERE seat.SEAT_STATUS != '0' 
                AND seat.SEAT_TYPE = '2') s
        ON zone.ZONE_ID = s.SEAT_ZONE
        WHERE  (zone.ZONE_NAME LIKE ?	OR
                s.SEAT_ID LIKE  ? OR
                s.SEAT_NAME LIKE ? OR
                s.SEAT_AMOUNT LIKE ? OR
                s.KARAOKE_PRICEPERHOUR LIKE ? OR
                s.KARAOKE_FLATRATE LIKE ?
                )
        AND s.SEAT_ACTIVE IN ($karaokeActive)
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllKaraoke($search, $karaokeActive)
    {
        $sql = "SELECT COUNT(*) as cnt FROM ZONE 
        RIGHT JOIN (SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE,
                    seat.SEAT_ACTIVE,karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE,seat.SEAT_QUEUE 
                FROM seat JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
                WHERE seat.SEAT_STATUS != '0' 
                AND seat.SEAT_TYPE = '2') s
        ON zone.ZONE_ID = s.SEAT_ZONE
        WHERE   (zone.ZONE_NAME LIKE ?	OR
                s.SEAT_ID LIKE  ? OR
                s.SEAT_NAME LIKE ? OR
                s.SEAT_AMOUNT LIKE ? OR
                s.KARAOKE_PRICEPERHOUR LIKE ? OR
                s.KARAOKE_FLATRATE LIKE ?
                )
                AND s.SEAT_ACTIVE IN ($karaokeActive)
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function editKaraoke($karaokeID)
    {
        $sql = "SELECT * FROM ZONE 
                RIGHT JOIN  (SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE,seat.SEAT_ACTIVE,
                             karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE,seat.SEAT_QUEUE
                        FROM seat JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
                        WHERE seat.SEAT_STATUS != '0' 
                        AND seat.SEAT_TYPE = '2') s
                ON zone.ZONE_ID = s.SEAT_ZONE
                WHERE  s.SEAT_ID = '$karaokeID'";
        $query = $this->db->query($sql);
        return $query->result();
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
}
