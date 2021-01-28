<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotionset_model extends CI_Model
{
    public function promotionSet($search, $limit, $offset)
    {
        $sql = "SELECT PROMOTIONSET_ID,PROMOTIONSET_NAME,PROMOTIONSET_COST,PROMOTIONSET_PRICE,
                       PROMOTIONSET_DATESTART,PROMOTIONSET_DATEEND 
                FROM promotionset
                WHERE
                PROMOTIONSET_STATUS = '1'
                AND
                (
                    PROMOTIONSET_ID LIKE ? OR
                    PROMOTIONSET_NAME LIKE ? OR
                    PROMOTIONSET_COST LIKE ? OR
                    PROMOTIONSET_PRICE LIKE ? OR
                    PROMOTIONSET_DATESTART LIKE ? OR
                    PROMOTIONSET_DATEEND LIKE ?
                )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search). '%',
                $this->db->escape_like_str($search). '%',

            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllPromotionSet($search)
    {
        $sql = "SELECT COUNT(*) AS cnt
                FROM promotionset
                WHERE
                PROMOTIONSET_STATUS = '1'
                AND
                (
                PROMOTIONSET_ID LIKE ? OR
                PROMOTIONSET_NAME LIKE ? OR
                PROMOTIONSET_COST LIKE ? OR
                PROMOTIONSET_PRICE LIKE ? OR
                PROMOTIONSET_DATESTART LIKE ? OR
                PROMOTIONSET_DATEEND LIKE ?
                )
                ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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
