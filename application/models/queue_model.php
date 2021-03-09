<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue_model extends CI_Model
{

    public function queue($search, $queueStatus, $limit, $offset)
    {
        $sql = "SELECT que.QUEUE_ID,que.QUEUE_CUSNAME,que.QUEUE_CUSTEL,que.QUEUE_CUSAMOUNT,que.QUEUE_STATUS,
                       que.QUEUE_DSTART,que.QUEUE_TSTART,que.QUEUE_DEND,que.QUEUE_TEND,
                       que.QUEUE_NOTE,RPAD(LPAD(que.QUEUE_ID,13,\"'\"),14,\"'\") as 'QUEUEID' 
                FROM (SELECT * FROM queue JOIN 
	                        (SELECT queueseat.QS_QUEUEID,seat.SEAT_NAME,seat.SEAT_ID FROM queueseat JOIN seat
		                    ON queueseat.QS_SEATID = seat.SEAT_ID) qs
	                    ON queue.QUEUE_ID = qs.QS_QUEUEID
                        WHERE 
                        (
	                        queue.QUEUE_ID like ? OR
	                        queue.QUEUE_CUSNAME like ? OR
	                        queue.QUEUE_CUSTEL like ? OR
	                        queue.QUEUE_CUSAMOUNT like ? OR
	                        queue.QUEUE_DSTART like ? OR
                            queue.QUEUE_TSTART like ? OR
	                        queue.QUEUE_DEND like ? OR
                            queue.QUEUE_TEND like ? OR
	                        queue.QUEUE_NOTE like ? OR
	                        qs.SEAT_NAME like ?
                         )
                         AND queue.QUEUE_STATUS IN ($queueStatus)                    
                    GROUP BY queue.QUEUE_ID) que
                    ORDER BY que.QUEUE_STATUS ASC,que.QUEUE_DSTART ASC
                LIMIT $offset,$limit ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',

            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllQueue($search, $queueStatus)
    {
        $sql = "SELECT COUNT(*) as 'cnt' 
        FROM (SELECT * FROM queue JOIN 
        (SELECT queueseat.QS_QUEUEID,seat.SEAT_NAME,seat.SEAT_ID FROM queueseat JOIN seat
        ON queueseat.QS_SEATID = seat.SEAT_ID) qs
        ON queue.QUEUE_ID = qs.QS_QUEUEID
        WHERE (
            queue.QUEUE_ID like ? OR
	        queue.QUEUE_CUSNAME like ? OR
	        queue.QUEUE_CUSTEL like ? OR
	        queue.QUEUE_CUSAMOUNT like ? OR
	        queue.QUEUE_DSTART like ? OR
            queue.QUEUE_TSTART like ? OR
	        queue.QUEUE_DEND like ? OR
            queue.QUEUE_TEND like ? OR
	        queue.QUEUE_NOTE like ? OR
	        qs.SEAT_NAME like ?
          )
        AND queue.QUEUE_STATUS IN ($queueStatus)    
        GROUP BY queue.QUEUE_ID) que
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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
        WHERE QUEUE_DSTART = '$date'
        AND QUEUE_CUSTEL = '$tel'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function selectSeat($date)
    {
        $sql = "SELECT s.SEAT_ID,s.SEAT_NAME,s.SEAT_AMOUNT,s.SEAT_TYPE,
            s.SEAT_ZONE,s.KARAOKE_PRICEPERHOUR,s.KARAOKE_FLATRATE,zone.ZONE_NAME FROM zone
            JOIN
            (
            SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_TYPE,
            seat.SEAT_ZONE,karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE FROM seat 
            LEFT JOIN karaoke
            ON seat.SEAT_ID = karaoke.KARAOKE_ID
            WHERE SEAT_ID NOT IN((SELECT queueseat.QS_SEATID FROM queue JOIN queueseat 
            ON queue.QUEUE_ID = queueseat.QS_QUEUEID
            WHERE QUEUE_DSTART LIKE '$date'))
            AND SEAT_QUEUE = '1'
            AND SEAT_ACTIVE != '0'
            AND SEAT_STATUS = '1') s
            ON zone.ZONE_ID = s.SEAT_ZONE";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editqueue($queueID)
    {
        $sql = "SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME,
        queue.QUEUE_ID,queue.QUEUE_CUSNAME,queue.QUEUE_CUSTEL,queue.QUEUE_CUSAMOUNT,
        queue.QUEUE_DSTART, queue.QUEUE_TSTART,queue.QUEUE_NOTE,qs.amt
        FROM queue JOIN employee 
        ON queue.QUEUE_EMPLOYEE = employee.EMPLOYEE_ID
        JOIN  (SELECT queueseat.QS_QUEUEID,SUM(seat.SEAT_AMOUNT) AS amt FROM queueseat JOIN seat ON queueseat.QS_SEATID = seat.SEAT_ID
        GROUP BY queueseat.QS_QUEUEID) qs
        ON qs.QS_QUEUEID = queue.QUEUE_ID
        where queue.QUEUE_ID = '$queueID'";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function editQueueSeat($queueID)
    {
        $sql = "SELECT seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_TYPE,qs.QS_QUEUEID,qs.QS_SEATID,qs.QSK_KARAOKEUSETYPE,qs.QSK_KARAOKEUSEAMOUNT FROM seat JOIN (
            SELECT queueseat.QS_QUEUEID,queueseat.QS_SEATID,queuekaraoke.QSK_KARAOKEUSETYPE,queuekaraoke.QSK_KARAOKEUSEAMOUNT
            FROM queueseat LEFT JOIN queuekaraoke
            ON (queueseat.QS_QUEUEID = queuekaraoke.QSK_QUEUEID AND queueseat.QS_SEATID = queuekaraoke.QSK_KARAOKEID)) qs
            ON seat.SEAT_ID = qs.QS_SEATID
            WHERE qs.QS_QUEUEID = '$queueID'";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }
}
