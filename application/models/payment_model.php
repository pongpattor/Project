<?php
defined('BASEPATH') or exit('No direct script access allowed');

class payment_model extends CI_Model
{
    public function paymentNormal($serviceID)
    {
        $sql = "SELECT
        service.SERVICE_ID,
        servicedetail.DTSER_TYPEORDER,
        IFNULL( product.PRODUCT_NAME, IFNULL( promotionset.PROMOTIONSET_NAME, seat.SEAT_NAME ) ) AS ORDERNAME,
        servicedetailkaraoke.KARADTSER_USETYPE,
        SUM( servicedetail.DTSER_AMOUNT ) AS AMOUNT,
        pro.PROMOTIONPRICE_ID,
        IFNULL( product.PRODUCT_COSTPRICE, NULL ) AS COSTPRICE,
        IFNULL(
            product.PRODUCT_SELLPRICE,
            IFNULL( promotionset.PROMOTIONSET_PRICE, CASE WHEN servicedetailkaraoke.KARADTSER_USETYPE = '1' THEN karaoke.KARAOKE_FLATRATE ELSE karaoke.KARAOKE_PRICEPERHOUR END ) 
        ) AS SELLPRICE,
        FORMAT( ( ( product.PRODUCT_SELLPRICE / 100 ) * pro.PROMOTIONPRICE_DISCOUNT ), '2' ) AS DISCOUNT,
    CASE
            WHEN servicedetail.DTSER_TYPEORDER = '3' THEN
        CASE
                WHEN servicedetailkaraoke.KARADTSER_USETYPE = '1' THEN
                karaoke.KARAOKE_FLATRATE ELSE (SUM( servicedetail.DTSER_AMOUNT )*karaoke.KARAOKE_PRICEPERHOUR) 
            END 
                WHEN servicedetail.DTSER_TYPEORDER = '2' THEN
                ( SUM( servicedetail.DTSER_AMOUNT ) * promotionset.PROMOTIONSET_PRICE ) ELSE ( SUM( servicedetail.DTSER_AMOUNT ) * product.PRODUCT_SELLPRICE ) 
            END AS SUMPRICE 
        FROM
            service
            JOIN servicedetail ON service.SERVICE_ID = servicedetail.DTSER_ID
            LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
            LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
            LEFT JOIN servicedetailkaraoke ON ( servicedetail.DTSER_ID = servicedetailkaraoke.KARADTSER_ID AND servicedetail.DTSER_NO = servicedetailkaraoke.KARADTSER_NO )
            LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
            LEFT JOIN product ON servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID
            LEFT JOIN karaoke ON servicedetailkaraoke.KARADTSER_KARAOKEID = karaoke.KARAOKE_ID
            LEFT JOIN seat ON karaoke.KARAOKE_ID = seat.SEAT_ID
            LEFT JOIN (
            SELECT
                promotionprice.PROMOTIONPRICE_ID,
                promotionprice.PROMOTIONPRICE_NAME,
                promotionprice.PROMOTIONPRICE_DISCOUNT,
                promotionpricedetail.PROPRICE_PRODUCT 
            FROM
                promotionprice
                JOIN promotionpricedetail ON promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID 
            WHERE
                ( CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND ) 
            ) pro ON product.PRODUCT_ID = pro.PROPRICE_PRODUCT 
        WHERE
            service.SERVICE_ID IN ($serviceID) 
        GROUP BY
            product.PRODUCT_ID,
            promotionset.PROMOTIONSET_ID,
            karaoke.KARAOKE_ID,
            servicedetailkaraoke.KARADTSER_USETYPE";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function telMemberDiscount($tel)
    {
        $sql = "SELECT
                customer.CUSTOMER_ID,
                customer.CUSTOMER_FIRSTNAME, customer.CUSTOMER_LASTNAME,
            CASE
                    WHEN customer.CUSTOMER_BDATE = CURRENT_DATE THEN
                    customertype.CUSTOMERTYPE_DISCOUNTBDATE ELSE customertype.CUSTOMERTYPE_DISCOUNT 
                END AS discount 
            FROM
                customer
                JOIN customertype ON customer.CUSTOMER_CUSTOMERTYPE = customertype.CUSTOMERTYPE_ID
                JOIN customertel ON customer.CUSTOMER_ID = customertel.CUSTOMERTEL_ID 
            WHERE
                customer.CUSTOMER_STATUS = '1' 
                AND customertel.CUSTOMERTEL_TEL = '$tel' 
            GROUP BY
                customer.CUSTOMER_ID
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function typePayment($search, $limit, $offset)
    {
        $sql = "SELECT TYPEPAYMENT_ID,TYPEPAYMENT_NAME FROM typepayment
        WHERE TYPEPAYMENT_STATUS = '1'
        AND (
                TYPEPAYMENT_ID LIKE ? OR
                TYPEPAYMENT_NAME LIKE ?
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
        return $query->result();
    }

    public function countAllTypePayment($search)
    {
        $sql = "SELECT COUNT(*) as cnt FROM typepayment
        WHERE TYPEPAYMENT_STATUS = '1'
        AND (
                TYPEPAYMENT_ID LIKE ? OR
                TYPEPAYMENT_NAME LIKE ?
                )
        ";

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

    public function checkTypePaymentName($typePaymentName)
    {
        $sql = "SELECT COUNT(*) as cnt FROM typepayment
                WHERE TYPEPAYMENT_NAME = '$typePaymentName'
                AND TYPEPAYMENT_STATUS = '1'
                ";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function editTypePayment($typePaymentID)
    {
        $sql = "SELECT TYPEPAYMENT_ID,TYPEPAYMENT_NAME FROM typepayment
        WHERE TYPEPAYMENT_ID = '$typePaymentID'
        AND TYPEPAYMENT_STATUS = '1'
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
