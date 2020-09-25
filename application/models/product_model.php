<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product_model extends CI_Model
{

    public function product($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM product 
        LEFT JOIN typeproduct  ON product.PRODUCT_TYPE = typeproduct.TYPEPRODUCT_ID
        WHERE 
        (
            product.PRODUCT_ID LIKE  ? OR
            product.PRODUCT_NAME LIKE ? OR
            product.PRODUCT_IMG LIKE ? OR
            product.PRODUCT_COSTPRICE LIKE ? OR
            product.PRODUCT_SELLPRICE LIKE ? OR
            typeproduct.TYPEPRODUCT_NAME LIKE ? OR
            typeproduct.TYPEPRODUCT_GROUP LIKE ?

        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',


            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function CountAllProduct($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM product 
        LEFT JOIN typeproduct  ON product.PRODUCT_TYPE = typeproduct.TYPEPRODUCT_ID
        WHERE 
        (
            product.PRODUCT_ID LIKE  ? OR
            product.PRODUCT_NAME LIKE ? OR
            product.PRODUCT_IMG LIKE ? OR
            product.PRODUCT_COSTPRICE LIKE ? OR
            product.PRODUCT_SELLPRICE LIKE ? OR
            typeproduct.TYPEPRODUCT_NAME LIKE ? OR
            typeproduct.TYPEPRODUCT_GROUP LIKE ?
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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


    public function editProduct($productID){
        $sql = "SELECT * FROM product 
        LEFT JOIN typeproduct ON typeproduct.TYPEPRODUCT_ID = product.PRODUCT_TYPE
        LEFT JOIN food ON food.PRODUCT_FOOD_ID = product.PRODUCT_ID
        WHERE product.PRODUCT_ID = '$productID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function typeProduct($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM typeproduct 
        where 
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? OR
            TYPEPRODUCT_GROUP LIKE ?

        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',

            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function maxProductID()
    {
        $sql = "SELECT MAX(PRODUCT_ID) as MID from product";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }



    public function countAllTypeProduct($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM typeproduct 
        where
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? OR
            TYPEPRODUCT_GROUP LIKE ?
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
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

    public function maxTypeProductId()
    {
        $sql = "SELECT MAX(TYPEPRODUCT_ID) as MID from typeproduct";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }

    public function checkTypeProductName($typeProductName, $typeProductGroup)
    {
        $sql = " SELECT COUNT(*) as cnt FROM  typeproduct
                WHERE TYPEPRODUCT_NAME = '$typeProductName'
                and TYPEPRODUCT_GROUP = '$typeProductGroup'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function checkTypeProductNameUpdate($typeProductName, $typeProductGroup)
    {
        $sql = " SELECT COUNT(*) as cnt FROM  typeproduct
                WHERE TYPEPRODUCT_NAME = '$typeProductName'
                and TYPEPRODUCT_GROUP = '$typeProductGroup'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }


    public function editTypeProduct($typeProductId)
    {
        $sql = "SELECT * FROM typeproduct WHERE TYPEPRODUCT_ID = '$typeProductId'";
        return $this->db->query($sql)->result();
    }

    public function meat($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM meat
        where 
        (
            MEAT_ID LIKE  ? OR
            MEAT_NAME LIKE ? 

        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllMeat($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM meat
        where
        (
            MEAT_ID LIKE  ? OR
            MEAT_NAME LIKE ? 
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
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

    public function checkMeatName($meatName)
    {
        $sql = "SELECT COUNT(*) as cnt FROM meat 
                WHERE MEAT_NAME LIKE ?";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($meatName) . '%',
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function maxMeatID()
    {
        $sql = "SELECT MAX(MEAT_ID) as MID FROM meat";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }


    public function fetch_typeProductName($typeProductGroup)
    {
        $sql = "SELECT TYPEPRODUCT_ID,TYPEPRODUCT_NAME from typeproduct where TYPEPRODUCT_GROUP = '$typeProductGroup'";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกประเภทสินค้า</option>';
        //  echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->TYPEPRODUCT_ID . '">' . $row->TYPEPRODUCT_NAME . '</option>';
        }
        return $output;
    }
}
