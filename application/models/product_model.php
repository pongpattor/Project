<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product_model extends CI_Model
{

    public function product($search, $productActive, $limit, $offset)
    {
        $sql = "SELECT product.PRODUCT_ID,product.PRODUCT_NAME,product.PRODUCT_COSTPRICE,product.PRODUCT_STATUS,product.PRODUCT_ACTIVE,
                        product.PRODUCT_SELLPRICE,product.PRODUCT_IMAGE,typeproduct.TYPEPRODUCT_NAME,typeproduct.TYPEPRODUCT_GROUP
                FROM product 
                    LEFT JOIN typeproduct  ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                WHERE product.PRODUCT_STATUS = '1' 
                AND
                (
                product.PRODUCT_ID LIKE ? OR
                product.PRODUCT_NAME LIKE ? OR
                product.PRODUCT_COSTPRICE = ? OR
                product.PRODUCT_SELLPRICE = ? OR
                typeproduct.TYPEPRODUCT_NAME LIKE ?
                )
                AND product.PRODUCT_ACTIVE in ($productActive)
                LIMIT $offset,$limit
                ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function CountAllProduct($search, $productActive)
    {
        $sql = "SELECT COUNT(*) AS cnt
                FROM product 
                    LEFT JOIN typeproduct  ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                WHERE product.PRODUCT_STATUS = '1' 
                AND
                (
                product.PRODUCT_ID LIKE ? OR
                product.PRODUCT_NAME LIKE ? OR
                product.PRODUCT_COSTPRICE = ? OR
                product.PRODUCT_SELLPRICE = ? OR
                typeproduct.TYPEPRODUCT_NAME LIKE ?
                )
                AND product.PRODUCT_ACTIVE IN ($productActive)
                ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search),
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


    public function editProduct($productID)
    {
        $sql = "SELECT product.PRODUCT_ID,product.PRODUCT_NAME,product.PRODUCT_COSTPRICE,product.PRODUCT_SELLPRICE,
                       product.PRODUCT_IMAGE,product.PRODUCT_ACTIVE,typeproduct.TYPEPRODUCT_ID,typeproduct.TYPEPRODUCT_GROUP
                FROM product LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                WHERE product.PRODUCT_ID = '$productID'";
        $query = $this->db->query($sql);
        return $query->result();
    }

}
