<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model
{

    function fetchEmp($search = '', $limit, $offset)
    {
        $sql = "SELECT employee.ID,employee.FIRSTNAME,employee.LASTNAME,employee.EMAIL,
        department.DEPARTMENT_NAME,position.POSITION_NAME,employee.SALARY,employee.IMG FROM employee 
        LEFT JOIN position ON position.POSITION_ID = employee.POSITION
        LEFT JOIN department ON position.DEPT_ID = department.DEPARTMENT_ID
        WHERE employee.STATUS = 1 AND
        (
            employee.ID LIKE  ? OR
            employee.FIRSTNAME LIKE ? OR
            employee.LASTNAME LIKE ? OR
            employee.EMAIL LIKE ? OR
            employee.salary LIKE ? OR
            department.DEPARTMENT_NAME LIKE ? OR
            position.POSITION_NAME LIKE ?
        )
        ORDER BY department.DEPARTMENT_ID ASC , employee.ID ASC
        LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%'
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    function countEmployee($search)
    {
        $sql = "SELECT COUNT(*) as cnt FROM employee 
        LEFT JOIN position ON position.POSITION_ID = employee.POSITION
        LEFT JOIN department ON position.DEPT_ID = department.DEPARTMENT_ID
        WHERE employee.STATUS = 1 AND
        (
            employee.ID LIKE  ? OR
            employee.FIRSTNAME LIKE ? OR
            employee.LASTNAME LIKE ? OR
            employee.EMAIL LIKE ? OR
            employee.salary LIKE ? OR
            department.DEPARTMENT_NAME LIKE ? OR
            position.POSITION_NAME LIKE ?
        ) ";
        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%'
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));   
        // echo '</pre>' ;
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    function editEmp($id)
    {
        $sql = "SELECT * FROM employee e inner join position p inner join department d on
                e.POSITION = p.POSITION_ID and p.DEPT_ID = d.DEPARTMENT_ID WHERE e.ID = $id";
        return $this->db->query($sql)->result();
    }


    function delEmp($ID, $delete_at)
    {
        $sql = "UPDATE employee SET STATUS = '0' , DELETE_AT = '$delete_at' WHERE ID = '$ID'";
        return $this->db->query($sql);
    }

    function maxIdEmp($position_id)
    {
        $sql = "SELECT MAX(ID)as'MID'  FROM employee where POSITION = $position_id";
        $query = $this->db->query($sql)->result();
        foreach ($query as $row) {
            return $row->MID;
        }
    }

    function checkIdCard($idCard)
    {
        $sql = "SELECT COUNT(IDCARD) as num FROM employee where IDCARD = $idCard and STATUS = 1";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->num;
        }
    }

    function fetctDeptHead()
    {
        $sql = "SELECT DEPARTMENT_ID,DEPARTMENT_NAME,DEPARTMENT_HEAD,FIRSTNAME,LASTNAME,ID FROM department LEFT JOIN employee ON DEPARTMENT_HEAD = ID";
        return $this->db->query($sql)->result();
    }

    function editDept($id)
    {
        $sql = "SELECT * FROM department 
        WHERE DEPARTMENT_ID = $id";
        return $this->db->query($sql)->result();
    }

    function position()
    {
        $sql = 'SELECT * FROM position inner join department on DEPT_ID = DEPARTMENT_ID ORDER BY DEPARTMENT_NAME,POSITION_NAME';
        return $this->db->query($sql)->result();
    }

    function editPos($id)
    {
        $sql = "SELECT * FROM position 
        WHERE POSITION_ID = $id";
        return $this->db->query($sql)->result();
    }

    function rowEmployee()
    {
        $sql = "SELECT COUNT(*) FROM employee";
        return $this->db->query($sql)->result();
    }

    function PhoneEmployee($ID)
    {
        $sql = "SELECT PHONE FROM employee_telephone et inner join employee e on et.EMPLOYEE_ID=e.ID WHERE e.ID = $ID";
        return $this->db->query($sql)->result();
    }

    //department
    function searchDepartment($search = '')
    {
        $this->db->select('*');
        $this->db->from('department');
        $this->db->like('DEPARTMENT_ID', $search);
        $this->db->or_like('DEPARTMENT_NAME', $search);
        $query = $this->db->get();
        return $query->result();
    }

    //Position
    function searchPosition($search = '')
    {
        $this->db->select('*');
        $this->db->from('position');
        $this->db->join('department', 'position.DEPT_ID = department.DEPARTMENT_ID', 'left');
        $this->db->like('POSITION_NAME', $search);
        $this->db->or_like('DEPARTMENT_NAME', $search);
        $this->db->order_by('DEPARTMENT_ID', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
