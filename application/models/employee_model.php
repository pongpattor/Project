<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model
{

    //Employee Start 
    public function employee($search = '', $limit, $offset)
    {
        $sql = "SELECT emp.EMPLOYEE_ID,emp.EMPLOYEE_FIRSTNAME,emp.EMPLOYEE_LASTNAME,
        emp.EMPLOYEE_IMAGE,position.POSITION_NAME,department.DEPARTMENT_NAME,RPAD(LPAD(emp.EMPLOYEE_ID,11,\"\'\"),12,\"\'\") as empID
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
                $this->db->escape_like_str($search). '%',
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
                $this->db->escape_like_str($search). '%',
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

    public function fetchEmployeeTel($employeeTel){
        $sql = "SELECT EMPLOYEETEL_ID,EMPLOYEETEL_TEL FROM employeeTel
        where EMPLOYEETEL_ID IN ($employeeTel)";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function editEmp($id)
    {
        $sql = "SELECT e.ID,e.`PASSWORD`,e.IDCARD,e.TITLENAME,e.FIRSTNAME,e.LASTNAME,e.GENDER,e.EMAIL,e.BDATE,
        e.ADDRESS,e.SALARY,e.IMG,p.POSITION_ID,d.DEPARTMENT_ID,di.D_PROVINCE_ID,di.D_AMPHUR_ID,di.DISTRICT_ID,
        di.POSTCODE,e.BLOOD,e.NATIONALITY,.e.RELIGION
        FROM employee e 
        left join position p on e.POSITION = p.POSITION_ID 
        left join department d on p.DEPT_ID = d.DEPARTMENT_ID 
        left join district di on e.DISTRICT = di.DISTRICT_ID
        WHERE e.ID = $id";
        $query = $this->db->query($sql);
        // echo '<pre>';
        // print_r($this->db->last_query($query));   
        // echo '</pre>' ;
        return $query->result();
    }


    public function delEmp($ID, $delete_at)
    {
        $sql = "UPDATE employee SET STATUS = '0' , DELETE_AT = '$delete_at' WHERE ID = '$ID'";
        return $this->db->query($sql);
    }

    public function maxIdEmployee($idDept)
    {
        $sql = "SELECT MAX(ID)as'MID',d.DEPARTMENT_ID  FROM employee e
        inner join position p ON e.POSITION = p.POSITION_ID
        inner join department d ON p.DEPT_ID = d.DEPARTMENT_ID
        where d.DEPARTMENT_ID = '$idDept'";
        $query = $this->db->query($sql)->result();
        foreach ($query as $row) {
            return $row->MID;
        }
    }



    public function idDeptGenIdEmp($position_id)
    {
        $sql = "SELECT department.DEPARTMENT_ID as DID FROM department
                INNER JOIN position ON department.DEPARTMENT_ID = position.DEPT_ID
                WHERE position.POSITION_ID= '$position_id'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->DID;
        }
    }

    public function checkIdCard($idCard)
    {
        $sql = "SELECT COUNT(IDCARD) as num FROM employee where IDCARD = $idCard and STATUS = 1";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->num;
        }
    }

    public function checkIdCardUpdate($idCard, $oldidcard)
    {
        $sql = "SELECT COUNT(*) as num FROM employee 
        where IDCARD = $idCard 
        and IDCARD NOT LIKE $oldidcard
        and STATUS = 1";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            return $row->num;
        }
    }

    public function PhoneEmployee($ID)
    {
        $sql = "SELECT PHONE FROM employee_telephone et inner join employee e on et.EMPLOYEE_ID=e.ID WHERE e.ID = $ID";
        return $this->db->query($sql)->result();
    }

    public function checkPhoneNumber($idEmployee, $Phone)
    {
        $sql = "SELECT COUNT(*) as cnt FROM employee_telephone et
        left join employee e ON et.EMPLOYEE_ID = e.ID
        WHERE et.EMPLOYEE_ID = '$idEmployee'
        and et.PHONE = '$Phone'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }
    //Employee End

    public function checklogin($username, $password)
    {
        $sql = " SELECT COUNT(*) as cnt FROM employee
        WHERE ID = ? and PASSWORD = ? and STATUS IN (1,9)";

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
        $sql = " SELECT employee.ID,employee.FIRSTNAME,employee.LASTNAME,position.PERMISSION FROM employee 
        LEFT JOIN position ON employee.POSITION = position.POSITION_ID
        WHERE ID = ? and PASSWORD = ? and STATUS IN (1,9)";  //9 is test system

        $query = $this->db->query($sql, array(
            $this->db->escape_like_str($username),
            $this->db->escape_like_str($password),
        ));
        return $query->result();
    }


    public function newSession($employeeID)
    {
        $sql = "SELECT position.PERMISSION FROM employee LEFT JOIN position ON employee.POSITION = position.POSITION_ID
        WHERE ID = '$employeeID'";
        return $this->db->query($sql)->result();
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

    public function ResetPassword($empID, $newPass)
    {
        $sql = "UPDATE employee SET PASSWORD = '$newPass' WHERE ID = '$empID'";
        $this->db->query($sql);
    }
}
