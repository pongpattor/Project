<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model{

    function fetchEmp(){
        $sql = "SELECT * FROM employee lEFT JOIN position on POSITION = POSITION_ID  WHERE STATUS = '1' ORDER BY ID ASC";
        return $this->db->query($sql)->result();
      }

    function editEmp($id){
        $sql = "SELECT * FROM employee WHERE ID = $id";
        return $this->db->query($sql)->result();
    }

    function delEmp($ID,$delete_at){
        $sql = "UPDATE employee SET STATUS = '0' , DELETE_AT = '$delete_at' WHERE ID = '$ID'";
         return $this->db->query($sql);
    }

    function maxIdEmp(){
        $sql ="SELECT MAX(ID)as'MID'  FROM employee ";
        $query = $this->db->query($sql)->result();
        foreach($query as $row){
            return $row->MID;
        }
    }
    function fetctDeptHead(){
        $sql = "SELECT DEPARTMENT_ID,DEPARTMENT_NAME,DEPARTMENT_HEAD,FIRSTNAME,LASTNAME,ID FROM department LEFT JOIN employee ON DEPARTMENT_HEAD = ID";
        return $this->db->query($sql)->result();
    }

    function editDept($id){
        $sql = "SELECT * FROM department 
        WHERE DEPARTMENT_ID = $id";
        return $this->db->query($sql)->result();
    }

    function position(){
        $sql = 'SELECT * FROM position inner join department on DEPT_ID = DEPARTMENT_ID ORDER BY DEPARTMENT_NAME,POSITION_NAME';
        return $this->db->query($sql)->result();
    }
    
    function editPos($id){
        $sql = "SELECT * FROM position 
        WHERE POSITION_ID = $id";
        return $this->db->query($sql)->result();
    }

    function rowEmployee(){
        $sql = "SELECT COUNT(*) FROM employee";
        return $this->db->query($sql)->result();
    }

}
