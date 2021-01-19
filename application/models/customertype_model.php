<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customertype_model extends CI_Model
{

    public function customerType($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM customertype 
        where 
        (
            CUSTOMERTYPE_ID LIKE  ? OR
            CUSTOMERTYPE_NAME LIKE ? OR
            CUSTOMERTYPE_DISCOUNT LIKE ? OR
            CUSTOMERTYPE_DISCOUNTBDATE LIKE ?
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
            )
        );
        //ตรวจ SQL
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllCustomerType($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM customertype 
        where 
        (
            CUSTOMERTYPE_ID LIKE  ? OR
            CUSTOMERTYPE_NAME LIKE ? OR
            CUSTOMERTYPE_DISCOUNT LIKE ? OR
            CUSTOMERTYPE_DISCOUNTBDATE LIKE ?
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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

    public function checkCustomerTypeName($customerTypeName)
    {
        $sql = "SELECT COUNT(*) as cnt FROM customertype
                WHERE CUSTOMERTYPE_NAME = ?";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($customerTypeName),
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function maxID(){
        $sql = "SELECT MAX(CUSTOMERTYPE_ID) as maxID FROM customertype";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            return $row->maxID;
        }
    }
}
