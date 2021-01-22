<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer_model extends CI_Model
{

    public function customer($search = '', $limit, $offset)
    {
        $sql = "SELECT customer.CUSTOMER_ID,customer.CUSTOMER_FIRSTNAME,customer.CUSTOMER_LASTNAME
        ,customertype.CUSTOMERTYPE_NAME,customertel.CUSTOMERTEL_TEL,RPAD(LPAD(customer.CUSTOMER_ID,13,\"\'\"),14,\"\'\") as cusID
        FROM customer 
         JOIN customertel
        ON customer.CUSTOMER_ID = customertel.CUSTOMERTEL_ID
        LEFT JOIN customertype 
        ON customer.CUSTOMER_CUSTOMERTYPE = customertype.CUSTOMERTYPE_ID
        where  customer.CUSTOMER_STATUS = '1'
        AND
        (
            customer.CUSTOMER_ID LIKE  ? OR
            customer.CUSTOMER_FIRSTNAME LIKE ? OR
            customer.CUSTOMER_LASTNAME LIKE ? OR
            customertype.CUSTOMERTYPE_NAME LIKE ? OR
            customertel.CUSTOMERTEL_TEL LIKE ?
        )
        GROUP BY customer.CUSTOMER_ID
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',

            )
        );
        //ตรวจ SQL
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllCustomer($search = '')
    {

        $sql = "SELECT COUNT(*) AS cnt
        FROM (SELECT * FROM customer 
              JOIN customertel
            ON customer.CUSTOMER_ID = customertel.CUSTOMERTEL_ID
            LEFT JOIN customertype 
            ON customer.CUSTOMER_CUSTOMERTYPE = customertype.CUSTOMERTYPE_ID
            WHERE  customer.CUSTOMER_STATUS = '1'
            AND
            (
                customer.CUSTOMER_ID LIKE  ? OR
                customer.CUSTOMER_FIRSTNAME LIKE ? OR
                customer.CUSTOMER_LASTNAME LIKE ? OR
                customertype.CUSTOMERTYPE_NAME LIKE ? OR
                customertel.CUSTOMERTEL_TEL LIKE ?
            )
			GROUP BY customer.CUSTOMER_ID) cus
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
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

    public function fetchCustomerTel($customerID)
    {
        $sql = "SELECT * FROM customertel
        where CUSTOMERTEL_ID IN ($customerID)";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function checkCustomerTel($customerTel){
        $sql = "SELECT COUNT(*) AS cnt FROM customer
        JOIN customertel
        ON customer.CUSTOMER_ID = customertel.CUSTOMERTEL_ID
        WHERE customertel.CUSTOMERTEL_TEL IN ($customerTel)
        AND customer.CUSTOMER_STATUS = '1'";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach($query->result() as $row){
            return $row->cnt;
        }
    }

    public function editCustomer($customerID){
        $sql = "SELECT  customer.CUSTOMER_ID,customer.CUSTOMER_IDCARD,customer.CUSTOMER_FIRSTNAME,customer.CUSTOMER_LASTNAME,
                        customer.CUSTOMER_GENDER,customer.CUSTOMER_BDATE,customer.CUSTOMER_ADDRESS,customer.CUSTOMER_CUSTOMERTYPE,
                        province.PROVINCE_ID,amphur.AMPHUR_ID,district.DISTRICT_ID,DISTRICT.POSTCODE
                FROM customer
                LEFT JOIN customertype
                ON customer.CUSTOMER_CUSTOMERTYPE = customertype.CUSTOMERTYPE_ID
                JOIN district
                ON customer.CUSTOMER_DISTRICT = district.DISTRICT_ID
                JOIN amphur
                ON district.D_AMPHUR_ID = amphur.AMPHUR_ID
                JOIN province
                ON amphur.A_PROVINCE_ID = province.PROVINCE_ID
                WHERE customer.CUSTOMER_ID = '$customerID'";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

}
