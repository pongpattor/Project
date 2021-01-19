<?php
defined('BASEPATH') or exit('No direct script access allowed');

class department extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][1] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
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
        $data['department'] = $this->department_model->Department($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'department_view';
        $this->load->view('admin/main_view', $data);
    }

    public function genIdDepartment()
    {
        $max = $this->department_model->maxidDepartment();
        if ($max == '') {
            $id = 'DEP001';
            return $id;
        } else {
            $id = substr($max, 3);
            $id += 1;
            while (strlen($id) < 3) {
                $id = '0' . $id;
            }
            $id = 'DEP' . $id;
            return $id;
        }
    }

    public function addDepartment()
    {
        $data['page'] = 'department_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function checkDepartmentNameInsert()
    {
        $departmentName = $this->input->post("departmentName");
        $checkName = $this->department_model->checkName($departmentName);
        if ($checkName != 0) {
            //ซ้ำ
            echo 1;
        } else {
            //ไม่ซ้ำ
            echo 0;
        }
    }

    public function checkDepartmentNameUpdate()
    {
        $departmentName = $this->input->post("departmentName");
        $oldDepartmentName = $this->input->post("oldDepartmentName");
        if ($departmentName == $oldDepartmentName) {
            echo 0;
        } else {
            $checkName = $this->department_model->checkName($departmentName);
            if ($checkName != 0) {
                //ซ้ำ
                echo 1;
            } else {
                //ไม่ซ้ำ
                echo 0;
            }
        }
    }

    

    public function insertDepartment()
    {
        $dept = array(
            'DEPARTMENT_ID' => $this->genIdDepartment(),
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->insert('department', $dept);
        echo '<script>alert("เพิ่มข้อมูลแผนกสำเร็จ")</script>';

        return redirect(site_url('admin/department/'));
    }


    public function editDepartment()
    {
        $deptID = $this->input->get('departmentID');
        $data['oldDept'] = $this->department_model->editDept($deptID);
        if ($data['oldDept'] == null) {
            echo '<script>';
            echo 'alert("ไม่มีข้อมูลแผนกรหัส '.$deptID.'");';
            echo 'location.href= "' . site_url('admin/department/') . '"';
            echo '</script>';
        } else {
            $data['page'] = 'department_edit_view';
            $this->load->view('admin/main_view', $data);
        }
    }
    public function updateDepartment()
    {
        $DEPARTMENT_ID = $this->input->post('DEPARTMENT_ID');
        $department_detail = array(
            'DEPARTMENT_ID' => $DEPARTMENT_ID,
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->update('department', $department_detail, 'DEPARTMENT_ID', $DEPARTMENT_ID);
        echo '<script>alert("แก้ไขข้อมูลแผนกสำเร็จ")</script>';

        return redirect(site_url('admin/department/'));
    }

    public function deleteDepartment()
    {
        $dept = $this->input->post('deptID');
        $this->crud_model->delete('department', 'DEPARTMENT_ID', $dept);
    }
    // Department End

}
