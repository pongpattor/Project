<?php
defined('BASEPATH') or exit('No direct script access allowed');

class data_model extends CI_Model
{

    public function allServed()
    {
        $sql = "SELECT
                    COUNT(*) as cnt
                FROM
                    service
                    JOIN servicedetail ON service.SERVICE_ID = servicedetail.DTSER_ID
                    LEFT JOIN servicedetailfd ON ( servicedetail.DTSER_ID = servicedetailfd.FDDTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailfd.FDDTSER_NO )
                    LEFT JOIN servicedetailproset ON ( servicedetail.DTSER_ID = servicedetailproset.PRODTSER_SERVICEID AND servicedetail.DTSER_NO = servicedetailproset.PRODTSER_NO )
                    LEFT JOIN servicedetailprosetdetail ON ( servicedetailproset.PRODTSER_SERVICEID = servicedetailprosetdetail.DPRODTSER_SERVICEID AND servicedetailproset.PRODTSER_NO = servicedetailprosetdetail.DPRODTSER_NO )
                    LEFT JOIN promotionset ON servicedetailproset.PRODTSER_PROSETID = promotionset.PROMOTIONSET_ID
                WHERE (servicedetail.DTSER_STATUS ='2' OR servicedetailprosetdetail.DPRODTSER_STATUS ='2')
    ";
    $query = $this->db->query($sql);
     foreach ($query->result() as $row) {
        return $row->cnt;
    }
    }

    public function fetchAmphur($provinceID)
    {
        $sql = "SELECT * from amphur where A_PROVINCE_ID = $provinceID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disabled>กรุณาเลือกเขต</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->AMPHUR_ID . '">' . $row->AMPHUR_NAME . '</option>';
        }
        return $output;
    }

    public function fetchDistrict($amphurID)
    {
        $sql = "SELECT * from district where D_AMPHUR_ID = $amphurID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disabled >กรุณาเลือกแขวง</option>';

        foreach ($query as $row) {
            $output .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
        }
        return $output;
    }

    public function fetchPostcode($districtID)
    {
        $sql = "SELECT POSTCODE from district where DISTRICT_ID = $districtID";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disabled >กรุณาเลือกรหัสไปรษณีย์</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->POSTCODE . '">' . $row->POSTCODE . '</option>';
        }
        return $output;
    }

    public function fetchPosition($departmentID)
    {
        $sql = "SELECT POSITION_ID,POSITION_NAME from position where POSITION_DEPARTMENT = '$departmentID'";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disabled >กรุณาเลือกตำแหน่ง</option>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->POSITION_ID . '">' . $row->POSITION_NAME . '</option>';
        }
        return $output;
    }

    public function fetchTypeProduct($typeProductGroup)
    {
        $sql = "SELECT TYPEPRODUCT_ID,TYPEPRODUCT_NAME from typeproduct where TYPEPRODUCT_GROUP = '$typeProductGroup' AND TYPEPRODUCT_STATUS = '1' ";
        $query =  $this->db->query($sql)->result();
        $output = '<option value="" selected disable>กรุณาเลือกประเภทสินค้า</option>';
        //  echo '<pre>';
        // print_r($this->db->last_query($query));
        // echo '</pre>';
        foreach ($query as $row) {
            $output .= '<option value="' . $row->TYPEPRODUCT_ID . '">' . $row->TYPEPRODUCT_NAME . '</option>';
        }
        return $output;
    }
}
