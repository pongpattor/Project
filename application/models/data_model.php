<?php
defined('BASEPATH') or exit('No direct script access allowed');

class data_model extends CI_Model
{
    public function fetchAmphur($provinceID)
    {
        $sql = "SELECT * from amphur where A_PROVINCE_ID = $provinceID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected >กรุณาเลือกเขต</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->AMPHUR_ID . '">' . $row->AMPHUR_NAME . '</option>';
        }
        return $output;
    }

    public function fetchDistrict($amphurID)
    {
        $sql = "SELECT * from district where D_AMPHUR_ID = $amphurID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected  >กรุณาเลือกแขวง</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
        }
        return $output;
    }

    public function fetchPostcode($districtID)
    {
        $sql = "SELECT POSTCODE from district where DISTRICT_ID = $districtID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected >กรุณาเลือกรหัสไปรษณีย์</option>';
        foreach ($query as $row) {
            $output = '<option value="' . $row->POSTCODE . '">' . $row->POSTCODE . '</option>';
        }
        return $output;
    }
}
