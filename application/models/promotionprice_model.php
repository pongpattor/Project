<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotionprice_model extends CI_Model
{
    public function promotionPrice($search, $limit, $offset)
    {
        $sql = "SELECT PROMOTIONPRICE_ID,PROMOTIONPRICE_NAME,PROMOTIONPRICE_DATESTART,PROMOTIONPRICE_DATEEND,PROMOTIONPRICE_DISCOUNT
        FROM promotionprice
        WHERE	PROMOTIONPRICE_STATUS = '1'
        AND
                        (
                            PROMOTIONPRICE_ID LIKE ? OR
                            PROMOTIONPRICE_NAME LIKE ? OR
                            PROMOTIONPRICE_DATESTART LIKE ? OR
                            PROMOTIONPRICE_DATEEND LIKE ? OR
                            PROMOTIONPRICE_DISCOUNT LIKE ?
                        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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

    public function countAllpromotionPrice($search)
    {
        $sql = "SELECT COUNT(*) as cnt
        FROM promotionprice
        WHERE	PROMOTIONPRICE_STATUS = '1'
        AND
                (
                    PROMOTIONPRICE_ID LIKE ? OR
                    PROMOTIONPRICE_NAME LIKE ? OR
                    PROMOTIONPRICE_DATESTART LIKE ? OR
                    PROMOTIONPRICE_DATEEND LIKE ? OR
                    PROMOTIONPRICE_DISCOUNT LIKE ?
                )
        ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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

    public function editPromotionPriceDetail($promotionPriceID)
    {
        $sql = "SELECT product.PRODUCT_ID,product.PRODUCT_NAME FROM promotionpricedetail
        JOIN product ON promotionpricedetail.PROPRICE_PRODUCT = product.PRODUCT_ID
        WHERE promotionpricedetail.PROPRICE_ID = '$promotionPriceID'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
