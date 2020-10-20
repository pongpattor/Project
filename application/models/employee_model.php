<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model
{

    //Employee Start 
    public function employee($search = '', $limit, $offset)
    {
        $sql = "select e.ID,e.FIRSTNAME,e.LASTNAME,e.EMAIL,e.SALARY,
        e.IMG,et.PHONE,d.DEPARTMENT_NAME,p.POSITION_NAME
        from employee e
        LEFT JOIN employee_telephone et on e.ID = et.EMPLOYEE_ID
        LEFT JOIN position p on e.POSITION = p.POSITION_ID
        LEFT JOIN department d on p.DEPT_ID = d.DEPARTMENT_ID
        WHERE e.STATUS = 1 AND
        (   e.ID LIKE  ? OR
            e.FIRSTNAME LIKE  ? OR
            e.LASTNAME LIKE ?  OR
            e.EMAIL LIKE ?  OR
            e.salary LIKE ?  OR
            d.DEPARTMENT_NAME LIKE ?  OR
            p.POSITION_NAME LIKE ?  OR
            et.PHONE LIKE ? 
        )
            GROUP BY  e.ID
            ORDER BY e.ID ASC
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
        $sql = "
        select count(*) as cnt from (SELECT * FROM employee e
        left join employee_telephone et on e.ID = et.EMPLOYEE_ID
        LEFT JOIN position p on e.POSITION = p.POSITION_ID
        LEFT JOIN department d on p.DEPT_ID = d.DEPARTMENT_ID
        WHERE e.`STATUS` = 1
        AND
        (   
            e.ID LIKE  ? OR
            e.FIRSTNAME LIKE  ? OR
            e.LASTNAME LIKE ?  OR
            e.EMAIL LIKE ?  OR
            e.salary LIKE ?  OR
            d.DEPARTMENT_NAME LIKE ?  OR
            p.POSITION_NAME LIKE ?  OR
            et.PHONE LIKE ? 
        )
        GROUP BY  e.ID
        ORDER BY e.ID ASC) t";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
                '%' . $this->db->escape_like_str($search) . '%',
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
    public function fetch_province()
    {
        $sql = "SELECT * FROM province";
        return $this->db->query($sql)->result();
    }

    public function fetch_amphur($province_id)
    {
        $sql = "SELECT * from amphur where A_PROVINCE_ID = $province_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกเขต</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->AMPHUR_ID . '">' . $row->AMPHUR_NAME . '</option>';
        }
        return $output;
    }

    public function fetch_district($amphur_id)
    {
        $sql = "SELECT * from district where D_AMPHUR_ID = $amphur_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable >กรุณาเลือกแขวง</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
        }
        return $output;
    }


    public function fetch_postcode($district_id)
    {
        $sql = "SELECT POSTCODE from district where DISTRICT_ID = $district_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกรหัสไปรษณีย์</option>';
        foreach ($query as $row) {
            $output = '<option value="' . $row->POSTCODE . '">' . $row->POSTCODE . '</option>';
        }
        return $output;
    }

    public function  fetch_department()
    {
        $sql = "SELECT * FROM department";
        return $this->db->query($sql)->result();
    }

    public function fetch_position($department_id)
    {
        $sql = "SELECT * from position where DEPT_ID = '$department_id' ORDER BY POSITION_NAME ASC";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกตำแหน่ง</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->POSITION_ID . '">' . $row->POSITION_NAME . '</option>';
        }
        return $output;
    }

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

    public function ResetPassword($empID,$newPass){
        $sql ="UPDATE employee SET PASSWORD = '$newPass' WHERE ID = '$empID'";
        $this->db->query($sql);
    }
}
