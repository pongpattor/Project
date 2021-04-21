<?php
defined('BASEPATH') or exit('No direct script access allowed');

class position_model extends CI_Model
{
    //Position Start
    public function position($search = '', $limit, $offset)
    {
        $sql = "SELECT position.POSITION_ID,position.POSITION_NAME,department.DEPARTMENT_NAME FROM position
      LEFT JOIN department ON position.POSITION_DEPARTMENT = department.DEPARTMENT_ID 
      where POSITION_STATUS = '1'
      AND
      (
          position.POSITION_ID LIKE  ? OR
          position.POSITION_NAME LIKE ? OR
          department.DEPARTMENT_NAME LIKE ? 
      )
      LIMIT $offset,$limit
      ";

        $query = $this->db->query(
            $sql,
            array(
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

    public function countAllPosition($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM position
      LEFT JOIN department ON position.POSITION_DEPARTMENT = department.DEPARTMENT_ID 
      where POSITION_STATUS = '1'
      AND
      (
          position.POSITION_ID LIKE  ? OR
          position.POSITION_NAME LIKE ? OR
          department.DEPARTMENT_NAME LIKE ? 
      )
      ";

        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($search) . '%',
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

    public function checkPositionName($positionName, $positionDepartment)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM position
                JOIN department ON position.POSITION_DEPARTMENT = department.DEPARTMENT_ID
                WHERE position.POSITION_NAME = '$positionName'
                AND department.DEPARTMENT_ID = '$positionDepartment'
                AND position.POSITION_STATUS = '1'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function maxIdPosition()
    {
        $sql = "SELECT MAX(POSITION_ID) as MID FROM position";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }


    public function updatePosition($positionID, $positionName, $deptID, $permission)
    {
        $sql = "UPDATE position SET POSITION_NAME = ? ,DEPT_ID = ? ,PERMISSION = ? WHERE POSITION_ID = '$positionID' ";
        $this->db->query($sql, array(
            $this->db->escape_like_str($positionName),
            $this->db->escape_like_str($deptID),
            $this->db->escape_like_str($permission)
        ));
        return true;
    }

    //Position End
}
