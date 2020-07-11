<?php
defined('BASEPATH') or exit('No direct script access allowed');

class base_data_model extends CI_Model
{

    function fetch_province()
    {
        $sql = "SELECT * FROM province";
        return $this->db->query($sql)->result();
    }

    function fetch_amphur($province_id)
    {
        $sql = "SELECT * from amphur where PROVINCE_ID = $province_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกเขต</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->AMPHUR_ID . '">' . $row->AMPHUR_NAME . '</option>';
        }
        return $output;
    }

    function fetch_district($amphur_id)
    {
        $sql = "SELECT * from district where AMPHUR_ID = $amphur_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable >กรุณาเลือกแขวง</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
        }
        return $output;
    }

    function fetch_postcode($district_id)
    {
        $sql = "SELECT POSTCODE from district where DISTRICT_ID = $district_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกรหัสไปรษณีย์</option>';
        foreach ($query as $row) {
            $output = '<option value="' . $row->POSTCODE . '">' . $row->POSTCODE . '</option>';
        }
        return $output;
    }

    function fetch_position($department_id)
    {
        $sql = "SELECT * from position where DEPT_ID = $department_id";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกตำแหน่ง</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->POSITION_ID . '">' . $row->POSITION_NAME . '</option>';
        }
        return $output;

    }

}
