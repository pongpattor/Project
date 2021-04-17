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
        $sql = "SELECT
                    typeproduct.TYPEPRODUCT_NAME,
                    typeproduct.TYPEPRODUCT_GROUP,
                    IFNULL( SUM( pro.profitss ), 0 ) AS profit 
                FROM
                    typeproduct
                    LEFT JOIN (
                    SELECT
                        product.PRODUCT_ID,
                        product.PRODUCT_NAME,
                        SUM( IFNULL( profitstb.profit, 0 ) ) AS profitss,
                        product.PRODUCT_TYPEPRODUCT 
                    FROM
                        product
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
                    ) pro ON typeproduct.TYPEPRODUCT_ID = pro.PRODUCT_TYPEPRODUCT 
                GROUP BY
                    typeproduct.TYPEPRODUCT_ID 
                ORDER BY
                    profit DESC
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

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
}
