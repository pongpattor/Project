<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product_model extends CI_Model
{

    public function typeProduct($search = '', $limit, $offset)
    {
        $sql = "SELECT * FROM typeproduct 
        where 
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? OR
            TYPEPRODUCT_GROUP LIKE ?

        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',

            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }



    public function countAllProduct($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM typeproduct 
        where
        (
            TYPEPRODUCT_ID LIKE  ? OR
            TYPEPRODUCT_NAME LIKE ? OR
            TYPEPRODUCT_GROUP LIKE ?
        )
        ";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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

    public function maxTypeProductId(){
        $sql = "SELECT MAX(TYPEPRODUCT_ID) as MID from typeproduct";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            return $row->MID;
        }
    }

    public function checkTypeProductName($typeProductName,$typeProductGroup){
        $sql = " SELECT COUNT(*) as cnt FROM  typeproduct
                WHERE TYPEPRODUCT_NAME = '$typeProductName'
                and TYPEPRODUCT_GROUP = '$typeProductGroup'";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            return $row->cnt;
        }
    }

    public function checkTypeProductNameUpdate($typeProductName,$typeProductGroup){
        $sql = " SELECT COUNT(*) as cnt FROM  typeproduct
                WHERE TYPEPRODUCT_NAME = '$typeProductName'
                and TYPEPRODUCT_GROUP = '$typeProductGroup'";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            return $row->cnt;
        }
    }

    
    public function editTypeProduct($typeProductId){
        $sql = "SELECT * FROM typeproduct WHERE TYPEPRODUCT_ID = '$typeProductId'";
        return $this->db->query($sql)->result();
    }

    
}
