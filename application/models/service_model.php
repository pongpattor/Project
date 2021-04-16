<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service_model extends CI_Model
{


    public function viewKaraokeUse()
    {
        $sql = "SELECT
                    seat.SEAT_NAME,	
                    sk.TIMEEND,
                    zone.ZONE_NAME 
                FROM
                    seat
                    JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID
                    JOIN serviceseat ON seat.SEAT_ID = serviceseat.SERSEAT_SEATID
                    JOIN (
                    SELECT
                        service.SERVICE_ID,
                        TIMESTAMPADD(HOUR,servicedetail.DTSER_AMOUNT,servicedetail.DTSER_TIME) AS TIMEEND
                
                    FROM
                        service
                        JOIN servicedetail ON service.SERVICE_ID = servicedetail.DTSER_ID
                        JOIN servicedetailkaraoke ON ( servicedetail.DTSER_ID = servicedetailkaraoke.KARADTSER_ID AND servicedetail.DTSER_NO = servicedetailkaraoke.KARADTSER_NO ) 
                    WHERE
                        servicedetailkaraoke.KARADTSER_USETYPE = '2' 
                        AND service.SERVICE_STATUS = '1' 
                    ) sk ON sk.SERVICE_ID = serviceseat.SERSEAT_SERVICEID 
                WHERE
                    seat.SEAT_TYPE = '2' 
                    AND seat.SEAT_STATUS = '1'
                    ORDER BY TIMEEND ASC
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function service($search, $limit, $offset)
    {
        $sql = "SELECT
        service.SERVICE_ID,
        service.SERVICE_CUSAMOUNT,
        service.SERVICE_DSTART,
        service.SERVICE_TSTART,
        service.SERVICE_SEATTYPE,
        CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) AS SEAT_NAMES,
        RPAD( LPAD( SERVICE_ID, 13, \"'\" ), 14, \"'\" ) AS serID ,
        dts.cnt as dtscnt
         FROM
        service
        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
        LEFT JOIN (SELECT DTSER_ID,COUNT(*) as cnt FROM servicedetail GROUP BY DTSER_ID) dts ON service.SERVICE_ID = dts.DTSER_ID
        WHERE
         service.SERVICE_STATUS = '1' 
        AND (
            service.SERVICE_ID LIKE ? 
            OR service.SERVICE_CUSAMOUNT LIKE ? 
            OR service.SERVICE_DSTART LIKE ? 
            OR service.SERVICE_TSTART LIKE ? 
            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
        )
        GROUP BY service.SERVICE_ID
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
                    COUNT( * ) AS cnt 
                FROM
                    (
                    SELECT
                        service.SERVICE_ID,
                        COUNT( * ) AS cnt 
                    FROM
                        service
                        JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
                        JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID 
                        LEFT JOIN (SELECT DTSER_ID,COUNT(*) FROM servicedetail GROUP BY DTSER_ID) dts ON service.SERVICE_ID = dts.DTSER_ID
                    WHERE
                         service.SERVICE_STATUS = '1' 
                        AND (
                            service.SERVICE_ID LIKE ? 
                            OR service.SERVICE_CUSAMOUNT LIKE ? 
                            OR service.SERVICE_DSTART LIKE ? 
                            OR service.SERVICE_TSTART LIKE ? 
                            OR CONCAT( seat.SEAT_NAME, IFNULL( serviceseat.SERSEAT_SEATSPLIT, '' ) ) LIKE ? 
                        ) 
                    GROUP BY
                    service.SERVICE_ID 
                    ) dts
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
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function checkCancelService($serviceID)
    {
        $sql = "SELECT
                    service.SERVICE_ID,
                    IFNULL(cnt,0) as cnt
                FROM
                    service
                    LEFT JOIN (
                    SELECT
                        DTSER_ID,
                        COUNT( * ) AS cnt 
                    FROM
                        servicedetail 
                    WHERE
                        DTSER_ID IN ($serviceID) 
                    GROUP BY
                        DTSER_ID 
                    ) dts ON service.SERVICE_ID = dts.DTSER_ID
                GROUP BY
                    service.SERVICE_ID
                    ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function checkCancelServiceSplit($seatID)
    {
        $sql = "SELECT
                    COUNT( * ) as cnt
                FROM
                    serviceseat
                    JOIN service ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID 
                WHERE
                    serviceseat.SERSEAT_SEATID = '$seatID' 
                    AND service.SERVICE_STATUS = '1'
                    ";
        $query = $this->db->query($sql);
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
        AND SEAT_ENABLE = '1'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        AND queue.QUEUE_STATUS = '1'
        AND queue.QUEUE_TYPE = '1'
        AND queue.QUEUE_ACTIVE = '1'
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
        AND SEAT_ENABLE = '1'
        AND SEAT_ID NOT IN (SELECT queueseat.QS_SEATID FROM queue INNER JOIN queueseat
        ON queue.QUEUE_ID = queueseat.QS_QUEUEID
        WHERE queue.QUEUE_DSTART = CURRENT_DATE
        AND queue.QUEUE_STATUS = '1'
        AND queue.QUEUE_TYPE = '1'
        AND queue.QUEUE_ACTIVE = '1'
        GROUP BY queueseat.QS_SEATID )";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function ZoneSeat()
    {
        $sql = "SELECT zone.ZONE_ID,zone.ZONE_NAME FROM zone
        JOIN seat ON seat.SEAT_ZONE = zone.ZONE_ID
        WHERE zone.ZONE_STATUS ='1'
        GROUP BY zone.ZONE_ID";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function serviceDetail($serviceID)
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
                    detail.DTSER_AMOUNT,
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
                        servicedetail.DTSER_AMOUNT 
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

    public function orderHotSell()
    {
        $sql = "SELECT
                    product.PRODUCT_ID,
                    product.PRODUCT_NAME,
                    product.PRODUCT_IMAGE,
                    product.PRODUCT_SELLPRICE                
                FROM
                    receipt
                    JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                    LEFT JOIN (
                    SELECT
                        receiptdetailproset.PROSDTREC_ID,
                        receiptdetailproset.PROSDTREC_NO,
                        receiptdetailprosetdetail.DPRODTREC_DETAILNO,
                        receiptdetailprosetdetail.DPRODTREC_PRODUCT,
                        receiptdetailprosetdetail.DPRODTREC_AMOUNT,
                        receiptdetailprosetdetail.DPRODTREC_COSTPRICE,
                        receiptdetailprosetdetail.DPRODTREC_SELLPRICE 
                    FROM
                        receiptdetailproset
                        JOIN receiptdetailprosetdetail ON ( receiptdetailproset.PROSDTREC_ID = receiptdetailprosetdetail.DPRODTREC_ID AND receiptdetailproset.PROSDTREC_NO = receiptdetailprosetdetail.DPRODTREC_NO ) 
                    ) prodtrec ON ( receiptdetail.DTREC_ID = prodtrec.PROSDTREC_ID AND receiptdetail.DTREC_NO = prodtrec.PROSDTREC_NO )
                    LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO )
                    JOIN product ON ( prodtrec.DPRODTREC_PRODUCT = product.PRODUCT_ID OR receiptdetailfd.FDDTREC_PRODUCTID = product.PRODUCT_ID ) 
                WHERE
                    receiptdetail.DTREC_TYPEORDER != '3'
                    AND MONTH(receipt.RECEIPT_DATE) = MONTH(CURRENT_DATE)
                    AND product.PRODUCT_STATUS = '1'
                    GROUP BY 	product.PRODUCT_ID
                LIMIT 0 ,10    
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

    public function recommendedProduct()
    {
        $sql = "SELECT PRODUCT_NAME,PRODUCT_SELLPRICE,PRODUCT_IMAGE FROM product
        WHERE PRODUCT_RECOMMENDED = '1'
        AND PRODUCT_ACTIVE = '1'
        AND PRODUCT_STATUS = '1'
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function viewProPrice($productID)
    {
        $sql = "SELECT
                    promotionprice.PROMOTIONPRICE_NAME,promotionprice.PROMOTIONPRICE_DISCOUNT
                FROM
                    promotionprice
                     JOIN promotionpricedetail ON ( promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID )
                     JOIN product ON promotionpricedetail.PROPRICE_PRODUCT = product.PRODUCT_ID
                    WHERE product.PRODUCT_ID = '$productID'
                    AND (CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND)
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function viewProSet($productID)
    {
        $sql = "SELECT
                    promotionset.PROMOTIONSET_NAME,
                    promotionset.PROMOTIONSET_PRICE 
                FROM
                    promotionset
                    JOIN promotionsetdetail ON promotionset.PROMOTIONSET_ID = promotionsetdetail.PROSETDETAIL_ID
                    JOIN product ON promotionsetdetail.PROSETDETAIL_PRODUCT = product.PRODUCT_ID 
                WHERE
                    product.PRODUCT_ID = '$productID' 
                    AND ( CURRENT_DATE BETWEEN promotionset.PROMOTIONSET_DATESTART AND promotionset.PROMOTIONSET_DATEEND )
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function Order()
    {
        // $sql = "SELECT
        //             product.PRODUCT_ID,
        //             product.PRODUCT_NAME,
        //             product.PRODUCT_IMAGE,
        //             product.PRODUCT_SELLPRICE,
        //             product.PRODUCT_ACTIVE,
        //             product.PRODUCT_STATUS,
        //             recipe.RECIPE_ID,
        //             typeproduct.TYPEPRODUCT_NAME,
        //             proprice.PROMOTIONPRICE_NAME,
        //             proprice.PROMOTIONPRICE_DISCOUNT,
        //             ( product.PRODUCT_SELLPRICE - ( ( product.PRODUCT_SELLPRICE / 100 ) * proprice.PROMOTIONPRICE_DISCOUNT ) ) AS PRICE_DISCOUNT 
        //         FROM
        //             product
        //             JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
        //             LEFT JOIN recipe ON product.PRODUCT_ID = recipe.RECIPE_PRODUCT
        //             LEFT JOIN (
        //             SELECT
        //                 promotionprice.PROMOTIONPRICE_NAME,
        //                 promotionprice.PROMOTIONPRICE_DISCOUNT,
        //                 promotionpricedetail.PROPRICE_PRODUCT 
        //             FROM
        //                 promotionprice
        //                 JOIN promotionpricedetail ON promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID 
        //             WHERE
        //                 ( CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND ) 
        //                 AND promotionprice.PROMOTIONPRICE_STATUS = '1' 
        //             ) proprice ON product.PRODUCT_ID = proprice.PROPRICE_PRODUCT 
        //         WHERE
        //             ( ( typeproduct.TYPEPRODUCT_GROUP = '1' AND recipe.RECIPE_ID IS NOT NULL ) OR ( typeproduct.TYPEPRODUCT_GROUP = '2' ) ) 
        //             AND product.PRODUCT_STATUS = '1'
        // ";

        $sql = "SELECT
                product.PRODUCT_ID,
                product.PRODUCT_NAME,
                product.PRODUCT_IMAGE,
                typeproduct.TYPEPRODUCT_NAME,
                product.PRODUCT_SELLPRICE,
                product.PRODUCT_ACTIVE,
                product.PRODUCT_SELLPRICE,
                IFNULL(	proset.PROMOTIONSET_ID,proprice.PROMOTIONPRICE_ID) as pro,
                ( product.PRODUCT_SELLPRICE - ( ( product.PRODUCT_SELLPRICE / 100 ) * proprice.PROMOTIONPRICE_DISCOUNT ) ) AS PRICE_DISCOUNT 
            FROM
                product
                JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                LEFT JOIN (
                SELECT
                    promotionset.PROMOTIONSET_ID,
                    promotionsetdetail.PROSETDETAIL_PRODUCT 
                FROM
                    promotionset
                    JOIN promotionsetdetail ON promotionset.PROMOTIONSET_ID = promotionsetdetail.PROSETDETAIL_ID 
                WHERE
                    ( CURRENT_DATE BETWEEN promotionset.PROMOTIONSET_DATESTART AND promotionset.PROMOTIONSET_DATEEND ) 
                    AND promotionset.PROMOTIONSET_STATUS = '1' 
                ) proset ON product.PRODUCT_ID = proset.PROSETDETAIL_PRODUCT
                LEFT JOIN (
                SELECT
                    promotionprice.PROMOTIONPRICE_ID,
                    promotionpricedetail.PROPRICE_PRODUCT,
                    promotionprice.PROMOTIONPRICE_DISCOUNT
                FROM
                    promotionprice
                    JOIN promotionpricedetail ON promotionprice.PROMOTIONPRICE_ID = promotionpricedetail.PROPRICE_ID 
                WHERE
                    ( CURRENT_DATE BETWEEN promotionprice.PROMOTIONPRICE_DATESTART AND promotionprice.PROMOTIONPRICE_DATEEND ) 
                AND promotionprice.PROMOTIONPRICE_STATUS = '1' 
                ) proprice ON product.PRODUCT_ID = proprice.PROPRICE_PRODUCT
                WHERE product.PRODUCT_STATUS ='1'
                GROUP BY product.PRODUCT_ID
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function seatCurrent($serviceID)
    {
        $sql = "SELECT
                seat.SEAT_ID,
                seat.SEAT_NAME,
                seat.SEAT_AMOUNT,
                seat.SEAT_TYPE,
                zone.ZONE_ID,
                zone.ZONE_NAME ,
                karaoke.KARAOKE_PRICEPERHOUR,
                karaoke.KARAOKE_FLATRATE,
                service.SERVICE_CUSAMOUNT
            FROM
                service
                JOIN serviceseat ON service.SERVICE_ID = serviceseat.SERSEAT_SERVICEID
                JOIN seat ON serviceseat.SERSEAT_SEATID = seat.SEAT_ID
                LEFT JOIN karaoke ON seat.SEAT_ID = karaoke.KARAOKE_ID
                JOIN zone ON seat.SEAT_ZONE = zone.ZONE_ID 
            WHERE
                service.SERVICE_ID = '$serviceID'
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function promotionset()
    {

        $sql2 = "SELECT
                    promotionset.PROMOTIONSET_ID,
                    promotionset.PROMOTIONSET_NAME,
                    promotionset.PROMOTIONSET_PRICE,
                    IFNULL( psd.PRODUCT_ACTIVE, 0 ) AS PSD_ACTIVE 
                FROM
                    promotionset
                    LEFT JOIN (
                    SELECT
                        promotionsetdetail.PROSETDETAIL_ID,
                        product.PRODUCT_ACTIVE 
                    FROM
                        product
                        JOIN promotionsetdetail ON product.PRODUCT_ID = promotionsetdetail.PROSETDETAIL_PRODUCT 
                    WHERE
                        PRODUCT_ACTIVE = '2' 
                        AND PRODUCT_STATUS = '1' 
                    ) psd ON promotionset.PROMOTIONSET_ID = psd.PROSETDETAIL_ID 
                WHERE
                    promotionset.PROMOTIONSET_STATUS = '1' 
                    AND ( CURRENT_DATE BETWEEN promotionset.PROMOTIONSET_DATESTART AND promotionset.PROMOTIONSET_DATEEND ) 
                GROUP BY
                    promotionset.PROMOTIONSET_ID
                ";


        // $sql = " SELECT
        // promotionset.PROMOTIONSET_ID,
        // promotionset.PROMOTIONSET_NAME,
        // promotionset.PROMOTIONSET_PRICE 
        // FROM
        // promotionset
        // JOIN promotionsetdetail ON promotionset.PROMOTIONSET_ID = promotionsetdetail.PROSETDETAIL_ID 
        // WHERE
        // promotionset.PROMOTIONSET_STATUS = '1' 
        // AND ( CURRENT_DATE BETWEEN promotionset.PROMOTIONSET_DATESTART AND promotionset.PROMOTIONSET_DATEEND ) 
        // GROUP BY
        // promotionset.PROMOTIONSET_ID";
        $query = $this->db->query($sql2);
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

    public function servedFront($limit, $offset)
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    servicedetail.DTSER_TYPEORDER,
                    product.PRODUCT_ID,
                    product.PRODUCT_NAME,
                    IFNULL(servicedetailprosetdetail.DPRODTSER_AMOUNT,DTSER_AMOUNT) as AMOUNT,
                    RPAD(LPAD( servicedetail.DTSER_ID,13,\"'\"),14,\"'\") as serID
                FROM
                    servicedetail 
                    LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                    LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                    LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                    LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
                WHERE (servicedetail.DTSER_STATUS ='2' OR servicedetailprosetdetail.DPRODTSER_STATUS ='2')
                ORDER BY servicedetail.DTSER_DATE ASC,servicedetail.DTSER_TIME ASC
                LIMIT $offset,$limit
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function servedProset($serviceID, $serviceNO, $productID)
    {
        $sql = "UPDATE servicedetailprosetdetail
                SET DPRODTSER_STATUS = '3'
                WHERE DPRODTSER_SERVICEID = '$serviceID'
                AND DPRODTSER_NO = '$serviceNO'
                AND DPRODTSER_PRODUCTID = '$productID'
                ";
        $this->db->query($sql);
    }

    public function checkProsetAll($serviceID, $serviceNO)
    {
        $sql = "SELECT
                    COUNT(*) as cnt
                FROM
                    servicedetailprosetdetail 
                WHERE
                    servicedetailprosetdetail.DPRODTSER_SERVICEID = '$serviceID' 
                    AND servicedetailprosetdetail.DPRODTSER_NO = '$serviceNO' 
                ";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function checkProsetAllServed($serviceID, $serviceNO)
    {
        $sql = "SELECT
                    COUNT(*) as cnt
                FROM
                    servicedetailprosetdetail 
                WHERE
                    servicedetailprosetdetail.DPRODTSER_SERVICEID = '$serviceID' 
                    AND servicedetailprosetdetail.DPRODTSER_NO = '$serviceNO' 
                    AND servicedetailprosetdetail.DPRODTSER_STATUS = '3' 
                ";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
}
