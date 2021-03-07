<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue_model extends CI_Model
{

    public function queue($search, $limit, $offset)
    {
        $sql = "SELECT que.QUEUE_ID,que.QUEUE_CUSNAME,que.QUEUE_CUSTEL,que.QUEUE_CUSAMOUNT,
                       que.QUEUE_DTSTART,que.QUEUE_DTEND,que.QUEUE_NOTE,RPAD(LPAD(que.QUEUE_ID,13,\"'\"),14,\"'\") as 'QUEUEID' 
                FROM (SELECT * FROM queue JOIN 
	                        (SELECT queueseat.QS_QUEUEID,seat.SEAT_NAME,seat.SEAT_ID FROM queueseat JOIN seat
		                    ON queueseat.QS_SEATID = seat.SEAT_ID) qs
	                    ON queue.QUEUE_ID = qs.QS_QUEUEID
                        WHERE queue.QUEUE_STATUS = 1
                        AND(
	                        queue.QUEUE_ID like ? OR
	                        queue.QUEUE_CUSNAME like ? OR
	                        queue.QUEUE_CUSTEL like ? OR
	                        queue.QUEUE_CUSAMOUNT like ? OR
	                        queue.QUEUE_DTSTART like ? OR
	                        queue.QUEUE_DTEND like ? OR
	                        queue.QUEUE_NOTE like ? OR
	                        qs.SEAT_NAME like ?
                         )
                    GROUP BY queue.QUEUE_ID) que
                LIMIT $offset,$limit ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllQueue($search)
    {
        $sql = "SELECT COUNT(*) as 'cnt' 
        FROM (SELECT * FROM queue JOIN 
        (SELECT queueseat.QS_QUEUEID,seat.SEAT_NAME,seat.SEAT_ID FROM queueseat JOIN seat
        ON queueseat.QS_SEATID = seat.SEAT_ID) qs
        ON queue.QUEUE_ID = qs.QS_QUEUEID
        WHERE queue.QUEUE_STATUS = 1
        AND(
             queue.QUEUE_ID like ? OR
             queue.QUEUE_CUSNAME like ? OR
             queue.QUEUE_CUSTEL like ? OR
             queue.QUEUE_CUSAMOUNT like ? OR
             queue.QUEUE_DTSTART like ? OR
             queue.QUEUE_DTEND like ? OR
             queue.QUEUE_NOTE like ? OR
             qs.SEAT_NAME like ?
          )
        GROUP BY queue.QUEUE_ID) que
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function selectQueueSeat($queueID)
    {
        $sql = "SELECT queueseat.QS_QUEUEID,seat.SEAT_NAME 
                FROM queueseat JOIN seat ON queueseat.QS_SEATID = seat.SEAT_ID
                WHERE queueseat.QS_QUEUEID IN ($queueID)";
        $query = $this->db->query($sql);
        //   echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function queueTime()
    {
        $sql = "SELECT QUEUETYPE_TIME FROM queuetype
        WHERE QUEUETYPE_ID = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function CheckQueue($tel, $date)
    {
        $sql = "SELECT COUNT(*) as cnt FROM queue
        WHERE DATEDIFF(QUEUE_DTSTART, '$date') = 0
        AND QUEUE_CUSTEL = '$tel'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
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

    public function editqueue($queueID)
    {
        $sql = "SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME,
        queue.QUEUE_ID,queue.QUEUE_CUSNAME,queue.QUEUE_CUSTEL,queue.QUEUE_CUSAMOUNT,
        queue.QUEUE_DTSTART,queue.QUEUE_NOTE,qs.amt
        FROM queue JOIN employee 
        ON queue.QUEUE_EMPLOYEE = employee.EMPLOYEE_ID
        JOIN  (SELECT queueseat.QS_QUEUEID,SUM(seat.SEAT_AMOUNT) AS amt FROM queueseat JOIN seat ON queueseat.QS_SEATID = seat.SEAT_ID
        GROUP BY queueseat.QS_QUEUEID) qs
        ON qs.QS_QUEUEID = queue.QUEUE_ID
        where queue.QUEUE_ID = '$queueID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editQueueSeat($queueID)
    {
        $sql = "SELECT seat.SEAT_NAME,seat.SEAT_TYPE,qs.QS_QUEUEID,qs.QS_SEATID,qs.QSK_KARAOKEUSETYPE,qs.QSK_KARAOKEUSEAMOUNT FROM seat JOIN (
            SELECT queueseat.QS_QUEUEID,queueseat.QS_SEATID,queuekaraoke.QSK_KARAOKEUSETYPE,queuekaraoke.QSK_KARAOKEUSEAMOUNT
            FROM queueseat LEFT JOIN queuekaraoke
            ON (queueseat.QS_QUEUEID = queuekaraoke.QSK_QUEUEID AND queueseat.QS_SEATID = queuekaraoke.QSK_KARAOKEID)) qs
            ON seat.SEAT_ID = qs.QS_SEATID
            WHERE qs.QS_QUEUEID = '$queueID'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
