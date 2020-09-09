<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model
{

    function fetchEmp()
    {
        $sql = "SELECT * FROM employee left join position  on employee.POSITION = position.POSITION_ID inner join department 
                on department.DEPARTMENT_ID = position.DEPT_ID   WHERE STATUS = '1' ORDER BY ID ASC";
        return $this->db->query($sql)->result();
    }

    function editEmp($id)
    {
        $sql = "SELECT * FROM employee e inner join position p inner join department d on
                e.POSITION = p.POSITION_ID and p.DEPT_ID = d.DEPARTMENT_ID WHERE e.ID = $id";
        return $this->db->query($sql)->result();
    }

    function searchEmployee($search = '')
    {
        $this->db->select('employee.ID,employee.FIRSTNAME,employee.LASTNAME,employee.EMAIL,
                        department.DEPARTMENT_NAME,position.POSITION_NAME,employee.SALARY');
        $this->db->from('employee');
        $this->db->join('position', 'position.POSITION_ID = employee.POSITION','left');
        $this->db->join('department', 'position.DEPT_ID = department.DEPARTMENT_ID','left');
        $this->db->like("employee.ID", $search);
        $this->db->or_like("employee.FIRSTNAME", $search);
        $this->db->or_like("employee.LASTNAME", $search);
        $this->db->or_like("employee.EMAIL", $search);
        $this->db->or_like("department.DEPARTMENT_NAME", $search);
        $this->db->or_like("position.POSITION_NAME", $search);
        $this->db->or_like("employee.salary", $search);
        $this->db->order_by("department.DEPARTMENT_ID",'ASC');
        $this->db->order_by("employee.ID",'ASC');
        $query = $this->db->get();
        return $query->result();;
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
        $this->db->join('department','position.DEPT_ID = department.DEPARTMENT_ID','left');
        $this->db->like('POSITION_NAME', $search);
        $this->db->or_like('DEPARTMENT_NAME', $search);
        $this->db->order_by('DEPARTMENT_ID','DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
