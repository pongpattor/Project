<?php
defined('BASEPATH') or exit('No direct script access allowed');

class typeproduct_model extends CI_Model
{
    public function typeProduct($search ,$typeProductGroup, $limit, $offset)
    {
        $sql = "SELECT * FROM typeproduct 
        where 
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? 
        )
        AND
        TYPEPRODUCT_GROUP IN($typeProductGroup)
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

    public function countAllTypeProduct($search ,$typeProductGroup )
    {
        $sql = "SELECT COUNT(*) as cnt FROM typeproduct 
        where
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? 
        )
        AND
        TYPEPRODUCT_GROUP IN($typeProductGroup)
        ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
}
