<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ingredient_model extends CI_Model
{
    public function ingredient($search, $ingredientActive, $limit, $offset)
    {
        $sql = "SELECT INGREDIENT_ID,INGREDIENT_NAME,INGREDIENT_ACTIVE FROM ingredient 
        where INGREDIENT_STATUS = '1'
        AND
        (
            INGREDIENT_ID LIKE  ? OR
            INGREDIENT_NAME LIKE ? 
        )
        AND
        INGREDIENT_ACTIVE IN($ingredientActive)
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

    public function countAllIngredient($search,$ingredientActive)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM ingredient 
        where INGREDIENT_STATUS = '1'
        AND
        (
            INGREDIENT_ID LIKE  ? OR
            INGREDIENT_NAME LIKE ? 
        )
        AND
        INGREDIENT_ACTIVE IN($ingredientActive)
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
