<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lot_model extends CI_Model
{
    public function lotDrink($search, $limit, $offset)
    {
        $sql = "SELECT lot.LOT_ID,lot.LOT_DATE,lot.LOT_TIME,lot.LOT_TOTAL, 
                       employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME
                FROM lot
                    JOIN employee ON lot.LOT_EMPLOYEE = employee.EMPLOYEE_ID
                WHERE LOT_STATUS = '1'
                AND LOT_TYPE ='1'
                AND
                    (	
                    lot.LOT_ID LIKE ? OR
                    lot.LOT_TOTAL LIKE ? OR
                    lot.LOT_DATE LIKE  ? OR
                    lot.LOT_TIME LIKE  ? OR
                    employee.EMPLOYEE_FIRSTNAME LIKE ? OR
                    employee.EMPLOYEE_LASTNAME LIKE ? 
                    )
                    LIMIT $offset,$limit
                ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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
                    JOIN employee ON lot.LOT_EMPLOYEE = employee.EMPLOYEE_ID
                WHERE LOT_STATUS = '1'
                AND LOT_TYPE ='1'
                AND
                    (	
                    lot.LOT_ID LIKE ? OR
                    lot.LOT_TOTAL LIKE ? OR
                    lot.LOT_DATE LIKE  ? OR
                    lot.LOT_TIME LIKE  ? OR
                    employee.EMPLOYEE_FIRSTNAME LIKE ? OR
                    employee.EMPLOYEE_LASTNAME LIKE ? 
                    )
                ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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
        $sql = "SELECT lot.LOT_ID,lot.LOT_TOTAL,lot.LOT_DATE,lot.LOT_TIME,
                       employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME
                FROM lot JOIN employee ON lot.LOT_EMPLOYEE = employee.EMPLOYEE_ID
                WHERE lot.LOT_ID = '$lotDrinkID'
                ";
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
