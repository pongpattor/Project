<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kitchen_model extends CI_Model
{
    public function kitchenFood()
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    product.PRODUCT_ID,
                    product.PRODUCT_NAME,
                    servicedetail.DTSER_TYPEORDER,
                    servicedetail.DTSER_TYPEUSE,
                    servicedetail.DTSER_AMOUNT,
                    servicedetailprosetdetail.DPRODTSER_AMOUNT,
                    servicedetail.DTSER_NOTE,
                    servicedetail.DTSER_STATUS,
                    servicedetailprosetdetail.DPRODTSER_STATUS
                FROM
                    servicedetail
                    LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                    LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                    LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                    LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
                    LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                WHERE
                    typeproduct.TYPEPRODUCT_GROUP = '1' 
                    AND servicedetail.DTSER_STATUS IN ( 0, 1 ) 
                ORDER BY
                    servicedetail.DTSER_DATE ASC,
                    servicedetail.DTSER_TIME ASC
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function kitchenFoodSame()
    {
        // $sql = "SELECT
        //             product.PRODUCT_ID,
        //             product.PRODUCT_NAME,
        //             servicedetail.DTSER_STATUS,
        //             servicedetail.DTSER_NOTE,
        //             servicedetail.DTSER_TYPEUSE,
        //             servicedetailprosetdetail.DPRODTSER_STATUS,
        //             IFNULL(SUM(servicedetailprosetdetail.DPRODTSER_AMOUNT),SUM(servicedetail.DTSER_AMOUNT))AS sumAmount
        //         FROM
        //             servicedetail
        //             LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
        //             LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
        //             LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
        //             LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
        //             LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
        //             LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
        //         WHERE
        //             typeproduct.TYPEPRODUCT_GROUP = '1' 
        //             AND servicedetail.DTSER_STATUS IN (0,1)
        //     GROUP BY product.PRODUCT_ID,servicedetail.DTSER_NOTE,servicedetail.DTSER_TYPEUSE,servicedetail.DTSER_STATUS 

        //     HAVING sumAmount >1
        //     ORDER BY servicedetail.DTSER_DATE,servicedetail.DTSER_TIME
        //     ";

        $sql = "SELECT
                    dtser.PRODUCT_ID,
                    dtser.PRODUCT_NAME,
                    dtser.DTSER_NOTE,
                    dtser.DTSER_TYPEUSE,
                    dtser.DT_STATUS,
                    dtser.DTSER_STATUS,
                    dtser.DPRODTSER_STATUS,
                    SUM( dtser.DT_AMOUNT ) AS sumAmount 
                FROM
                    (
                    SELECT
                        servicedetail.DTSER_DATE,
                        servicedetail.DTSER_TIME,
                        servicedetail.DTSER_STATUS,
                        servicedetailprosetdetail.DPRODTSER_STATUS,
                        servicedetail.DTSER_NOTE,
                        servicedetail.DTSER_TYPEUSE,
                        IFNULL( servicedetailprosetdetail.DPRODTSER_STATUS, servicedetail.DTSER_STATUS ) AS DT_STATUS,
                        SUM( IFNULL( servicedetailprosetdetail.DPRODTSER_AMOUNT, servicedetail.DTSER_AMOUNT ) ) AS DT_AMOUNT,
                        product.PRODUCT_ID,
                        product.PRODUCT_NAME 
                    FROM
                        servicedetail
                        LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                        LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                        LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                        LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
                        LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                    WHERE
                        typeproduct.TYPEPRODUCT_GROUP = '1' 
                        AND servicedetail.DTSER_STATUS IN ( 0, 1 ) 
                    GROUP BY
                        servicedetail.DTSER_NOTE,
                        servicedetail.DTSER_TYPEUSE,
                        servicedetail.DTSER_STATUS,
                        servicedetailprosetdetail.DPRODTSER_STATUS,
                        product.PRODUCT_ID 
                    ) dtser 
                GROUP BY
                    dtser.PRODUCT_ID,
                    dtser.DTSER_NOTE,
                    dtser.DTSER_TYPEUSE,
                    dtser.DT_STATUS
                HAVING  	sumAmount > 1   
                ORDER BY
                    dtser.DTSER_DATE ASC,
                    dtser.DTSER_TIME ASC 
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function kitchenFoodSameIdNo()
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    product.PRODUCT_ID,
                    servicedetail.DTSER_STATUS,
                    servicedetail.DTSER_NOTE,
                    servicedetail.DTSER_TYPEUSE,
                    servicedetail.DTSER_DATE,
	                servicedetail.DTSER_TIME 
                FROM
                    servicedetail
                    LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                    LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                    LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                    LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
                    LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                WHERE
                    typeproduct.TYPEPRODUCT_GROUP = '1' 
                    AND servicedetail.DTSER_STATUS IN ( 0, 1 ) 
                ORDER BY
                    servicedetail.DTSER_DATE,
                    servicedetail.DTSER_TIME
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function checkSameTypeOrder($serviceID, $serviceNO)
    {
        $sql = "SELECT DTSER_TYPEORDER FROM servicedetail
        WHERE DTSER_ID = '$serviceID'
        AND DTSER_NO = '$serviceNO'
        ";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->DTSER_TYPEORDER;
        }
    }

    public function findKeySameOrder($serviceID, $serviceNO, $serviceDate, $serviceTime, $productID)
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    servicedetailprosetdetail.DPRODTSER_DETAILNO 
                FROM
                    servicedetail
                    JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO ) 
                WHERE
                    servicedetail.DTSER_ID = '$serviceID' 
                    AND servicedetail.DTSER_NO = '$serviceNO' 
                    AND servicedetail.DTSER_DATE = '$serviceDate' 
                    AND servicedetail.DTSER_TIME = '$serviceTime' 
                    AND servicedetailprosetdetail.DPRODTSER_PRODUCTID = '$productID'
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function checkStatusProset($serviceID, $serviceNO)
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    COUNT( servicedetailprosetdetail.DPRODTSER_STATUS ) AS CNT 
                FROM
                    servicedetail
                    JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO ) 
                WHERE
                    servicedetailprosetdetail.DPRODTSER_STATUS = '1' 
                    AND servicedetail.DTSER_ID = '$serviceID' 
                    AND servicedetail.DTSER_NO = '$serviceNO' 
                GROUP BY
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function updateDetailProset($serviceID, $serviceNO, $serviceDetailNo)
    {
        $sql = "UPDATE servicedetailprosetdetail
                SET DPRODTSER_STATUS = '1'
                WHERE  DPRODTSER_SERVICEID = '$serviceID'
                AND DPRODTSER_NO = '$serviceNO'
                AND DPRODTSER_DETAILNO = '$serviceDetailNo'
        ";
         $this->db->query($sql);
    }

    
    public function updateServiceDetailProset($serviceID, $serviceNO)
    {
        $sql = "UPDATE servicedetail
                SET DTSER_STATUS = '1'
                WHERE DTSER_ID = '$serviceID'
                AND   DTSER_NO = '$serviceNO'
                ";
         $this->db->query($sql);
    }

}
