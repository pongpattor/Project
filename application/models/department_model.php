<?php
defined('BASEPATH') or exit('No direct script access allowed');

class department_model extends CI_Model
{

    //Department Start
    function Department($search = '', $limit, $offset)
    {
        $sql = "SELECT DEPARTMENT_ID,DEPARTMENT_NAME FROM department 
        where
        (
            DEPARTMENT_ID LIKE  ? OR
            DEPARTMENT_NAME LIKE ? 
        )
        ORDER BY DEPARTMENT_ID ASC
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    function countAllDepartment($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM department 
        where
        (
            DEPARTMENT_ID LIKE  ? OR
            DEPARTMENT_NAME LIKE ? 
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
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

    function maxIdDepartment()
    {
        $sql = 'SELECT MAX(DEPARTMENT_ID) as MID from department';
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }

    function editDept($id)
    {
        $sql = "SELECT * FROM department 
        WHERE DEPARTMENT_ID = '$id'";
        return $this->db->query($sql)->result();
    }
    //Department End
}