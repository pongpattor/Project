<?php
defined('BASEPATH') or exit('No direct script access allowed');

class recipe_model extends CI_Model
{
    public function recipe($search, $limit, $offset)
    {
        $sql = "SELECT recipe.RECIPE_ID,product.PRODUCT_NAME FROM product
        JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_PRODUCT
        WHERE
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
        JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_PRODUCT
        WHERE
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

    public function editRecipe($recipeID)
    {
        $sql = "SELECT recipe.RECIPE_ID,product.PRODUCT_ID,product.PRODUCT_NAME 
                FROM recipe JOIN product ON recipe.RECIPE_PRODUCT = product.PRODUCT_ID
                WHERE recipe.RECIPE_ID = '$recipeID' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editRecipeDetail($recipeID)
    {
        $sql = "SELECT ingredient.INGREDIENT_ID,ingredient.INGREDIENT_NAME,recipedetail.RECIPEDETAIL_IMPORTANT FROM recipedetail JOIN ingredient
        ON recipedetail.RECIPEDETAIL_INGREDIENT = ingredient.INGREDIENT_ID
        WHERE recipedetail.RECIPEDETAIL_RECIPEID = '$recipeID' ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
