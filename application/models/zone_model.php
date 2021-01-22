<?php
defined('BASEPATH') or exit('No direct script access allowed');

class zone_model extends CI_Model
{

    //Department Start
    public function zone($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM zone 
        where 
        (
            ZONE_ID LIKE  ? OR
            ZONE_NAME LIKE ? 
        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllZone($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM zone 
        where 
        (
            ZONE_ID LIKE  ? OR
            ZONE_NAME LIKE ? 
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
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

    
}
