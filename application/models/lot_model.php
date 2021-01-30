<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lot_model extends CI_Model
{
    public function lotDrink($search, $limit, $offset)
    {
        $sql = "SELECT LOT_ID,LOT_DATE,LOT_TIME,LOT_TOTAL FROM lot
        WHERE LOT_STATUS = '1'
        AND LOT_TYPE ='1'
        AND
            (	
                LOT_ID LIKE ? OR
                LOT_TOTAL LIKE  ? OR
                LOT_DATE LIKE  ? OR
                LOT_TIME LIKE  ?
            )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllLotDrink($search)
    {
        $sql = "SELECT COUNT(*) as cnt FROM lot
        WHERE LOT_STATUS = '1'
        AND LOT_TYPE ='1'
        AND
            (	
                LOT_ID LIKE ? OR
                LOT_TOTAL LIKE  ? OR
                LOT_DATE LIKE  ? OR
                LOT_TIME LIKE  ?
            )
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function drink()
    {
        $sql = "SELECT product.PRODUCT_ID,product.PRODUCT_NAME FROM product
        join typeproduct 
        ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
        WHERE typeproduct.TYPEPRODUCT_GROUP = '2'
        AND product.PRODUCT_STATUS = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editLotDrink($lotDrinkID)
    {
        $sql = "SELECT LOT_ID,LOT_TOTAL,LOT_DATE,LOT_TIME,LOT_EMPLOYEE
                FROM lot WHERE LOT_ID = '$lotDrinkID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editLotDetail($lotDrinkID)
    {
        $sql = "SELECT  lotdetail.LOTDETAIL_PRICE,product.PRODUCT_ID,product.PRODUCT_NAME FROM lotdetail
        JOIN lotdrink ON lotdetail.LOTDETAIL_ID = lotdrink.LOTDRINK_ID AND lotdetail.LOTDETAIL_NO = lotdrink.LOTDRINK_NO
        JOIN product ON lotdrink.LOTDRINK_DRINK = product.PRODUCT_ID
        WHERE lotdetail.LOTDETAIL_ID = '$lotDrinkID' 
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
