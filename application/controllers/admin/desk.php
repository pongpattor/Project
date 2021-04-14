<?php
defined('BASEPATH') or exit('No direct script access allowed');

class desk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][10] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        $this->load->model('crud_model');
        $this->load->model('seat_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        if ($this->input->get('deskEnable') == '1') {
            $deskEnable =  1;
        } else if ($this->input->get('deskEnable') == '0') {
            $deskEnable = 0;
        } else {
            $deskEnable = '0,1';
        }
        $config['base_url'] = site_url('admin/desk/index');
        $config['total_rows'] = $this->seat_model->countAllDesk($search, $deskEnable);
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
        $data['desk'] = $this->seat_model->desk($search, $deskEnable, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'desk_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDesk()
    {
        $data['zone'] = $this->crud_model->findSelectWhere('zone', 'ZONE_ID,ZONE_NAME', 'ZONE_STATUS', '1');
        $data['page'] = 'desk_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertDesk()
    {
        $data['status'] = true;
        $deskName = $this->input->post('deskName');
        $checkSeatName = $this->seat_model->checkSeatName($deskName);
        // $data['sa'] = $cheakSeatName;
        if ($checkSeatName == 0) {
            $dataSeat = array(
                'SEAT_ID' => $this->genIdSeat(),
                'SEAT_NAME' => $deskName,
                'SEAT_AMOUNT' => $this->input->post('deskAmount'),
                'SEAT_TYPE' => '1',
                'SEAT_ZONE' => $this->input->post('deskZone'),
                'SEAT_QUEUE' => $this->input->post('deskQueue'),
                'SEAT_STATUS' => '1',
                'SEAT_ENABLE' => '1',
                'SEAT_ACTIVE' => '0',
            );
            $this->crud_model->insert('seat', $dataSeat);
            $data['url'] = site_url('admin/desk');
            $data['message'] = 'เพิ่มข้อมูลโต๊ะเสร็จสิ้น';
        } else {
            $data['status'] = false;
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
            $data['deskNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
        }
        echo json_encode($data);
    }

    public function genIdSeat()
    {
        $maxId = $this->crud_model->maxID('seat', 'SEAT_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'S' . $ym . '001';
            return $id;
        } else {
            $ymID = substr($maxId, 1, 4);
            if ($ymID != $ym) {
                return 'S' . $ym . '001';
            } else {
                $id = substr($maxId, 5);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                $id = 'S' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editDesk()
    {
        $deskID = $this->input->get('deskID');
        $data['desk'] = $this->seat_model->editDesk($deskID);
        $data['zone'] = $this->crud_model->findSelectWhere('zone', 'ZONE_ID,ZONE_NAME', 'ZONE_STATUS', '1');
        $data['page'] = 'desk_edit_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data); 
        // echo '</pre>';
    }

    public function updateDesk()
    {
        // $data['input'] = $this->input->post();
        $data['status'] = true;
        $deskName = $this->input->post('deskName');
        $deskNameOld = $this->input->post('deskNameOld');
        if (strtolower($deskName) == strtolower($deskNameOld)) {
            $deskID =  $this->input->post('deskID');
            $deskAmount =  $this->input->post('deskAmount');
            $deskZone =  $this->input->post('deskZone');
            $deskEnable =  $this->input->post('deskEnable');
            $deskQueue = $this->input->post('deskQueue');
            $dataSeat = array(
                'SEAT_NAME' => $deskName,
                'SEAT_AMOUNT' => $deskAmount,
                'SEAT_ZONE' => $deskZone,
                'SEAT_ENABLE' => $deskEnable,
                'SEAT_QUEUE' => $deskQueue,

            );
            $this->crud_model->update('seat', $dataSeat, 'SEAT_ID', $deskID);
            $data['url'] = site_url('admin/desk');
            $data['message'] = 'แก้ไขข้อมูลโต๊ะเสร็จสิ้น';
        } else {
            $checkSeatName = $this->seat_model->checkSeatName($deskName);
            // $data['sa'] = $cheakSeatName;
            if ($checkSeatName == 0) {
                $deskID =  $this->input->post('deskID');
                $deskAmount =  $this->input->post('deskAmount');
                $deskZone =  $this->input->post('deskZone');
                $deskEnable =  $this->input->post('deskEnable');
                $deskQueue = $this->input->post('deskQueue');
                $dataSeat = array(
                    'SEAT_NAME' => $deskName,
                    'SEAT_AMOUNT' => $deskAmount,
                    'SEAT_ZONE' =>  $deskZone,
                    'SEAT_ENABLE' => $deskEnable,
                    'SEAT_QUEUE' => $deskQueue,
                );
                $this->crud_model->update('seat', $dataSeat, 'SEAT_ID', $deskID);
                $data['url'] = site_url('admin/desk');
                $data['message'] = 'แก้ไขข้อมูลโต๊ะเสร็จสิ้น';
            } else {
                $data['status'] = false;
                $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
                $data['deskNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
            }
        }
        echo json_encode($data);
    }

    public function deleteSeat()
    {
        $seatID = $this->input->post('deskID');
        $this->crud_model->updateStatus('seat', 'SEAT_STATUS', '0', 'SEAT_ID', $seatID);
    }
}
