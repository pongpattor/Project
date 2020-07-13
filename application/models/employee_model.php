<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee_model extends CI_Model{

    function fetchEmp(){
        $sql = "SELECT * FROM employee INNER JOIN position on POSITION = POSITION_ID  WHERE STATUS = '1' ORDER BY ID ASC";
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
    function fetchEmpForDepartment(){
        $sql = "SELECT ID ,FIRSTNAME,LASTNAME FROM employee";
        return $this->db->query($sql)->result();
    }

}
