<?php
defined('BASEPATH') or exit('No direct script access allowed');

class position extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][4] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('position_model');
        $this->load->library('pagination');
    }


    // Position Start
    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/position/index');
        $config['total_rows'] = $this->position_model->countAllPosition($search);
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
        $data['dept_pos'] = $this->position_model->position($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'position_view';
        $this->load->view('admin/main_view', $data);
        // echo $config['total_rows'];
    }

    public function addPosition()
    {
        $data['page'] = 'position_add_view';
        $data['department'] = $this->crud_model->findWhere('department', 'DEPARTMENT_STATUS', '1');
        $this->load->view('admin/main_view', $data);
    }

    public function genIdPosition()
    {
        $maxId = $this->crud_model->maxID('position', 'POSITION_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'POS' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 3, 4);
            if ($ymID != $ym) {
                return 'POS' . $ym . '0001';
            } else {
                $id = substr($maxId, 7);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'POS' . $ymID . $id;
                return $id;
            }
        }
    }

    public function insertPosition()
    {
        $data['status'] = true;
        $positionName = $this->input->post('positionName');
        $positionDepartment = $this->input->post('positionDepartment');
        $positionPermission = $this->input->post('positionPermission');
        $checkPositionName = $this->position_model->checkPositionName($positionName, $positionDepartment);
        if ($checkPositionName == 0) {
            $dataPosition = array(
                'POSITION_ID' => $this->genIdPosition(),
                'POSITION_NAME' => $positionName,
                'POSITION_DEPARTMENT' => $positionDepartment,
                'POSITION_PERMISSION' =>  $positionPermission,
            );
            $this->crud_model->insert('position', $dataPosition);
            $data['message'] = "เพิ่มข้อมูลตำแหน่งเสร็จสิ้น";
            $data['url'] = site_url('admin/position');
        } else {
            $data['status'] = false;
            $data['positionNameError'] = "ชื่อตำแหน่งนี้ได้ถูกใช้ไปแล้ว";
            $data['message'] = "กรุณากรอกข้อมูลให้ถูกต้อง";
        }

        echo json_encode($data);
    }

    public function editPosition()
    {
        $positpositionID = $this->input->get('positionID');
        $data['position'] = $this->crud_model->findwhere('position', 'POSITION_ID', $positpositionID);
        $data['department'] = $this->crud_model->findWhere('department', 'DEPARTMENT_STATUS', '1');
        if ($data['position'][0]->POSITION_PERMISSION == "") {
            $data['permission'] = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        } else {
            $data['permission'] = explode(',', $data['position']['0']->POSITION_PERMISSION);
        }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $data['page'] = 'position_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updatePosition()
    {
        $data['status'] = true;
        // $data['input'] = $this->input->post();
        $positionName = $this->input->post('positionName');
        $positionDepartment = $this->input->post('positionDepartment');
        $positionNameOld = $this->input->post('positionNameOld');
        $positionDepartmentOld = $this->input->post('positionDepartmentOld');
        if (strtolower($positionName) == strtolower($positionNameOld) && $positionDepartment == $positionDepartmentOld) {
            $positionID = $this->input->post('positionID');
            $dataPosition = array(
                'POSITION_PERMISSION' => $this->input->post('positionPermission'),
            );
            $this->crud_model->update('position', $dataPosition, 'POSITION_ID', $positionID);
            $data['message'] = "แก้ไขข้อมูลตำแหน่งเสร็จสิ้น";
            $data['url'] = site_url('admin/position');
        } else {
            $checkPositionName =  $this->position_model->checkPositionName($positionName, $positionDepartment);
            if ($checkPositionName == 0) {
                $positionID = $this->input->post('positionID');
                $dataPosition = array(
                    'POSITION_NAME' => $positionName,
                    'POSITION_DEPARTMENT' => $positionDepartment,
                    'POSITION_PERMISSION' => $this->input->post('positionPermission'),
                );
                $this->crud_model->update('position', $dataPosition, 'POSITION_ID', $positionID);
                $data['message'] = "แก้ไขข้อมูลตำแหน่งเสร็จสิ้น";
                $data['url'] = site_url('admin/position');
            } else {
                $data['status'] = false;
                $data['positionNameError'] = 'ชื่อตำแหน่งนี้ได้ถูกใช้ไปแล้ว';
                $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
            }
        }
        echo json_encode($data);
    }

    public function deletePosition()
    {
        $data['status'] = true;
        $positionID = $this->input->post('positionID');

        $employeeNum = $this->crud_model->count2Where('employee', 'EMPLOYEE_POSITION', $positionID, 'EMPLOYEE_STATUS', '1');
        if ($employeeNum == 0) {
            $dataPosition = array(
                'POSITION_STATUS' => '0',
            );
            $this->crud_model->update('position', $dataPosition, 'POSITION_ID', $positionID);
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }
}
