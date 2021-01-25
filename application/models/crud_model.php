<?php
defined('BASEPATH') or exit('No direct script access allowed');

class crud_model extends CI_Model
{


    public function insert($table, $data = array())
    {
        $this->db->insert($table, $data);
    }

    public function findall($table)
    {
        $sql = "SELECT * FROM $table";
        return $this->db->query($sql)->result();
    }

    public function find($table, $select)
    {
        $sql = "SELECT $select FROM $table";
        return $this->db->query($sql)->result();
    }

    public function findwhere($table, $where, $data)
    {
        $sql = "SELECT * FROM $table where $where = '$data'";
        return  $this->db->query($sql)->result();
    }
    public function findSelectWhere($table, $select, $where, $data)
    {
        $sql = "SELECT $select FROM $table WHERE $where = '$data'";
        return $this->db->query($sql)->result();
    }

    public function findIn($table, $select, $where, $data)
    {
        $sql = "SELECT $select FROM $table
                WHERE $where in ($data)";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function countAll($table)
    {
        $sql = "SELECT COUNT(*) as cnt FROM $table";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function countWhere($table, $where, $data)
    {
        $sql = "SELECT COUNT(*) as cnt FROM $table
                WHERE $where = ?";
        $query = $this->db->query($sql, array(
            $this->db->escape_like_str($data),
        ));
        // echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }


    public function count2Where($table, $where1, $whereData1, $where2, $whereData2)
    {
        $sql = " SELECT COUNT(*) AS cnt FROM $table
                WHERE $where1 = '$whereData1'
                AND $where2 = '$whereData2'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function update($table, $data = array(), $where, $whereData)
    {
        $this->db->where($where, $whereData);
        $this->db->update($table, $data);
    }


    public function UpdateStatus($table, $set, $setData, $where, $whereData)
    {
        $sql = "UPDATE $table SET $set = '$setData' WHERE $where = '$whereData' ";
        $this->db->query($sql);
    }

    public function delete($table, $where, $data)
    {
        $sql = "DELETE FROM $table WHERE $where = '$data'";
        $this->db->query($sql);
    }

    public function maxID($table, $select)
    {
        $sql = "SELECT MAX($select) as maxID FROM $table";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            return $row->maxID;
        }
    }


}
