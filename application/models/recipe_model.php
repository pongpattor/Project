<?php
defined('BASEPATH') or exit('No direct script access allowed');

class recipe_model extends CI_Model
{
    public function recipe($search, $limit, $offset)
    {
        $sql = "SELECT recipe.RECIPE_ID,product.PRODUCT_NAME FROM product
        JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_ID
        AND
        (
            recipe.RECIPE_ID LIKE  ? OR
            product.PRODUCT_NAME LIKE ? 

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

    public function countAllRecipe($search)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM product
        JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_ID
        AND
        (
            recipe.RECIPE_ID LIKE  ? OR
            product.PRODUCT_NAME LIKE ? 

        )";

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
