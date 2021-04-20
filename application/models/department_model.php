<?php
defined('BASEPATH') or exit('No direct script access allowed');

class department_model extends CI_Model
{

    //Department Start
    public function department($search = '', $limit, $offset)
    {
        $sql = "SELECT DEPARTMENT_ID,DEPARTMENT_NAME FROM department 
        where DEPARTMENT_STATUS = '1'
        AND
        (
            DEPARTMENT_ID LIKE  ? OR
            DEPARTMENT_NAME LIKE ? 
        )
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllDepartment($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM department 
        where DEPARTMENT_STATUS = '1'
        AND 
        (
            DEPARTMENT_ID LIKE  ? OR
            DEPARTMENT_NAME LIKE ? 
        )
        ";

        $query = $this->db->query(
            $sql,
            array(
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

    public function checkEmpForDelDep($depID)
    {
        $sql = "SELECT COUNT(*) as cnt FROM department 
        JOIN position ON department.DEPARTMENT_ID = position.POSITION_DEPARTMENT
        JOIN employee ON position.POSITION_ID = employee.EMPLOYEE_POSITION
        WHERE department.DEPARTMENT_ID = '$depID'
        AND employee.EMPLOYEE_STATUS = '1'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
    //Department End
}
