<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kitchen_model extends CI_Model
{
    public function kitchen($typrproductGroup)
    {
        // $sql = "SELECT
        //             servicedetail.DTSER_ID,
        //             servicedetail.DTSER_NO,
        //             product.PRODUCT_ID,
        //             product.PRODUCT_NAME,
        //             servicedetail.DTSER_TYPEORDER,
        //             servicedetail.DTSER_TYPEUSE,
        //             servicedetail.DTSER_AMOUNT,
        //             servicedetailprosetdetail.DPRODTSER_AMOUNT,
        //             servicedetail.DTSER_NOTE,
        //             servicedetail.DTSER_STATUS,
        //             servicedetailprosetdetail.DPRODTSER_STATUS
        //         FROM
        //             servicedetail
        //             LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
        //             LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
        //             LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
        //             LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
        //             LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
        //             LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
        //         WHERE
        //             typeproduct.TYPEPRODUCT_GROUP = '$typrproductGroup' 
        //             AND 
        //             (
        // 				(
        // 		    	servicedetail.DTSER_STATUS IN ( 0, 1 ) OR  servicedetailprosetdetail.DPRODTSER_STATUS IN ( 0, 1 )
        // 				)
        // 				OR
        // 				(
        // 				servicedetail.DTSER_STATUS IN ( 0, 1 ) AND  servicedetailprosetdetail.DPRODTSER_STATUS IN ( 0, 1 )
        // 				)
        // 			)										
        //         ORDER BY
        //             servicedetail.DTSER_DATE ASC,
        //             servicedetail.DTSER_TIME ASC
        // ";
        $sql = "SELECT
                    * 
                FROM
                    (
                    SELECT
                        servicedetail.DTSER_ID,
                        servicedetail.DTSER_NO,
                        product.PRODUCT_ID,
                        product.PRODUCT_NAME,
                        servicedetail.DTSER_DATE,
                        servicedetail.DTSER_TIME,
                        servicedetail.DTSER_TYPEORDER,
                        servicedetail.DTSER_TYPEUSE,
                        servicedetail.DTSER_AMOUNT,
                        servicedetailprosetdetail.DPRODTSER_AMOUNT,
                        servicedetail.DTSER_NOTE,
                        servicedetail.DTSER_STATUS,
                        servicedetailprosetdetail.DPRODTSER_STATUS,
                        IFNULL( servicedetailprosetdetail.DPRODTSER_STATUS, servicedetail.DTSER_STATUS ) AS cc 
                    FROM
                        servicedetail
                        LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                        LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                        LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                        LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                        LEFT JOIN product ON ( servicedetailfd.FDDTSER_PRODUCTID = product.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = product.PRODUCT_ID )
                        LEFT JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                    WHERE
                        typeproduct.TYPEPRODUCT_GROUP = '$typrproductGroup' 
                        AND (
                            ( servicedetail.DTSER_STATUS IN ( 0, 1 ) ) 
                            OR ( servicedetail.DTSER_STATUS IN ( 0, 1 ) AND servicedetailprosetdetail.DPRODTSER_STATUS IN ( 0, 1 ) ) 
                        ) 
                    ) std 
                WHERE
                    std.cc != 2 
                ORDER BY
                    std.DTSER_DATE ASC,
                    std.DTSER_TIME ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function kitchenSame($typrproductGroup)
    {

        $sql = "SELECT
        dtser.PRODUCT_ID,
        dtser.PRODUCT_NAME,
        dtser.DTSER_NOTE,
        dtser.DTSER_TYPEUSE,
        dtser.DT_STATUS,
        dtser.DTSER_STATUS,
        dtser.DPRODTSER_STATUS,
        SUM( dtser.DT_AMOUNT ) AS sumAmount,
        IFNULL( dtser.DPRODTSER_STATUS, dtser.DTSER_STATUS ) AS cc 
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
            pd.PRODUCT_ID,
            pd.PRODUCT_NAME 
        FROM
            servicedetail
            LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
            LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
            LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
            LEFT JOIN (
            SELECT
                product.PRODUCT_ID,
                product.PRODUCT_NAME 
            FROM
                product
                JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
            WHERE
                typeproduct.TYPEPRODUCT_GROUP = '$typrproductGroup' 
            ) pd ON ( servicedetailfd.FDDTSER_PRODUCTID = pd.PRODUCT_ID OR servicedetailprosetdetail.DPRODTSER_PRODUCTID = pd.PRODUCT_ID ) 
        WHERE
            servicedetail.DTSER_STATUS IN ( 0, 1 ) 
            OR servicedetailprosetdetail.DPRODTSER_STATUS IN ( 0, 1 ) 
        GROUP BY
            servicedetail.DTSER_NOTE,
            servicedetail.DTSER_TYPEUSE,
            servicedetail.DTSER_STATUS,
            servicedetailprosetdetail.DPRODTSER_STATUS,
            pd.PRODUCT_ID 
        ) dtser 
        WHERE dtser.PRODUCT_ID IS NOT NULL
    GROUP BY
        dtser.PRODUCT_ID,
        dtser.DTSER_NOTE,
        dtser.DTSER_TYPEUSE,
        dtser.DT_STATUS 
    HAVING
        sumAmount > 1 
        AND cc != 2 
    ORDER BY
        cc DESC,
        dtser.DTSER_DATE ASC,
        dtser.DTSER_TIME ASC
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function kitchenSameIdNo($typrproductGroup)
    {
        $sql = "SELECT
                    servicedetail.DTSER_ID,
                    servicedetail.DTSER_NO,
                    product.PRODUCT_ID,
                    servicedetail.DTSER_STATUS,
                    servicedetail.DTSER_NOTE,
                    servicedetail.DTSER_TYPEUSE,
                    servicedetail.DTSER_DATE,
	                servicedetail.DTSER_TIME,
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
                    typeproduct.TYPEPRODUCT_GROUP = '$typrproductGroup' 
                    AND servicedetail.DTSER_STATUS IN ( 0, 1 ) 
                    OR servicedetailprosetdetail.DPRODTSER_STATUS IN ( 0, 1 ) 
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

    // AND servicedetail.DTSER_DATE = '$serviceDate' 
    // AND servicedetail.DTSER_TIME = '$serviceTime' 
    // $serviceDate, $serviceTime,
    public function findKeySameOrder($serviceID, $serviceNO,  $productID)
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

    public function updateDetailFoodDrink($serviceID, $serviceNO, $status)
    {
        $sql = "UPDATE servicedetail 
                SET DTSER_STATUS = '$status' 
                WHERE
                    DTSER_ID = '$serviceID' 
                    AND DTSER_NO = '$serviceNO'
            ";
        $this->db->query($sql);
    }

    public function updateDetailProset($serviceID, $serviceNO, $serviceDetailNo, $status)
    {
        $sql = "UPDATE servicedetailprosetdetail
                SET DPRODTSER_STATUS = '$status'
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

    public function updateServiceDetailProsetServed($serviceID, $serviceNO)
    {
        $sql = "UPDATE serviceDetail 
        SET DTSER_STATUS = '3' 
        WHERE
            DTSER_ID = '$serviceID' 
            AND DTSER_NO = '$serviceNO' 
            AND ( SELECT COUNT( * ) FROM servicedetailprosetdetail WHERE DPRODTSER_SERVICEID = '$serviceID' AND DPRODTSER_NO = '$serviceNO' ) 
            = ( SELECT COUNT( * ) FROM servicedetailprosetdetail WHERE DPRODTSER_SERVICEID = '$serviceID' AND DPRODTSER_NO = '$serviceNO' AND DPRODTSER_STATUS = '3' )";
        $this->db->query($sql);
    }

    public function ingredient($search, $limit, $offset)
    {
        $sql = "SELECT
                    INGREDIENT_ID,
                    INGREDIENT_NAME,
                    INGREDIENT_ACTIVE,
                CASE 
                        WHEN INGREDIENT_ACTIVE = '1' THEN
                        'มี' ELSE 'หมด' 
                    END AS INGREDIENT_ACTIVEE 
                FROM
                    ingredient 
                WHERE
                    INGREDIENT_STATUS = '1' 
                    AND ( 
                        INGREDIENT_NAME LIKE ? OR 
                        CASE WHEN INGREDIENT_ACTIVE = '1' THEN 'มี' ELSE 'หมด' END LIKE ?
                        )
                 LIMIT $offset,$limit   
                    ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
            )
        );
        return $query->result();
    }

    public function countAllIngredient($search)
    {
        $sql = "SELECT COUNT(*) as cnt
    FROM
        ingredient 
    WHERE
        INGREDIENT_STATUS = '1' 
        AND ( 
            INGREDIENT_NAME LIKE ? OR 
            CASE WHEN INGREDIENT_ACTIVE = '1' THEN 'มี' ELSE 'หมด' END LIKE ? 
            )
        ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),

            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function ingredientFood($ingredientID)
    {
        $sql = "UPDATE product 
                SET PRODUCT_ACTIVE = '2' 
                WHERE
                    PRODUCT_ID IN (
                    SELECT
                        ingd.PRODUCT_ID 
                    FROM
                        (
                        SELECT
                            recipe.RECIPE_ID,
                            recipedetail.RECIPEDETAIL_NO,
                            recipedetail.RECIPEDETAIL_IMPORTANT,
                            ingredient.INGREDIENT_NAME,
                            product.PRODUCT_ID,
                            product.PRODUCT_NAME,
                            ingredient.INGREDIENT_ACTIVE 
                        FROM
                            ingredient
                            JOIN recipedetail ON ingredient.INGREDIENT_ID = recipedetail.RECIPEDETAIL_INGREDIENT
                            JOIN recipe ON recipedetail.RECIPEDETAIL_RECIPEID = recipe.RECIPE_ID
                            JOIN product ON recipe.RECIPE_PRODUCT = product.PRODUCT_ID 
                        WHERE
                            ingredient.INGREDIENT_ID = '$ingredientID' 
                            AND recipedetail.RECIPEDETAIL_IMPORTANT = '1' 
                        ) ingd 
                    GROUP BY
                        ingd.PRODUCT_ID 
                    )
        ";

        $this->db->query($sql);
    }

    public function changeStatusProduct($ingredientID)
    {
        $sql = "UPDATE product 
                SET PRODUCT_ACTIVE ='1'
                WHERE PRODUCT_ID IN (SELECT ss.PRODUCT_ID FROM 
                (SELECT
                    product.PRODUCT_ID,
                    COUNT( * ) AS impAll,
                    dts.impnow 
                FROM
                    recipedetail
                    JOIN (
                    SELECT
                        recipe.RECIPE_ID,
                        COUNT( * ) AS impnow 
                    FROM
                        recipe
                        JOIN recipedetail ON recipe.RECIPE_ID = recipedetail.RECIPEDETAIL_RECIPEID
                        JOIN ingredient ON recipedetail.RECIPEDETAIL_INGREDIENT = ingredient.INGREDIENT_ID 
                    WHERE
                        recipedetail.RECIPEDETAIL_RECIPEID IN ( SELECT RECIPEDETAIL_RECIPEID FROM recipedetail WHERE RECIPEDETAIL_INGREDIENT = '$ingredientID' AND RECIPEDETAIL_IMPORTANT = '1' ) 
                        AND recipedetail.RECIPEDETAIL_IMPORTANT = '1' 
                        AND ingredient.INGREDIENT_ACTIVE = '1' 
                    GROUP BY
                        recipe.RECIPE_ID 
                    ) dts ON recipedetail.RECIPEDETAIL_RECIPEID = dts.RECIPE_ID 
                    LEFT JOIN recipe ON recipe.RECIPE_ID = recipedetail.RECIPEDETAIL_RECIPEID
                    LEFT JOIN product ON recipe.RECIPE_PRODUCT = product.PRODUCT_ID
                WHERE
                    recipedetail.RECIPEDETAIL_RECIPEID IN ( SELECT RECIPEDETAIL_RECIPEID FROM recipedetail WHERE RECIPEDETAIL_INGREDIENT = '$ingredientID' AND RECIPEDETAIL_IMPORTANT = '1' ) 
                    AND recipedetail.RECIPEDETAIL_IMPORTANT = '1' 
                GROUP BY
                    recipedetail.RECIPEDETAIL_RECIPEID
                    HAVING impAll = dts.impnow) ss)
                ";
        $this->db->query($sql);
    }

    public function drink($search, $limit, $offset)
    {
        $sql = "SELECT
                    PRODUCT_ID,
                    PRODUCT_NAME,
                    PRODUCT_ACTIVE,
                CASE
                        
                        WHEN PRODUCT_ACTIVE = '1' THEN
                        'มี' ELSE 'หมด' 
                    END AS PRODUCT_ACTIVEE 
                FROM
                    product
                    JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                WHERE
                    PRODUCT_STATUS = '1' 
                    AND typeproduct.TYPEPRODUCT_GROUP = '2' 
                    AND ( PRODUCT_NAME LIKE ? OR CASE WHEN PRODUCT_ACTIVE = '1' THEN 'มี' ELSE 'หมด' END LIKE ? )
                LIMIT $offset,$limit   
                    ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),
            )
        );
        return $query->result();
    }

    public function countAlldrink($search)
    {
        $sql = "SELECT
                    COUNT(*) as cnt
                FROM
                    product
                    JOIN typeproduct ON product.PRODUCT_TYPEPRODUCT = typeproduct.TYPEPRODUCT_ID 
                WHERE
                    PRODUCT_STATUS = '1' 
                    AND typeproduct.TYPEPRODUCT_GROUP = '2' 
                    AND ( PRODUCT_NAME LIKE ? OR CASE WHEN PRODUCT_ACTIVE = '1' THEN 'มี' ELSE 'หมด' END LIKE ? )
                ";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search),

            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
}
