<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue_model extends CI_Model
{

    public function queue($search, $queueActive, $limit, $offset)
    {
        $sql = "SELECT que.QUEUE_ID,que.QUEUE_CUSNAME,que.QUEUE_CUSTEL,que.QUEUE_CUSAMOUNT,que.QUEUE_ACTIVE,
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
                         AND queue.QUEUE_ACTIVE IN ($queueActive)    
                         AND queue.QUEUE_STATUS = '1'                
                    GROUP BY queue.QUEUE_ID) que
                    ORDER BY que.QUEUE_ACTIVE ASC,que.QUEUE_DSTART ASC ,que.QUEUE_TSTART
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

    public function countAllQueue($search, $queueActive)
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
        AND queue.QUEUE_STATUS = '1'   
        AND queue.QUEUE_STATUS IN ($queueActive)    
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

    public function queueTime($TypeId)
    {
        $sql = "SELECT QUEUETYPE_TIME FROM queuetype
        WHERE QUEUETYPE_ID = '$TypeId'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function checkCallQueue($tel, $date, $type)
    {
        $sql = "SELECT COUNT(*) as cnt FROM queue
        WHERE QUEUE_DSTART = '$date'
        AND QUEUE_CUSTEL = '$tel'
        AND QUEUE_STATUS = '1'
        AND QUEUE_ACTIVE = '1'
        AND QUEUE_TYPE = '$type'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function queueTimeOut()
    {
        $sql = "UPDATE queue
        SET QUEUE_ACTIVE = '3'
        WHERE QUEUE_ID IN (
        SELECT QUEUE_ID FROM queue
        WHERE (QUEUE_DEND <= CURRENT_DATE
        AND QUEUE_TEND < CURRENT_TIME
        AND QUEUE_STATUS = '1'
        AND QUEUE_ACTIVE = '1'))";
        $this->db->query($sql);
    }

    public function checkStatusQueue($queueID)
    {
        $sql = "SELECT QUEUE_ACTIVE FROM queue
        WHERE QUEUE_ID = '$queueID'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->QUEUE_ACTIVE;
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
        WHERE QUEUE_DSTART = '$date'
        AND QUEUE_ACTIVE = '1'
                    GROUP BY queueseat.QS_SEATID))
        AND SEAT_QUEUE = '1'
        AND SEAT_ACTIVE != '0'
        AND SEAT_STATUS = '1') s
        ON zone.ZONE_ID = s.SEAT_ZONE";
        $query = $this->db->query($sql);
        //    echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function editqueue($queueID)
    {
        $sql = "SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME,
        queue.QUEUE_ID,queue.QUEUE_CUSNAME,queue.QUEUE_CUSTEL,queue.QUEUE_CUSAMOUNT,queue.QUEUE_ACTIVE,
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
        $sql = "SELECT seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_TYPE,zone.ZONE_NAME,qs.QS_QUEUEID,qs.QS_SEATID,qs.QSK_KARAOKEUSETYPE,qs.QSK_KARAOKEUSEAMOUNT FROM seat 
            JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID
            JOIN (
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

    public function queueCheckIn($queueID)
    {
        $sql = "SELECT
        queue.QUEUE_ID,
        seat.SEAT_TYPE,
        seat.SEAT_ID,
        queuekaraoke.QSK_KARAOKEUSETYPE,
        queuekaraoke.QSK_KARAOKEUSEAMOUNT 
        FROM
        queue
        INNER JOIN queueseat ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        INNER JOIN seat ON queueseat.QS_SEATID = seat.SEAT_ID
        LEFT JOIN queuekaraoke ON queueseat.QS_SEATID = queuekaraoke.QSK_KARAOKEID 
        WHERE
        QUEUE_ID = '$queueID'
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }


    public function queueWalkin($search, $queueActive, $limit, $offset)
    {
        $sql = "SELECT
        QUEUE_ID,QUEUE_CUSNAME,QUEUE_CUSTEL,QUEUE_CUSAMOUNT,QUEUE_DSTART,
        QUEUE_TSTART,QUEUE_DEND,QUEUE_TEND,QUEUE_NOTE,QUEUE_ACTIVE  
    FROM
        queue 
    WHERE
        QUEUE_TYPE = '2' 
        AND QUEUE_STATUS = '1'
        AND QUEUE_ACTIVE IN ( $queueActive ) 
        AND (
            QUEUE_ID LIKE ? 
            OR QUEUE_CUSNAME LIKE ?
            OR QUEUE_CUSTEL LIKE ?
            OR QUEUE_CUSAMOUNT LIKE ?
            OR QUEUE_DSTART LIKE ? 
            OR QUEUE_TSTART LIKE ?
            OR QUEUE_DEND LIKE ?
            OR QUEUE_TEND LIKE ? 
            OR QUEUE_NOTE LIKE ?
        )
        ORDER BY QUEUE_ACTIVE ASC,QUEUE_DSTART ASC,QUEUE_TSTART ASC
    LIMIT $offset,$limit   
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
            )
        );

        return $query->result();
    }


    public function countAllQueueWalkin($search, $queueActive)
    {
        $sql = "SELECT
        COUNT(*) as cnt
    FROM
        queue 
    WHERE
        QUEUE_TYPE = '2' 
        AND QUEUE_STATUS = '1'
        AND QUEUE_ACTIVE IN ( $queueActive) 
        AND (
            QUEUE_ID LIKE ? 
            OR QUEUE_CUSNAME LIKE ?
            OR QUEUE_CUSTEL LIKE ?
            OR QUEUE_CUSAMOUNT LIKE ?
            OR QUEUE_DSTART LIKE ? 
            OR QUEUE_TSTART LIKE ?
            OR QUEUE_DEND LIKE ?
            OR QUEUE_TEND LIKE ? 
            OR QUEUE_NOTE LIKE ?
        )  
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
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function editQueueWalkin($queueID)
    {
        $sql = "SELECT
        QUEUE_ID,
        QUEUE_CUSNAME,
        QUEUE_CUSTEL,
        QUEUE_CUSAMOUNT,
        QUEUE_NOTE 
    FROM
        queue 
    WHERE
        QUEUE_ID = '$queueID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function walkinTimeOut()
    {
        $sql = "UPDATE queue 
        SET QUEUE_ACTIVE = '3' 
        WHERE QUEUE_ID IN ( SELECT QUEUE_ID FROM queue 
                            WHERE QUEUE_TYPE = '2' 
                            AND QUEUE_DEND <= CURRENT_DATE 
                            AND QUEUE_TEND < CURRENT_TIME 
                            AND QUEUE_ACTIVE = '0' 
                            AND QUEUE_STATUS = '1' )";
        $this->db->query($sql);
    }
}
