<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service_model extends CI_Model
{

    public function service($search, $limit, $offset)
    {
        $sql = "SELECT
        service.SERVICE_ID,
        service.SERVICE_CUSAMOUNT,
        service.SERVICE_DSTART,
        service.SERVICE_TSTART,
        CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEAT_NAMES,
        RPAD( LPAD( SERVICE_ID, 13, \"'\" ), 14, \"'\" ) AS serID 
         FROM
        service
        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
        WHERE
        service.SERVICE_ACTIVE = '1' 
        AND service.SERVICE_STATUS = '1' 
        AND (
            service.SERVICE_ID LIKE ? 
            OR service.SERVICE_CUSAMOUNT LIKE ? 
            OR service.SERVICE_DSTART LIKE ? 
            OR service.SERVICE_TSTART LIKE ? 
            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
        )
        LIMIT $offset,$limit
        ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllService($search)
    {
        $sql = "SELECT
        COUNT(*) as cnt
         FROM
        service
        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
        WHERE
        service.SERVICE_ACTIVE = '1' 
        AND service.SERVICE_STATUS = '1' 
        AND (
            service.SERVICE_ID LIKE ? 
            OR service.SERVICE_CUSAMOUNT LIKE ? 
            OR service.SERVICE_DSTART LIKE ? 
            OR service.SERVICE_TSTART LIKE ? 
            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );

        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function fetchServiceSeat($serviceID)
    {
        $sql = "SELECT
        serviceseat.SERSEAT_SERVICEID,
        CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEAT_NAMES 
    FROM
        serviceseat
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
    WHERE
        serviceseat.SERSEAT_SERVICEID IN ( $serviceID )";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function deskEmpty()
    {
        $sql = "SELECT SEAT_ID,SEAT_NAME,SEAT_AMOUNT,SEAT_ZONE FROM seat
        WHERE SEAT_STATUS = '1'
        AND SEAT_TYPE = '1'
        AND SEAT_ACTIVE = '0'
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
        AND SEAT_ACTIVE = '0'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        GROUP BY queueseat.QS_SEATID )";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
