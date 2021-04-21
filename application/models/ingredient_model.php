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

    public function countAllIngredient($search, $ingredientActive)
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

    public function checkIngreForDel($ingredientID)
    {
        $sql = "SELECT COUNT(*) as cnt FROM ingredient
        JOIN recipedetail ON ingredient.INGREDIENT_ID = recipedetail.RECIPEDETAIL_INGREDIENT
        JOIN recipe ON recipe.RECIPE_ID = recipedetail.RECIPEDETAIL_RECIPEID
        JOIN product ON product.PRODUCT_ID = recipe.RECIPE_PRODUCT
        WHERE product.PRODUCT_STATUS = '1'
        AND ingredient.INGREDIENT_ID = '$ingredientID'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
}
