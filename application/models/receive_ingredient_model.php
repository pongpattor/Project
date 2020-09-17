<?php
defined('BASEPATH') or exit('No direct script access allowed');

class receive_ingredient_model extends CI_Model
{


    public function fetchReceive($search='',$limit,$offset)
    {
        $sql = "SELECT * FROM receive_ingredient 
        where   
        (
            RECEIVE_INGREDIENT_ID LIKE  ? OR
            DATE_AT LIKE ? OR
            TOTAL_PRICE LIKE ? OR
            TIME_AT LIKE ?
        )
        ORDER BY DATE_AT DESC ,TIME_AT DESC
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        return $query->result();
    }

    public function countAllReceive($search=''){
        $sql = "SELECT COUNT(*) as cnt FROM receive_ingredient 
        where   
        (
            RECEIVE_INGREDIENT_ID LIKE  ? OR
            DATE_AT LIKE ? OR
            TOTAL_PRICE LIKE ? OR
            TIME_AT LIKE ?
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
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
    

    public function maxIdReceiveIngredien()
    {
        $sql = "SELECT MAX(RECEIVE_INGREDIENT_ID) as ID FROM receive_ingredient";
        $result   = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->ID;
        }
    }
}
