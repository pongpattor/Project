<?php
defined('BASEPATH') or exit('No direct script access allowed');

class desk_model extends CI_Model
{
  
    function desk($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM desk 
        where DESK_STATUS IN (0,1,2) and  
        (
            DESK_ID LIKE  ? OR
            DESK_NUMBER LIKE ? OR
            DESK_STATUS LIKE ? 

        )
        ORDER BY DESK_STATUS ASC ,DESK_ID ASC
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    function countAllDesk($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM desk 
        where
        DESK_STATUS IN(0,1,2) AND
        (
            DESK_ID LIKE  ? OR
            DESK_NUMBER LIKE ? OR
            DESK_STATUS LIKE ? 
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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

    public function maxID()
    {
        $sql = "SELECT MAX(DESK_ID) as MID from desk";
        $Max =  $this->db->query($sql)->result();
        foreach ($Max as $row) {
            return $row->MID;
        }
    }

    function checkNumber($number)
    {
        $sql = "SELECT COUNT(DESK_NUMBER) as CD FROM desk where DESK_NUMBER = '$number'";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->CD;
        }
    }

    function delDesk($ID)
    {
        $sql = "UPDATE desk SET DESK_STATUS = '3' WHERE DESK_ID = '$ID'";
        return $this->db->query($sql);
    }

    
}
