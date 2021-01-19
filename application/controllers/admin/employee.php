<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][0] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('employee_model');
        $this->load->library('pagination');
    }

    // Employee Start
    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/employee/index');
        $config['total_rows'] = $this->employee_model->countAllEmployee($search);
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
        $data['employee'] = $this->employee_model->employee($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'employee_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addEmployee()
    {
        $this->load->model('position_model');

        $data['province'] = $this->crud_model->findall('province');
        $data['department'] = $this->position_model->showDepartment();
        $data['page'] = 'employee_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function idcard()
    {
        //ตรวจรหัสบัตรว่าใช่เลขบัตรจริงไหม
        $idcard = $this->input->post('idcard');
        $rev = strrev($idcard); // reverse string ขั้นที่ 0 เตรียมตัว
        $total = 0;
        for ($i = 1; $i < 13; $i++) // ขั้นตอนที่ 1 - เอาเลข 12 หลักมา เขียนแยกหลักกันก่อน
        {
            $mul = $i + 1;
            $count = $rev[$i] * $mul; // ขั้นตอนที่ 2 - เอาเลข 12 หลักนั้นมา คูณเข้ากับเลขประจำหลักของมัน
            $total = $total + $count; // ขั้นตอนที่ 3 - เอาผลคูณทั้ง 12 ตัวมา บวกกันทั้งหมด
        }
        $mod = $total % 11; //ขั้นตอนที่ 4 - เอาเลขที่ได้จากขั้นตอนที่ 3 มา mod 11 (หารเอาเศษ)
        $sub = 11 - $mod; //ขั้นตอนที่ 5 - เอา 11 ตั้ง ลบออกด้วย เลขที่ได้จากขั้นตอนที่ 4
        $check_digit = $sub % 10; //ถ้าเกิด ลบแล้วได้ออกมาเป็นเลข 2 หลัก ให้เอาเลขในหลักหน่วยมาเป็น Check Digit
        if ($rev[0] == $check_digit)  // ตรวจสอบ ค่าที่ได้ กับ เลขตัวสุดท้ายของ บัตรประจำตัวประชาชน
            echo True; /// ถ้า ตรงกัน แสดงว่าถูก
        else
            echo false; // ไม่ตรงกันแสดงว่าผิด
    }

    public function checkIdCard()
    {
        //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
        $idcard = $this->input->post('idcard');
        $num = $this->employee_model->checkIdCard($idcard);
        if ($num > 0) {
            //มีแล้ว
            echo 1;
        } else {
            //ยังไม่มี
            echo 0;
        }
    }


    public function checkIdCardUpdate()
    {
        //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
        $idcard = $this->input->post('idcard');
        $oldidcard = $this->input->post('oldidcard');
        if ($idcard == $oldidcard) {
            echo 0;
        } else {
            $num = $this->employee_model->checkIdCardUpdate($idcard, $oldidcard);
            if ($num > 0) {
                //มีแล้ว
                echo 1;
            } else {
                //ยังไม่มี
                echo 0;
            }
        }
    }


    public function insertEmp()
    {

        // echo '<pre>';
        // print_r($this->input->post());
        // echo '</pre>';

        // echo $this->input->post('gender');
        $IDposition = $this->input->post('position');
        $idEmployee = $this->genIdEmployee($IDposition);
        $config = array();
        $config['upload_path']          =  './assets/image/employee/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = '2000';
        $config['max_width']            = '3000';
        $config['max_height']           = '3000';
        $config['file_name']        = $idEmployee;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('imgEmp')) {
            echo '<script>';
            echo 'alert("กรุณาอัพโหลดรูป");';
            echo 'location.href= "' . site_url('admin/employee/addEmployee') . '"';
            echo '</script>';
        } else {
            $data['img'] = $this->upload->data();
            $employee_detail = array(
                'ID' => $idEmployee,
                'PASSWORD' => $idEmployee,
                'IDCARD' => $this->input->post('idcard'),
                'TITLENAME' => $this->input->post('title'),
                'FIRSTNAME' => $this->input->post('firstname'),
                'LASTNAME' => $this->input->post('lastname'),
                'GENDER' => $this->input->post('gender'),
                'EMAIL' => $this->input->post('email'),
                'BDATE' => $this->input->post('bdate'),
                'ADDRESS' => $this->input->post('img'),
                'ADDRESS' => $this->input->post('address'),
                'DISTRICT' => $this->input->post('district'),
                'POSITION' =>  $IDposition,
                'SALARY' => $this->input->post('salary'),
                'IMG' => $data['img']['file_name'],
                'BLOOD' => $this->input->post('blood'),
                'NATIONALITY' => $this->input->post('nationality'),
                'RELIGION' => $this->input->post('religion'),
                'CREATE_AT' => date('Y-m-d H:i:s'),
                'STATUS' => 1
            );
            // echo '<pre>';
            // print_r($employee_detail);
            // echo '</pre>';
            $this->crud_model->insert('employee', $employee_detail);
            $tel = $this->input->post('tel');
            foreach ($tel as $phone) {
                $data = array(
                    'PHONE' => $phone,
                    'EMPLOYEE_ID' => $idEmployee
                );
                $this->crud_model->insert('employee_telephone', $data);
            }

            echo '<script>alert("เพิ่มข้อมูลพนักงานสำเร็จ")</script>';
            return redirect(site_url('admin/employee/'));
        }
    }

    //genID Employee 
    public function genIdEmployee($idPosition)
    {
        $idDept =  $this->employee_model->idDeptGenIdEmp($idPosition);
        $maxIdEmployee = $this->employee_model->maxIdEmployee($idDept);
        $firstID = substr($maxIdEmployee, 0, 2);
        $idDept = substr($idDept, 3);
        $date =  date('Y') + 543;
        $Y =  substr($date, 2);
        $m = date('m');
        $midfront =  $m;
        $midback = 00;
        $midback = +$idDept;
        $midback = '0' . $midback;
        $last = '';
        if ($firstID != $Y) {
            $last = 0001;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $midfront .   $midback . $last;
        } else {
            $last = substr($maxIdEmployee, 6);
            $last += 1;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $midfront .   $midback . $last;
        }
    }

    public function deleteEmployee()
    {
        $delete_at = date('Y-m-d H:i:s');
        $empID = $this->input->post('empID');
        $this->employee_model->delEmp($empID, $delete_at);
    }

    public function editEmployee()
    {
        $this->load->model('position_model');
        $id = $this->input->get('empID');
        $data['employee'] = $this->employee_model->editEmp($id);
        // echo '<pre>';
        // print_r($data['employee']);
        // echo '</pre>';
        if ($data['employee'] == null) {
            echo '<script>';
            echo 'alert("ไม่มีข้อมูลพนักงานรหัส ' . $id . '");';
            echo 'location.href= "' . site_url('admin/employee/') . '"';
            echo '</script>';
        } else {

            $data['province']  = $this->employee_model->fetch_province();
            $province_id = $data['employee']['0']->D_PROVINCE_ID;
            $data['amphur'] = $this->crud_model->findwhere('amphur', 'A_PROVINCE_ID', $province_id);
            $amphur_id =  $data['employee']['0']->D_AMPHUR_ID;
            $data['district'] = $this->crud_model->findwhere('district', 'D_AMPHUR_ID', $amphur_id);
            $district_id =  $data['employee']['0']->DISTRICT_ID;
            $data['postcode'] = $this->crud_model->findwhere('district', 'DISTRICT_ID', $district_id);
            $data['department'] = $this->position_model->showDepartment();
            $department_id = $data['employee']['0']->DEPARTMENT_ID;
            $data['position'] = $this->crud_model->findwhere('position', 'DEPT_ID', $department_id);
            $data['phone'] = $this->employee_model->PhoneEmployee($id);
            $data['page'] = 'employee_edit_view';

            $this->load->view('admin/main_view', $data);
        }
    }

    public function updateEmp()
    {
        $check = true;
        $idEmployee = $this->input->post('idEmp');
        if (empty($_FILES['imgEmp']['name'])) {
            $employeeDetail = array(
                'IDCARD' => $this->input->post('idcard'),
                'TITLENAME' => $this->input->post('title'),
                'FIRSTNAME' => $this->input->post('firstname'),
                'LASTNAME' => $this->input->post('lastname'),
                'GENDER' => $this->input->post('gender'),
                'EMAIL' => $this->input->post('email'),
                'BDATE' => $this->input->post('bdate'),
                'ADDRESS' => $this->input->post('address'),
                'DISTRICT' => $this->input->post('district'),
                'POSITION' => $this->input->post('position'),
                'SALARY' => $this->input->post('salary'),
                'BLOOD' => $this->input->post('blood'),
                'NATIONALITY' => $this->input->post('nationality'),
                'RELIGION' => $this->input->post('religion'),
            );
        } else {
            $config = array();
            $config['upload_path']          =  './assets/image/employee/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = '2000';
            $config['max_width']            = '3000';
            $config['max_height']           = '3000';
            $config['file_name']            = $idEmployee;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('imgEmp')) {
                echo '<script>';
                echo 'alert("กรุณาอัพโหลดรูปเท่านั้น");';
                echo 'window.history.back();';
                echo '</script>';
                $check = false;
            } else {
                $oldImg = $this->input->post('oldImg');
                unlink('./assets/image/employee/' . $oldImg);
                $data['img'] = $this->upload->data();
                $employeeDetail = array(
                    'IDCARD' => $this->input->post('idcard'),
                    'TITLENAME' => $this->input->post('title'),
                    'FIRSTNAME' => $this->input->post('firstname'),
                    'LASTNAME' => $this->input->post('lastname'),
                    'GENDER' => $this->input->post('gender'),
                    'EMAIL' => $this->input->post('email'),
                    'BDATE' => $this->input->post('bdate'),
                    'ADDRESS' => $this->input->post('address'),
                    'DISTRICT' => $this->input->post('district'),
                    'POSITION' => $this->input->post('position'),
                    'SALARY' => $this->input->post('salary'),
                    'BLOOD' => $this->input->post('blood'),
                    'NATIONALITY' => $this->input->post('nationality'),
                    'RELIGION' => $this->input->post('religion'),
                    'IMG' => $data['img']['file_name'],
                );
            }
        }

        if ($check) {
            $this->crud_model->update('employee', $employeeDetail, 'ID', $idEmployee);
            $tel = $this->input->post('tel');
            $this->crud_model->delete('employee_telephone', 'EMPLOYEE_ID', $idEmployee);

            foreach ($tel as $phone) {
                $data = array(
                    'PHONE' => $phone,
                    'EMPLOYEE_ID' => $idEmployee
                );
                $this->crud_model->insert('employee_telephone', $data);
            }

        echo '<script>alert("แก้ไขข้อมูลพนักงานสำเร็จ")</script>';
           return redirect(site_url('admin/employee/'));
        }
    }

    public  function resetPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[$i] = $alphabet[$n];
        }
        // $pass = implode($pass); //turn the array into a string
       
        $empID = $this->input->post('empID');
        $this->employee_model->ResetPassword($empID,$pass);
        echo $pass;
    }




    // Employee End



    // Data Start
    public function fetchamphur()
    {
        $province_id = $this->input->post('PROVINCE_ID');
        $data['amphur'] = $this->employee_model->fetch_amphur($province_id);
        echo $data['amphur'];
    }

    public function fetchdistrict()
    {
        $amphur_id = $this->input->post("AMPHUR_ID");
        $data['district'] = $this->employee_model->fetch_district($amphur_id);
        echo $data['district'];
    }
    public function fetchpostcode()
    {
        $district_id = $this->input->post("DISTRICT_ID");
        $data['postcode'] = $this->employee_model->fetch_postcode($district_id);
        echo $data['postcode'];
    }

    public function fetchdepartment()
    {
        $department_id = $this->input->post('DEPARTMENT_ID');
        $data['department'] = $this->employee_model->fetch_position($department_id);
        echo $data['department'];
    }
    // Data End



}
