<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotion_model extends CI_Model
{
    public function promotion($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM promotion 
        WHERE PROMOTION_STATUS in(0,1,2) AND
        (
            PROMOTION_ID like ? OR
            PROMOTION_NAME like ? OR
            PROMOTION_DISCOUNT_PERCENT like ? OR
            PROMOTION_START like ? OR
            PROMOTION_END like ? OR
            PROMOTION_STATUS LIKE ?
        )
        ORDER BY PROMOTION_ID DESC
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
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function CountAllPromotion($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM promotion 
        WHERE PROMOTION_STATUS in(0,1) AND
        (
            PROMOTION_ID like ? OR
            PROMOTION_NAME like ? OR
            PROMOTION_DISCOUNT_PERCENT like ? OR
            PROMOTION_START like ? OR
            PROMOTION_END like ? OR
            PROMOTION_STATUS LIKE ?
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
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function promotionProduct()
    {
        $sql = "SELECT PRODUCT_ID,PRODUCT_NAME FROM product
        ORDER BY PRODUCT_NAME";
        return $this->db->query($sql)->result();
    }

    public function CountAllProduct()
    {
        $sql = "SELECT COUNT(*) as cnt from product";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }


    public function editProduct($promotionID)
    {
        $sql = "SELECT * FROM promotion 
        WHERE PROMOTION_ID = '$promotionID'";
        return $this->db->query($sql)->result();
    }

    public function productInPromotion($promotionID)
    {
        $sql = "SELECT pd.PRODUCT_ID,pd.PRODUCT_NAME FROM product pd 
        LEFT JOIN promotiondetail pmd
        ON pd.PRODUCT_ID = pmd.DETAIL_PROMOTION_PRODUCT
        LEFT JOIN promotion pm
        ON pm.PROMOTION_ID = pmd.DETAIL_PROMOTION_ID
        WHERE pm.PROMOTION_ID = '$promotionID'
        ORDER BY pd.PRODUCT_NAME";
        $query =  $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function productNotInPromotion($productID = "")
    {
        if ($productID == null) {
            $sql = "SELECT PRODUCT_ID,PRODUCT_NAME FROM product
            WHERE PRODUCT_ID NOT IN (\"\")";
        } else {
            $sql = "SELECT PRODUCT_ID,PRODUCT_NAME FROM product
            WHERE PRODUCT_ID NOT IN ($productID)";
        }

        $query =  $this->db->query($sql);

        echo '<pre>';
        print_r($this->db->last_query($query));
        echo '</pre>';
        return $query->result();
    }

    public function deletePromotion($promotionID)
    {
        $sql = "UPDATE promotion SET PROMOTION_STATUS =3
        WHERE PROMOTION_ID = '$promotionID'";
        $query =  $this->db->query($sql);
        return $query->result();
    }
}
