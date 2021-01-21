<?php
defined('BASEPATH') or exit('No direct script access allowed');

class department extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if (empty($_SESSION['login'])) {
        //     return redirect(site_url('admin/login'));
        // }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('department_model');
        $this->load->library('pagination');
    }

    // Department Start
    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/department/index');
        $config['total_rows'] = $this->department_model->countAllDepartment($search);
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
        $data['department'] = $this->department_model->department($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'department_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDepartment()
    {
        $data['page'] = 'department_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertDepartment()
    {
        $data['status'] = true;
        $departmentName = $this->input->post("departmentName");
        $countDepartmentName = $this->crud_model->countWhere('department', 'DEPARTMENT_NAME', $departmentName);
        if ($countDepartmentName == 0) {
            $dataDepartment = array(
                'DEPARTMENT_ID' => $this->genIdDepartment(),
                'DEPARTMENT_NAME' => $departmentName,
            );
            $this->crud_model->insert('department', $dataDepartment);
            $data['message'] = 'เพิ่มข้อมูลแผนกเสร็จสิ้น';
            $data['url'] = site_url('admin/department/');
        } else {
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
            $data['departmentNameError'] = 'ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว';
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function genIdDepartment()
    {
        $maxID = $this->department_model->maxDepartmentID();
        $y = date('y');
        if ($maxID == '') {
            $id = 'DEP' . $y . '0001';
            return $id;
        } else {
            $year = substr($maxID, 3, 2);
            if ($y != $year) {
                return 'DEP' . $y . '0001';
            } 
            else{
                $id = substr($maxID, 5);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                return 'DEP' . $year . $id;
            }
        }
    }

    public function editDepartment()
    {
        $departmentID = $this->input->get('departmentID');
        $data['department'] = $this->crud_model->findWhere('department','DEPARTMENT_ID',$departmentID);
        $data['page'] = 'department_edit_view';
        $this->load->view('admin/main_view', $data);
    }
    
    public function updateDepartment()
    {
        $departmentName = $this->input->post('departmentName');
        $departmentNameOld = $this->input->post('departmentNameOld');
        $data['status'] = true;
        if (strtolower($departmentName) == strtolower($departmentNameOld)) {
            $data['url'] = site_url('admin/department');
            $data['message'] = 'แก้ไขข้อมูลเสร็จสิ้น';
        } else {
            $countDepartmentName = $this->crud_model->countWhere('department', 'DEPARTMENT_NAME', $departmentName);
            if ($countDepartmentName == 0) {
                $departmentID = $this->input->post('departmentID');
                $dataDepartment = array(
                    'DEPARTMENT_ID' => $departmentID,
                    'DEPARTMENT_NAME' => $departmentName,
                );
                $this->crud_model->update('department', $dataDepartment, 'DEPARTMENT_ID', $departmentID);
                $data['message'] = 'แก้ไขข้อมูลเสร็จสิ้น';
                $data['url'] = site_url('admin/department/');
            } else {
                $data['status'] = false;
                $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
                $data['departmentNameError'] = 'ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว';
            }
        }
        echo json_encode($data);
    }

    public function deleteDepartment()
    {
        $departmentID = $this->input->post('departmentID');
        $this->crud_model->delete('department', 'DEPARTMENT_ID', $departmentID);
    }
    // Department End

}
