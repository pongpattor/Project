<?php
defined('BASEPATH') or exit('No direct script access allowed');

class report_model extends CI_Model
{

    public function reportAmountProduct($dateStart, $dateEnd, $sort)
    {
        $sql = "SELECT
                product.PRODUCT_ID,
                product.PRODUCT_NAME,
                typeproduct.TYPEPRODUCT_GROUP,
                SUM(amtproduct.AMOUNT) as AllAmount
            FROM
                product
                JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                JOIN (SELECT
                IFNULL( receiptdetailprosetdetail.DPRODTREC_AMOUNT, receiptdetail.DTREC_AMOUNT ) AS AMOUNT,
                IFNULL( receiptdetailprosetdetail.DPRODTREC_PRODUCT, receiptdetailfd.FDDTREC_PRODUCTID ) AS PRODUCT 
            FROM
                receipt
                JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO )
                LEFT JOIN receiptdetailproset ON ( receiptdetail.DTREC_ID = receiptdetailproset.PROSDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailproset.PROSDTREC_NO )
                LEFT JOIN receiptdetailprosetdetail ON ( receiptdetailproset.PROSDTREC_ID = receiptdetailprosetdetail.DPRODTREC_ID AND receiptdetailproset.PROSDTREC_NO = receiptdetailprosetdetail.DPRODTREC_NO )
                WHERE receiptdetail.DTREC_TYPEORDER != '3'
                AND (receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd')) amtproduct
                ON product.PRODUCT_ID = amtproduct.PRODUCT
                GROUP BY product.PRODUCT_ID
                ORDER BY AllAmount $sort
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportProfitProduct($dateStart, $dateEnd)
    {
        // $sql = "SELECT
        //             typeproduct.TYPEPRODUCT_NAME,
        //             typeproduct.TYPEPRODUCT_GROUP,
        //             IFNULL( SUM( pro.profitss ), 0 ) AS profit 
        //         FROM
        //             typeproduct
        //             LEFT JOIN (
        //             SELECT
        //                 product.PRODUCT_ID,
        //                 product.PRODUCT_NAME,
        //                 SUM( IFNULL( profitstb.profit, 0 ) ) AS profitss,
        //                 product.PRODUCT_TYPEPRODUCT 
        //             FROM
        //                 product
        //                 LEFT JOIN (
        //                 SELECT
        //                     IFNULL( receiptdetailprosetdetail.DPRODTREC_PRODUCT, receiptdetailfd.FDDTREC_PRODUCTID ) AS PRODUCT,
        //                     SUM( ( receiptdetail.DTREC_PRICEALL ) - ( receiptdetailfd.FDDTREC_COSTPRICE * receiptdetail.DTREC_AMOUNT ) ) AS profit 
        //                 FROM
        //                     receipt
        //                     JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
        //                     LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO )
        //                     LEFT JOIN receiptdetailproset ON ( receiptdetail.DTREC_ID = receiptdetailproset.PROSDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailproset.PROSDTREC_NO )
        //                     LEFT JOIN receiptdetailprosetdetail ON ( receiptdetailproset.PROSDTREC_ID = receiptdetailprosetdetail.DPRODTREC_ID AND receiptdetailproset.PROSDTREC_NO = receiptdetailprosetdetail.DPRODTREC_NO ) 
        //                 WHERE
        //                     receiptdetail.DTREC_TYPEORDER = '1' 
        //                     AND ( receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd' ) 
        //                 GROUP BY
        //                     receiptdetailfd.FDDTREC_PRODUCTID 
        //                 ) profitstb ON product.PRODUCT_ID = profitstb.PRODUCT 
        //             GROUP BY
        //                 product.PRODUCT_ID 
        //             ) pro ON typeproduct.TYPEPRODUCT_ID = pro.PRODUCT_TYPEPRODUCT 
        //         GROUP BY
        //             typeproduct.TYPEPRODUCT_ID 
        //         ORDER BY
        //             profit DESC
        //         ";  Profits Typeproduct
        $sql = "SELECT
                    product.PRODUCT_ID,
                    product.PRODUCT_NAME,
                    typeproduct.TYPEPRODUCT_NAME,
                    SUM( IFNULL( profitstb.profit, 0 ) ) AS profitss,
                    typeproduct.TYPEPRODUCT_GROUP
                FROM
                    product
                    JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
                    LEFT JOIN (
                    SELECT
                        IFNULL( receiptdetailprosetdetail.DPRODTREC_PRODUCT, receiptdetailfd.FDDTREC_PRODUCTID ) AS PRODUCT,
                        SUM( ( receiptdetail.DTREC_PRICEALL ) - ( receiptdetailfd.FDDTREC_COSTPRICE * receiptdetail.DTREC_AMOUNT ) ) AS profit 
                    FROM
                        receipt
                        JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                        LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO )
                        LEFT JOIN receiptdetailproset ON ( receiptdetail.DTREC_ID = receiptdetailproset.PROSDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailproset.PROSDTREC_NO )
                        LEFT JOIN receiptdetailprosetdetail ON ( receiptdetailproset.PROSDTREC_ID = receiptdetailprosetdetail.DPRODTREC_ID AND receiptdetailproset.PROSDTREC_NO = receiptdetailprosetdetail.DPRODTREC_NO ) 
                    WHERE
                        receiptdetail.DTREC_TYPEORDER = '1' 
                        AND ( receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd' ) 
                    GROUP BY
                        receiptdetailfd.FDDTREC_PRODUCTID 
                    ) profitstb ON product.PRODUCT_ID = profitstb.PRODUCT 
                GROUP BY
                    product.PRODUCT_ID
                    ORDER BY profitss DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    // public function reportProfitDrink($dateStart, $dateEnd)
    // {
    //     $sql = "SELECT
    //                 product.PRODUCT_ID,
    //                 product.PRODUCT_NAME,
    //                 typeproduct.TYPEPRODUCT_NAME,
    //                 SUM( IFNULL( profitstb.profit, 0 ) ) AS profitss,
    //                 typeproduct.TYPEPRODUCT_GROUP
    //             FROM
    //                 product
    //                 JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID
    //                 LEFT JOIN (
    //                 SELECT
    //                     IFNULL( receiptdetailprosetdetail.DPRODTREC_PRODUCT, receiptdetailfd.FDDTREC_PRODUCTID ) AS PRODUCT,
    //                     SUM( ( receiptdetail.DTREC_PRICEALL ) - ( receiptdetailfd.FDDTREC_COSTPRICE * receiptdetail.DTREC_AMOUNT ) ) AS profit 
    //                 FROM
    //                     receipt
    //                     JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
    //                     LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO )
    //                     LEFT JOIN receiptdetailproset ON ( receiptdetail.DTREC_ID = receiptdetailproset.PROSDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailproset.PROSDTREC_NO )
    //                     LEFT JOIN receiptdetailprosetdetail ON ( receiptdetailproset.PROSDTREC_ID = receiptdetailprosetdetail.DPRODTREC_ID AND receiptdetailproset.PROSDTREC_NO = receiptdetailprosetdetail.DPRODTREC_NO ) 
    //                 WHERE
    //                     receiptdetail.DTREC_TYPEORDER = '1' 
    //                     AND ( receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd' ) 
    //                 GROUP BY
    //                     receiptdetailfd.FDDTREC_PRODUCTID 
    //                 ) profitstb ON product.PRODUCT_ID = profitstb.PRODUCT 
    //                 WHERE  typeproduct.TYPEPRODUCT_GROUP = '2'
    //             GROUP BY
    //                 product.PRODUCT_ID
    //                 ORDER BY profitss DESC";
    //     $query = $this->db->query($sql);
    //     return $query->result();
    // }

    public function reportProprice($dateStart, $dateEnd)
    {
        $sql = "SELECT
                    promotionprice.PROMOTIONPRICE_NAME,
                    IFNULL( recpro.sumpro, 0 ) AS cntpro 
                FROM
                    promotionprice
                    LEFT JOIN (
                    SELECT
                        receiptdetailfd.FDDTREC_PROPRICEID,
                        SUM( receiptdetail.DTREC_AMOUNT ) AS sumpro 
                    FROM
                        receipt
                        JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                        LEFT JOIN receiptdetailfd ON ( receiptdetail.DTREC_ID = receiptdetailfd.FDDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailfd.FDDTREC_NO ) 
                    WHERE
                        receiptdetail.DTREC_TYPEORDER != '3' 
                        AND receiptdetailfd.FDDTREC_PROPRICEID IS NOT NULL 
                        AND ( receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd') 
                    GROUP BY
                    receiptdetailfd.FDDTREC_PROPRICEID 
                    ) recpro ON promotionprice.PROMOTIONPRICE_ID = recpro.FDDTREC_PROPRICEID
                    ORDER BY cntpro DESC
                    ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportProset($dateStart, $dateEnd)
    {
        $sql = "SELECT
                    promotionset.PROMOTIONSET_NAME,
                    IFNULL( recpro.sumpro, 0 ) AS cntpro 
                FROM
                    promotionset
                    LEFT JOIN (
                    SELECT
                        receiptdetailproset.PROSDTREC_PROSET,
                        SUM( receiptdetail.DTREC_AMOUNT ) AS sumpro 
                    FROM
                        receipt
                        JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                        LEFT JOIN receiptdetailproset ON ( receiptdetail.DTREC_ID = receiptdetailproset.PROSDTREC_ID AND receiptdetail.DTREC_NO = receiptdetailproset.PROSDTREC_NO ) 
                    WHERE
                        receiptdetail.DTREC_TYPEORDER = '2' 
                        AND ( receipt.RECEIPT_DATE BETWEEN '$dateStart' AND '$dateEnd' ) 
                    GROUP BY
                    receiptdetailproset.PROSDTREC_PROSET 
                    ) recpro ON promotionset.PROMOTIONSET_ID = recpro.PROSDTREC_PROSET
                    ORDER BY cntpro DESC
                    ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportCrossTab($year)
    {
        $sql = "SELECT
                product.PRODUCT_ID,
                product.PRODUCT_NAME,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-01' ) ),0) AS Jan,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-02' ) ),0) AS Feb,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-03' ) ),0) AS Mar,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-04' ) ),0) AS Apr,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-05' ) ),0) AS May,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-06' ) ),0) AS Jun,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-07' ) ),0) AS Jul,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-08' ) ),0) AS Aug,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-09' ) ),0) AS Sep,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-10' ) ),0) AS Oct,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-11' ) ),0) AS Nov,
                IFNULL(SUM( rec.price * ( rec.yymm = '$year-12' ) ),0) AS 'Dec'
            FROM
                product
                LEFT JOIN
                (
                SELECT
                receiptdetailfd.FDDTREC_PRODUCTID,
                SUM( receiptdetail.DTREC_PRICEUNIT * receiptdetail.DTREC_AMOUNT ) AS price,
                SUBSTR( receipt.RECEIPT_DATE, 1, 7 ) AS yymm 
            FROM
                receipt
                JOIN receiptdetail ON receipt.RECEIPT_ID = receiptdetail.DTREC_ID
                JOIN receiptdetailfd ON ( receiptdetailfd.FDDTREC_ID = receiptdetail.DTREC_ID AND receiptdetailfd.FDDTREC_NO = receiptdetail.DTREC_NO ) 
            WHERE
                YEAR ( receipt.RECEIPT_DATE ) = '$year'
                GROUP BY 	receiptdetailfd.FDDTREC_PRODUCTID,yymm
                )rec ON rec.FDDTREC_PRODUCTID = product.PRODUCT_ID
                GROUP BY product.PRODUCT_ID";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportAmountQueue($dateStart, $dateEnd)
    {
        $sql = "SELECT
            '09.00-12.00 น.' AS 'T1',
            (
            SELECT
                COUNT( * ) 
            FROM
                queue 
            WHERE
                QUEUE_TYPE = '1' 
                AND ( QUEUE_TSTART BETWEEN '09:00:00' AND '12:00:00' ) 
                AND ( QUEUE_DSTART BETWEEN '$dateStart' AND '$dateEnd' ) 
            ) AS 'Time1',
            '12.01-16.00 น.' AS 'T2',
            (
            SELECT
                COUNT( * ) 
            FROM
                queue 
            WHERE
                QUEUE_TYPE = '1' 
                AND ( QUEUE_TSTART BETWEEN '12:01:00' AND '16:00:00' ) 
                AND ( QUEUE_DSTART BETWEEN '$dateStart' AND '$dateEnd' ) 
            ) AS 'Time2',
            '16.01-21.00 น.' AS 'T3',
            (
            SELECT
                COUNT( * ) 
            FROM
                queue 
            WHERE
                QUEUE_TYPE = '1' 
                AND ( QUEUE_TSTART BETWEEN '16:01:00' AND '21:00:00' ) 
            AND ( QUEUE_DSTART BETWEEN '$dateStart' AND '$dateEnd' ) 
            ) AS 'Time3'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
