<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service_model extends CI_Model
{

    public function service($search, $limit, $offset)
    {
        $sql = "SELECT
        service.SERVICE_ID,
        service.SERVICE_CUSAMOUNT,
        service.SERVICE_DSTART,
        service.SERVICE_TSTART,
        CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEAT_NAMES,
        RPAD( LPAD( SERVICE_ID, 13, \"'\" ), 14, \"'\" ) AS serID 
         FROM
        service
        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
        WHERE
        service.SERVICE_ACTIVE = '1' 
        AND service.SERVICE_STATUS = '1' 
        AND (
            service.SERVICE_ID LIKE ? 
            OR service.SERVICE_CUSAMOUNT LIKE ? 
            OR service.SERVICE_DSTART LIKE ? 
            OR service.SERVICE_TSTART LIKE ? 
            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
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
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllService($search)
    {
        $sql = "SELECT
        COUNT(*) as cnt
         FROM
        service
        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
        WHERE
        service.SERVICE_ACTIVE = '1' 
        AND service.SERVICE_STATUS = '1' 
        AND (
            service.SERVICE_ID LIKE ? 
            OR service.SERVICE_CUSAMOUNT LIKE ? 
            OR service.SERVICE_DSTART LIKE ? 
            OR service.SERVICE_TSTART LIKE ? 
            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );

        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function fetchServiceSeat($serviceID)
    {
        $sql = "SELECT
        serviceseat.SERSEAT_SERVICEID,
        CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEAT_NAMES 
    FROM
        serviceseat
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
    WHERE
        serviceseat.SERSEAT_SERVICEID IN ( $serviceID )";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function deskEmpty()
    {
        $sql = "SELECT SEAT_ID,SEAT_NAME,SEAT_AMOUNT,SEAT_ZONE FROM seat
        WHERE SEAT_STATUS = '1'
        AND SEAT_TYPE = '1'
        AND SEAT_ACTIVE = '0'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        GROUP BY queueseat.QS_SEATID )";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function karaokeEmpty()
    {
        $sql = "SELECT seat.SEAT_ID,seat.SEAT_NAME,seat.SEAT_AMOUNT,seat.SEAT_ZONE,
        karaoke.KARAOKE_PRICEPERHOUR,karaoke.KARAOKE_FLATRATE
        FROM seat 
        INNER JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
        WHERE SEAT_STATUS = '1'
        AND SEAT_TYPE = '2'
        AND SEAT_ACTIVE = '0'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        GROUP BY queueseat.QS_SEATID )";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function serviceDetail($serviceID)
    {
        $sql = "SELECT
                    detail.DTSER_NO,
                    detail.PRODUCT_ID,
                    detail.PRODUCT_NAME,
                    detail.PROMOTIONSET_ID,
                    detail.PROMOTIONSET_NAME,
                    detail.DTSER_NOTE,
                    detail.DTSER_AMOUNT, 
                    detail.DTSER_STATUS 
                FROM
                    (
                    SELECT
                        servicedetail.DTSER_NO,
                        product.PRODUCT_ID,
                        product.PRODUCT_NAME,
                        promotionset.PROMOTIONSET_ID,
                        promotionset.PROMOTIONSET_NAME,
                        servicedetail.DTSER_STATUS,
                        servicedetail.DTSER_NOTE,
                        servicedetail.DTSER_AMOUNT 
                    FROM
                        servicedetail
                        LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                        LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                        LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                        LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                        LEFT JOIN product ON servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID 
                    WHERE
                        servicedetail.DTSER_ID = '$serviceID' 
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


    public function checkOrderForCancel($serviceID, $serviceNO)
    {
        $sql = "SELECT
                    DTSER_STATUS 
                FROM
                    servicedetail 
                WHERE
                    DTSER_ID = '$serviceID' 
                    AND DTSER_NO = '$serviceNO'
        ";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->DTSER_STATUS;
        }
    }

    public function Order()
    {
        //     $sql = "SELECT
        //     product.PRODUCT_ID,
        //     product.PRODUCT_NAME,
        //     product.PRODUCT_IMAGE,
        //     product.PRODUCT_SELLPRICE,
        //     product.PRODUCT_ACTIVE,
        //     typeproduct.TYPEPRODUCT_NAME,
        //     proprice.PROMOTIONPRICE_ID,
        //     proprice.PROMOTIONPRICE_NAME,
        //     proprice.PROMOTIONPRICE_DISCOUNT,
        //     ( product.PRODUCT_SELLPRICE - ( ( product.PRODUCT_SELLPRICE / 100 ) * proprice.PROMOTIONPRICE_DISCOUNT ) ) AS PRICE_DISCOUNT 
        // FROM
        //     product
        //     JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
        //     LEFT JOIN (
        //     SELECT
        //         promotionprice.PROMOTIONPRICE_ID,
        //         promotionprice.PROMOTIONPRICE_NAME,
        //         promotionprice.PROMOTIONPRICE_DISCOUNT,
        //         promotionpricedetail.PROPRICE_PRODUCT 
        //     FROM
        //         promotionprice
        //         JOIN promotionpricedetail ON promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID 
        //     WHERE
        //         ( CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND ) 
        //         AND promotionprice.PROMOTIONPRICE_STATUS = '1' 
        //     ) proprice ON product.PRODUCT_ID = proprice.PROPRICE_PRODUCT 
        // WHERE
        //     product.PRODUCT_STATUS = '1'
        // ";

        $sql = "SELECT
                    product.PRODUCT_ID,
                    product.PRODUCT_NAME,
                    product.PRODUCT_IMAGE,
                    product.PRODUCT_SELLPRICE,
                    product.PRODUCT_ACTIVE,
                    product.PRODUCT_STATUS,
                    recipe.RECIPE_ID,
                    proprice.PROMOTIONPRICE_NAME,
                    proprice.PROMOTIONPRICE_DISCOUNT,
                    ( product.PRODUCT_SELLPRICE - ( ( product.PRODUCT_SELLPRICE / 100 ) * proprice.PROMOTIONPRICE_DISCOUNT ) ) AS PRICE_DISCOUNT 
                FROM
                    product
                    JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                    LEFT JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_PRODUCT
                    LEFT JOIN (
                    SELECT
                        promotionprice.PROMOTIONPRICE_NAME,
                        promotionprice.PROMOTIONPRICE_DISCOUNT,
                        promotionpricedetail.PROPRICE_PRODUCT 
                    FROM
                        promotionprice
                        JOIN promotionpricedetail ON promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID 
                    WHERE
                        ( CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND ) 
                        AND promotionprice.PROMOTIONPRICE_STATUS = '1' 
                    ) proprice ON product.PRODUCT_ID = proprice.PROPRICE_PRODUCT 
                WHERE
                    ( ( typeproduct.TYPEPRODUCT_GROUP = '1' AND recipe.RECIPE_ID IS NOT NULL ) OR ( typeproduct.TYPEPRODUCT_GROUP = '2' ) ) 
                    AND product.PRODUCT_STATUS = '1'
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function promotionset()
    {
        $sql = " SELECT
        promotionset.PROMOTIONSET_ID,
        promotionset.PROMOTIONSET_NAME,
        promotionset.PROMOTIONSET_PRICE 
        FROM
        promotionset
        JOIN promotionsetdetail ON promotionset.PROMOTIONSET_ID = promotionsetdetail.PROSETDETAIL_ID 
        WHERE
        promotionset.PROMOTIONSET_STATUS = '1' 
        AND ( CURRENT_DATE BETWEEN promotionset.PROMOTIONSET_DATESTART AND promotionset.PROMOTIONSET_DATEEND ) 
        GROUP BY
        promotionset.PROMOTIONSET_ID";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function promotionSetDetail($promotionSetID)
    {
        $sql = "SELECT
                    product.PRODUCT_NAME,
                    promotionsetdetail.PROSETDETAIL_AMOUNT ,
                    product.PRODUCT_SELLPRICE,
                    (product.PRODUCT_SELLPRICE*promotionsetdetail.PROSETDETAIL_AMOUNT) as SUMEACHORDER
                FROM
                    promotionsetdetail
                    JOIN product ON promotionsetdetail.PROSETDETAIL_PRODUCT = product.PRODUCT_ID 
                WHERE
                    PROSETDETAIL_ID = '$promotionSetID'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
