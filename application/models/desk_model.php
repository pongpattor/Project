<?php
defined('BASEPATH') or exit('No direct script access allowed');

class desk_model extends CI_Model
{
    function fetchDesk()
    {
        $sql = "SELECT * FROM desk where DESK_STATUS not in ('3') ORDER BY DESK_STATUS,DESK_ID ASC";
        return $this->db->query($sql)->result();

        // $this->db->limit($limit, $start);
        // $query = $this->db->get("desk");
        // return $query->result();
        // if ($query->num_rows() > 0) {
        //     foreach ($query->result() as $row) {
        //         $data[] = $row;
        //     }
        //     return $data;
        // }
        // return false;
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

    function searchDesk($search = '')
    {
        $this->db->select('*');
        $this->db->from('desk');
        $this->db->like('DESK_ID', $search);
        $this->db->or_like('DESK_NUMBER', $search);
        $query = $this->db->get();
        return $query->result();
    }

    function countDesk()
    {
        $sql = "SELECT COUNT(*) as cnt FROM desk";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->cnt;
        }
    }
}
