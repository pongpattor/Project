<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model
{

    //Employee Start 
    public function employee($search = '', $limit, $offset)
    {
        $sql = "SELECT emp.EMPLOYEE_ID,emp.EMPLOYEE_FIRSTNAME,emp.EMPLOYEE_LASTNAME,
        emp.EMPLOYEE_IMAGE,position.POSITION_NAME,department.DEPARTMENT_NAME,RPAD(LPAD(emp.EMPLOYEE_ID,13,\"\'\"),14,\"\'\") as empID
        FROM (SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME,
              employee.EMPLOYEE_IMAGE,employee.EMPLOYEE_POSITION ,employee.EMPLOYEE_STATUS,employeetel.EMPLOYEETEL_TEL
              FROM employee 
              LEFT JOIN employeetel 
              ON employee.EMPLOYEE_ID = employeetel.EMPLOYEETEL_ID
              ) emp
        LEFT JOIN position
            ON position.POSITION_ID = emp.EMPLOYEE_POSITION
        LEFT JOIN department
            ON position.POSITION_DEPARTMENT = department.DEPARTMENT_ID
        WHERE emp.EMPLOYEE_STATUS = '1'
        AND
                 (
                    emp.EMPLOYEE_ID LIKE ? OR
                    emp.EMPLOYEE_FIRSTNAME LIKE ? OR
                    emp.EMPLOYEE_LASTNAME LIKE ? OR
                    emp.EMPLOYEETEL_TEL LIKE ? OR
                    position.POSITION_NAME LIKE ? OR
                    department.DEPARTMENT_NAME LIKE ?
                    )
        GROUP BY emp.EMPLOYEE_ID		
            LIMIT $offset,$limit
        ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        return $query->result();
    }

    public function countAllEmployee($search)
    {
        $sql = "SELECT COUNT(*) as cnt FROM  
                    (SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME
                            ,employee.EMPLOYEE_IMAGE,employee.EMPLOYEE_POSITION,employee.EMPLOYEE_STATUS,employeetel.EMPLOYEETEL_TEL
                    FROM employee 
                    LEFT JOIN employeetel 
                        ON employee.EMPLOYEE_ID = employeetel.EMPLOYEETEL_ID
                    LEFT JOIN (SELECT position.POSITION_ID,position.POSITION_NAME,department.DEPARTMENT_NAME 
                                FROM position JOIN department 
                                    ON position.POSITION_DEPARTMENT = department.DEPARTMENT_ID) p
                         ON employee.EMPLOYEE_POSITION = p.POSITION_ID
                        WHERE employee.EMPLOYEE_STATUS = '1'
                            AND
                            (
                            employee.EMPLOYEE_ID LIKE ? OR
                            employee.EMPLOYEE_FIRSTNAME LIKE ? OR
                            employee.EMPLOYEE_LASTNAME LIKE ? OR
                            employeetel.EMPLOYEETEL_TEL LIKE ? OR
                            p.POSITION_NAME LIKE ? OR
                            p.DEPARTMENT_NAME LIKE ?
                            )
                        GROUP BY employee.EMPLOYEE_ID	
                    ) emp";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
            )
        );
        // echo '<pre>';
        // print_r($this->db->last_query($query));   
        // echo '</pre>' ;
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function fetchEmployeeTel($employeeTel)
    {
        $sql = "SELECT EMPLOYEETEL_ID,EMPLOYEETEL_TEL FROM employeeTel
        where EMPLOYEETEL_ID IN ($employeeTel)";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function editEmployee($employeeID)
    {
        $sql = "SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_IDCARD,employee.EMPLOYEE_IDCARD,employee.EMPLOYEE_FIRSTNAME,
                       employee.EMPLOYEE_LASTNAME,employee.EMPLOYEE_GENDER,employee.EMPLOYEE_EMAIL,employee.EMPLOYEE_ADDRESS,
                       employee.EMPLOYEE_SALARY,employee.EMPLOYEE_IMAGE,employee.EMPLOYEE_BDATE,position.POSITION_ID,
                       position.POSITION_DEPARTMENT,district.D_PROVINCE_ID,district.D_AMPHUR_ID,district.DISTRICT_ID,district.POSTCODE
                FROM employee
                    LEFT JOIN position
                        ON employee.EMPLOYEE_POSITION = position.POSITION_ID
                    LEFT JOIN district
                        ON employee.EMPLOYEE_DISTRICT = district.DISTRICT_ID
                    WHERE employee.EMPLOYEE_ID = '$employeeID'
        ";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));   
        // echo '</pre>' ;
        return $query->result();
    }






    public function checkIdCard($idCard)
    {
        $sql = "SELECT COUNT(IDCARD) as num FROM employee where IDCARD = $idCard and STATUS = 1";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->num;
        }
    }


    public function checklogin($username, $password)
    {
        $sql = " SELECT COUNT(*) as cnt FROM employee
        WHERE EMPLOYEE_ID = ? and EMPLOYEE_PASSWORD = ? and EMPLOYEE_STATUS = '1'";
        $query = $this->db->query($sql, array(
            $this->db->escape_like_str($username),
            $this->db->escape_like_str($password),
        ));
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    //Login
    public function login($username, $password)
    {
        $sql = " SELECT employee.EMPLOYEE_ID,employee.EMPLOYEE_FIRSTNAME,employee.EMPLOYEE_LASTNAME,
        position.POSITION_PERMISSION FROM employee 
        LEFT JOIN position ON employee.EMPLOYEE_POSITION = position.POSITION_ID
        WHERE employee.EMPLOYEE_ID = ? and employee.EMPLOYEE_PASSWORD = ? and employee.EMPLOYEE_STATUS = '1' ";  //9 is test system

        $query = $this->db->query($sql, array(
            $this->db->escape_like_str($username),
            $this->db->escape_like_str($password),
        ));
        return $query->result();
    }


    //ETC

    public function checkOldPass($empID)
    {
        $sql = "SELECT PASSWORD as pass FROM employee WHERE ID ='$empID'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->pass;
        }
    }

    public function rePassword($empID, $newPass)
    {
        $sql = "UPDATE employee SET PASSWORD = ? WHERE ID = ?";
        $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($newPass),
                $this->db->escape_like_str($empID),
            )
        );
    }

}
