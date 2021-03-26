<?php
defined('BASEPATH') or exit('No direct script access allowed');

class karaoke extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][11] != 1) {
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
        if ($this->input->get('karaokeActive') == 1) {
            $karaokeActive = 1;
        }
        if ($this->input->get('karaokeActive') == 0) {
            $karaokeActive = 0;
        } 
         else {
            $karaokeActive = '1,0';
        }
        $config['base_url'] = site_url('admin/karaoke/index');
        $config['total_rows'] = $this->seat_model->countAllkaraoke($search, $karaokeActive);
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
        $data['karaoke'] = $this->seat_model->karaoke($search, $karaokeActive, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'karaoke_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addKaraoke()
    {
        $data['zone'] = $this->crud_model->findSelectWhere('zone','ZONE_ID,ZONE_NAME','ZONE_STATUS','1');
        $data['page'] = 'karaoke_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertKaraoke()
    {
        $data['status'] = true;
        // $data['input'] = $this->input->post();
        $karaokeName = $this->input->post('karaokeName');
        $checkSeatName = $this->seat_model->checkSeatName($karaokeName);
        // $data['sa'] = $checkSeatName;
        if ($checkSeatName == 0) {
            $seatID = $this->genIdSeat();
            $karaokeAmount =  $this->input->post('karaokeAmount');
            $karaokeZone = $this->input->post('karaokeZone');
            $karaokePricePerHour = $this->input->post('karaokePricePerHour');
            $karaokeFlatRate = $this->input->post('karaokeFlatRate');
            $dataSeat = array(
                'SEAT_ID' => $seatID,
                'SEAT_NAME' => $karaokeName,
                'SEAT_AMOUNT' => $karaokeAmount,
                'SEAT_TYPE' => '2',
                'SEAT_ZONE' => $karaokeZone,
                'SEAT_STATUS' => '1',
                'SEAT_ACTIVE' => '1',
            );
            $this->crud_model->insert('seat', $dataSeat);
            $dataKaraoke = array(
                'KARAOKE_ID' => $seatID,
                'KARAOKE_PRICEPERHOUR' => $karaokePricePerHour,
                'KARAOKE_FLATRATE' => $karaokeFlatRate,
            );
            $this->crud_model->insert('karaoke', $dataKaraoke);
            $data['url'] = site_url('admin/karaoke');
            $data['message'] = 'เพิ่มข้อมูลโต๊ะเสร็จสิ้น';
        } else {
            $data['status'] = false;
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
            $data['karaokeNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
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

    public function editKaraoke()
    {
        $karaokeID = $this->input->get('karaokeID');
        $data['karaoke'] = $this->seat_model->editKaraoke($karaokeID);
        $data['zone'] = $this->crud_model->findSelectWhere('zone','ZONE_ID,ZONE_NAME','ZONE_STATUS','1');
        $data['page'] = 'karaoke_edit_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data); 
        // echo '</pre>';
    }

    public function updateKaraoke()
    {
        $data['input'] = $this->input->post();
        $data['status'] = true;
        $karaokeName = $this->input->post('karaokeName');
        $karaokeNameOld = $this->input->post('karaokeNameOld');
        if (strtolower($karaokeName) == strtolower($karaokeNameOld)) {
            $karaokeID =  $this->input->post('karaokeID');
            $karaokeAmount =  $this->input->post('karaokeAmount');
            $karaokeZone =  $this->input->post('karaokeZone');
            $karaokePricePerHour =  $this->input->post('karaokePricePerHour');
            $karaokeFlatRate =  $this->input->post('karaokeFlatRate');
            $karaokeActive = $this->input->post('karaokeActive');
            $karaokeQueue = $this->input->post('karaokeQueue');
            $dataSeat = array(
                'SEAT_AMOUNT' => $karaokeAmount,
                'SEAT_ZONE' => $karaokeZone,
                'SEAT_ACTIVE' => $karaokeActive,
                'SEAT_QUEUE' => $karaokeQueue,
            );
            $this->crud_model->update('seat', $dataSeat, 'SEAT_ID', $karaokeID);
            $dataKaraoke = array(
                'KARAOKE_PRICEPERHOUR' => $karaokePricePerHour,
                'KARAOKE_FLATRATE' => $karaokeFlatRate,
            );
            $this->crud_model->update('karaoke', $dataKaraoke, 'KARAOKE_ID', $karaokeID);
            $data['url'] = site_url('admin/karaoke');
            $data['message'] = 'แก้ไขข้อมูลห้องคาราโอเกะเสร็จสิ้น';
        } else {
            $checkSeatName = $this->seat_model->checkSeatName($karaokeName);
            // $data['sa'] = $cheakSeatName;
            if ($checkSeatName == 0) {
                $karaokeID =  $this->input->post('karaokeID');
                $karaokeAmount =  $this->input->post('karaokeAmount');
                $karaokeZone =  $this->input->post('karaokeZone');
                $karaokePricePerHour =  $this->input->post('karaokePricePerHour');
                $karaokeFlatRate =  $this->input->post('karaokeFlatRate');
                $karaokeActive = $this->input->post('karaokeActive');
                $karaokeQueue = $this->input->post('karaokeQueue');
                $dataSeat = array(
                    'SEAT_NAME' => $karaokeName,
                    'SEAT_AMOUNT' => $karaokeAmount,
                    'SEAT_ZONE' => $karaokeZone,
                    'SEAT_ACTIVE' => $karaokeActive,
                    'SEAT_QUEUE' => $karaokeQueue,
                );
                $this->crud_model->update('seat', $dataSeat, 'SEAT_ID', $karaokeID);
                $dataKaraoke = array(
                    'KARAOKE_PRICEPERHOUR' => $karaokePricePerHour,
                    'KARAOKE_FLATRATE' => $karaokeFlatRate,
                );
                $this->crud_model->update('karaoke', $dataKaraoke, 'KARAOKE_ID', $karaokeID);
                $data['url'] = site_url('admin/karaoke');
                $data['message'] = 'แก้ไขข้อมูลห้องคาราโอเกะเสร็จสิ้น';
            } else {
                $data['status'] = false;
                $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
                $data['karaokeNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
            }
        }
        echo json_encode($data);
    }

    public function deleteSeat()
    {
        $seatID = $this->input->post('karaokeID');
        $this->crud_model->updateStatus('seat', 'SEAT_STATUS', '0', 'SEAT_ID', $seatID);
    }
}
