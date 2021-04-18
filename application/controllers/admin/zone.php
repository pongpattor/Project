<?php
defined('BASEPATH') or exit('No direct script access allowed');

class zone extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } 
        else if ($_SESSION['employeePermission'][11] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        $this->load->model('crud_model');
        $this->load->model('zone_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/zone/index');
        $config['total_rows'] = $this->zone_model->countAllZone($search);
        $config['per_page'] = 5;
        $config['reuse_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item ">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" >';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $limit = $config['per_page'];
        $offset = $this->uri->segment(4, 0);
        $this->pagination->initialize($config);
        $data['total'] = $config['total_rows'];
        $data['zone'] = $this->zone_model->zone($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'zone_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addZone()
    {
        $data['page'] = 'zone_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertZone()
    {
        $data['status'] = true;
        $zoneName = $this->input->post('zoneName');
        $checkZoneName = $this->crud_model->countWhere('zone', 'ZONE_NAME', $zoneName);
        if ($checkZoneName == 0) {
            $dataZone = array(
                'ZONE_ID' => $this->genIdZone(),
                'ZONE_NAME' => $zoneName,
            );
            $this->crud_model->insert('zone', $dataZone);
            $data['url'] = site_url('admin/zone');
            $data['message'] = 'เพิ่มข้อมูลโซนเสร็จสิ้น';
        } else {
            $data['status'] = false;
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
            $data['zoneNameError'] = 'ชื่อโซนนี้ได้ถูกใช้ไปแล้ว';
        }
        echo json_encode($data);
    }

    public function genIdZone()
    {
        $maxID = $this->crud_model->maxID('zone', 'ZONE_ID');
        $y = date('y');
        if ($maxID == '') {
            $id = 'Z' . $y . '001';
            return $id;
        } else {
            $year = substr($maxID, 1, 2);
            if ($y != $year) {
                return 'Z' . $y . '001';
            } else {
                $id = substr($maxID, 3);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                return 'Z' . $year . $id;
            }
        }
    }

    public function editZone()
    {
        $zoneID = $this->input->get('zoneID');
        $data['zone'] = $this->crud_model->findWhere('zone', 'ZONE_ID', $zoneID);
        $data['page'] = 'zone_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateZone()
    {
        $data['status'] = true;
        $zoneName = $this->input->post('zoneName');
        $zoneNameOld = $this->input->post('zoneNameOld');

        if (strtolower($zoneName) == strtolower($zoneNameOld)) {
            $data['url'] = site_url('admin/zone');
            $data['message'] = 'แก้ไขข้อมูลโซนเสร็จสิ้น';
        } else {
            $checkZoneName = $this->crud_model->countWhere('zone', 'ZONE_NAME', $zoneName);
            if ($checkZoneName == 0) {
                $zoneID = $this->input->post('zoneID');
                $dataZone = array(
                    'ZONE_ID' => $zoneID,
                    'ZONE_NAME' => $zoneName,
                );
                $this->crud_model->update('zone',$dataZone,'ZONE_ID',$zoneID);
                $data['url'] = site_url('admin/zone');
                $data['message'] = 'แก้ไขข้อมูลโซนเสร็จสิ้น';
            } else {
                $data['status'] = false;
                $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
                $data['zoneNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
            }
        }
        $data['input'] = $this->input->post();

        echo json_encode($data);
    }

    public function deleteZone()
    {
        $data['status'] = true;
        $zoneID = $this->input->post('zoneID');
        $seatNum = $this->crud_model->count2Where('seat','SEAT_ZONE',$zoneID,'SEAT_STATUS','1');
        if ($seatNum == 0) {
            $dataZone = array(
                'ZONE_STATUS' => '0',
            );
            $this->crud_model->update('zone', $dataZone, 'ZONE_ID', $zoneID);
        }
        else{
            $data['status'] = false;
        }
        echo json_encode($data);
    }
}
