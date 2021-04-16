<?php
defined('BASEPATH') or exit('No direct script access allowed');

class payment_model extends CI_Model
{
    public function paymentNormal($serviceID)
    {
        $sql = "SELECT
        service.SERVICE_ID,
        servicedetail.DTSER_TYPEORDER,
        IFNULL( product.PRODUCT_ID, IFNULL( promotionset.PROMOTIONSET_ID, karaoke.KARAOKE_ID ) ) AS ORDERID,
        IFNULL( product.PRODUCT_NAME, IFNULL( promotionset.PROMOTIONSET_NAME, seat.SEAT_NAME ) ) AS ORDERNAME,
        servicedetailkaraoke.KARADTSER_USETYPE,
        SUM( servicedetail.DTSER_REMAINDER ) AS AMOUNT,
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
                karaoke.KARAOKE_FLATRATE ELSE (SUM( servicedetail.DTSER_REMAINDER )*karaoke.KARAOKE_PRICEPERHOUR) 
            END 
                WHEN servicedetail.DTSER_TYPEORDER = '2' THEN
                ( SUM( servicedetail.DTSER_REMAINDER ) * promotionset.PROMOTIONSET_PRICE ) ELSE ( SUM( servicedetail.DTSER_REMAINDER ) * product.PRODUCT_SELLPRICE ) 
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
            AND servicedetail.DTSER_REMAINDER > 0
        GROUP BY
            product.PRODUCT_ID,
            promotionset.PROMOTIONSET_ID,
            karaoke.KARAOKE_ID,
            servicedetailkaraoke.KARADTSER_USETYPE";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function paySplit($serviceID, $serviceNo)
    {
        $sql = "SELECT
                    service.SERVICE_ID,
                    servicedetail.DTSER_TYPEORDER,
                    IFNULL( product.PRODUCT_ID, IFNULL( promotionset.PROMOTIONSET_ID, karaoke.KARAOKE_ID ) ) AS ORDERID,
                    IFNULL( product.PRODUCT_NAME, IFNULL( promotionset.PROMOTIONSET_NAME, seat.SEAT_NAME ) ) AS ORDERNAME,
                    servicedetailkaraoke.KARADTSER_USETYPE,
                    SUM( servicedetail.DTSER_AMOUNT ) AS AMOUNT,
                    pro.PROMOTIONPRICE_ID,
                    IFNULL( product.PRODUCT_COSTPRICE, NULL ) AS COSTPRICE,
                    IFNULL(
                        product.PRODUCT_SELLPRICE,
                        IFNULL( promotionset.PROMOTIONSET_PRICE, CASE WHEN servicedetailkaraoke.KARADTSER_USETYPE = '1' THEN karaoke.KARAOKE_FLATRATE ELSE karaoke.KARAOKE_PRICEPERHOUR END ) 
                    ) AS SELLPRICE,
                    FORMAT( ( ( product.PRODUCT_SELLPRICE / 100 ) * pro.PROMOTIONPRICE_DISCOUNT ), '2' ) AS DISCOUNT 
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
                        service.SERVICE_ID = '$serviceID' 
                        AND servicedetail.DTSER_NO IN ($serviceNo) 
                    GROUP BY
                        product.PRODUCT_ID,
                        promotionset.PROMOTIONSET_ID,
                    karaoke.KARAOKE_ID,
                    servicedetailkaraoke.KARADTSER_USETYPE
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function serviceSplitDetail($serviceID)
    {
        $sql = "SELECT
                    detail.DTSER_ID,
                    detail.DTSER_NO,
                    detail.PRODUCT_ID,
                    detail.PRODUCT_NAME,
                    detail.SEAT_ID,
                    detail.SEAT_NAME,
                    detail.KARADTSER_USETYPE,
                    detail.PROMOTIONSET_ID,
                    detail.PROMOTIONSET_NAME,
                    detail.DTSER_TYPEUSE,
                    detail.DTSER_NOTE,
                    detail.DTSER_REMAINDER,
                    detail.DTSER_STATUS
                FROM
                    (
                    SELECT
                        servicedetail.DTSER_ID,
                        servicedetail.DTSER_NO,
                        seat.SEAT_ID,
                        seat.SEAT_NAME,
                        servicedetailkaraoke.KARADTSER_USETYPE,
                        product.PRODUCT_ID,
                        product.PRODUCT_NAME,
                        promotionset.PROMOTIONSET_ID,
                        promotionset.PROMOTIONSET_NAME,
                        servicedetail.DTSER_TYPEUSE,
                        servicedetail.DTSER_STATUS,
                        servicedetail.DTSER_NOTE,
                        servicedetail.DTSER_REMAINDER 
                    FROM
                        servicedetail
                        LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                        LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                        LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                        LEFT JOIN servicedetailkaraoke ON ( servicedetail.DTSER_ID = servicedetailkaraoke.KARADTSER_ID AND servicedetail.DTSER_NO = servicedetailkaraoke.KARADTSER_NO )
                        LEFT JOIN karaoke ON ( servicedetailkaraoke.KARADTSER_KARAOKEID = karaoke.KARAOKE_ID )
                        LEFT JOIN seat ON karaoke.KARAOKE_ID = seat.SEAT_ID
                        LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                        LEFT JOIN product ON servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID 
                    WHERE
                        servicedetail.DTSER_ID = '$serviceID'
                        AND servicedetail.DTSER_REMAINDER > 0 
                    GROUP BY
                        servicedetail.DTSER_ID,
                        servicedetail.DTSER_NO 
                    ) AS detail 
                ORDER BY
                    detail.DTSER_NO
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function detailProset($prosetID)
    {
        $sql = "SELECT
                    promotionsetdetail.PROSETDETAIL_NO,
                    product.PRODUCT_ID,
                    promotionsetdetail.PROSETDETAIL_AMOUNT,
                    product.PRODUCT_COSTPRICE,
                    product.PRODUCT_SELLPRICE FROM promotionset
                    JOIN promotionsetdetail ON promotionset.PROMOTIONSET_ID = promotionsetdetail.PROSETDETAIL_ID
                    JOIN product ON promotionsetdetail.PROSETDETAIL_PRODUCT = product.PRODUCT_ID 
                WHERE
                    promotionset.PROMOTIONSET_ID = '$prosetID'
                ";
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
                END AS discount ,
            CASE
                WHEN customer.CUSTOMER_BDATE = CURRENT_DATE THEN
                    '(วันเกิด)' ELSE '' 
                END AS discountName 
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

    public function etcService($serviceID)
    {
        $sql = "SELECT service.SERVICE_ID FROM service
        	    JOIN servicedetail ON service.SERVICE_ID = servicedetail.DTSER_ID 
                WHERE service.SERVICE_STATUS ='1'
                AND service.SERVICE_ID != '$serviceID'
                GROUP BY service.SERVICE_ID
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function etcSeatService($serviceID)
    {
        $sql = "SELECT
                    service.SERVICE_ID,
                    CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEATNAME 
                FROM
                    serviceseat
                    JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID
                    JOIN service ON serviceseat.SERSEAT_SERVICEID = service.SERVICE_ID 
                    JOIN servicedetail ON service.SERVICE_ID = servicedetail.DTSER_ID
                WHERE
                    service.SERVICE_ID != '$serviceID' 
                    AND service.SERVICE_STATUS = '1'
                    GROUP BY service.SERVICE_ID
                    ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateSplitRemainder($serviceID, $serviceNo, $remainder)
    {
        $sql = "UPDATE servicedetail
                SET DTSER_REMAINDER = (DTSER_REMAINDER-$remainder)
                WHERE DTSER_ID = '$serviceID'
                AND DTSER_NO = '$serviceNo'
                ";
        $this->db->query($sql);
    }

    public function checkServiceRemainder($serviceID)
    {
        $sql = "SELECT
                    COUNT( * ) AS Allcnt,
                    ( SELECT COUNT( * ) FROM servicedetail WHERE servicedetail.DTSER_REMAINDER = 0 AND servicedetail.DTSER_ID = '$serviceID' ) AS cnt 
                FROM
                    servicedetail 
                WHERE
                    servicedetail.DTSER_ID = '$serviceID' 
                GROUP BY
                    servicedetail.DTSER_ID
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
