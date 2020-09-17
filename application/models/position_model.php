<?php
defined('BASEPATH') or exit('No direct script access allowed');

class position_model extends CI_Model
{
    //Position Start
    function position($search = '', $limit, $offset)
    {
        $sql = "SELECT position.POSITION_ID,position.POSITION_NAME,department.DEPARTMENT_NAME FROM position
      LEFT JOIN department ON position.DEPT_ID = department.DEPARTMENT_ID 
      where
      (
          position.POSITION_ID LIKE  ? OR
          position.POSITION_NAME LIKE ? OR
          department.DEPARTMENT_NAME LIKE ? 
      )
      ORDER BY department.DEPARTMENT_ID ASC, position.POSITION_ID ASC
      LIMIT $offset,$limit
      ";

        $query = $this->db->query(
            $sql,
            array(
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

    function countAllPosition($search = '')
    {
        $sql = "SELECT COUNT(*) as cnt FROM position
      LEFT JOIN department ON position.DEPT_ID = department.DEPARTMENT_ID 
      where
      (
          position.POSITION_ID LIKE  ? OR
          position.POSITION_NAME LIKE ? OR
          department.DEPARTMENT_NAME LIKE ? 
      )
      ";

        $query = $this->db->query(
            $sql,
            array(
                '%' . $this->db->escape_like_str($search) . '%',
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

    function maxIdPosition()
    {
        $sql = "SELECT MAX(POSITION_ID) as MID FROM position";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->MID;
        }
    }


    function editPos($id)
    {
        $sql = "SELECT * FROM position 
      WHERE POSITION_ID = $id";
        return $this->db->query($sql)->result();
    }

    function checkName($departmentId, $positionName)
    {
        $sql = "SELECT COUNT(*) as cnt FROM department
                INNER JOIN position 
                ON department.DEPARTMENT_ID = position.DEPT_ID
                WHERE department.DEPARTMENT_ID = ?
                and position.POSITION_NAME LIKE ?";
        $query = $this->db->query(
            $sql,
            array(
                $this->db->escape_like_str($departmentId),
                $this->db->escape_like_str($positionName)
            )
        );
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }


    //Position End
}