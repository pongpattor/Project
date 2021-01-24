<?php
defined('BASEPATH') or exit('No direct script access allowed');

class employee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if (empty($_SESSION['login'])) {
        //     return redirect(site_url('admin/login'));
        // }
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
        if ($data['employee'] != null) {
            $arrEmployeeTel = [];
            foreach ($data['employee'] as $row) {
                array_push($arrEmployeeTel, $row->empID);
            }
            $empID = implode(",", $arrEmployeeTel);

            $data['employeeTel'] = $this->employee_model->fetchEmployeeTel($empID);
        }
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'employee_view';
        //  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $this->load->view('admin/main_view', $data);
    }

    public function addEmployee()
    {
        $this->load->model('position_model');
        $data['province'] = $this->crud_model->findall('province');
        $data['department'] = $this->crud_model->findAll('department');
        $data['page'] = 'employee_add_view';
        $this->load->view('admin/main_view', $data);
    }



    public function insertEmployee()
    {
        $data['status'] = true;
        $data['input'] = $this->input->post('employeeImage');
        $data['image'] = $_FILES['employeeImage'];

        $employeeIdCard = $this->input->post('employeeIdCard');
        $checkIdCard = $this->checkIdCard($employeeIdCard);
        if ($checkIdCard == true) {
            $num = $this->crud_model->count2Where('employee', 'EMPLOYEE_IDCARD', $employeeIdCard, 'EMPLOYEE_STATUS', '1');
            if ($num == 0) {
                $data['employeeIdCardError'] = '';
            } else {
                $data['employeeIdCardError'] = 'บัตรประชาชนนี้ได้ถูกใช้ไปแล้ว';
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
            $data['employeeIdCardError'] = 'กรุณากรอกบัตรประชาชนให้ถูกต้อง';
        }

        // เพิ่มข้อมูล
        if ($data['status'] == true) {
            $employeeID = $this->genIdEmployee();
            $config = array();
            $config['upload_path']          =  './assets/image/employee/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = '2000';
            $config['max_width']            = '3000';
            $config['max_height']           = '3000';
            $config['file_name']            = $employeeID;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('employeeImage')) {
                $employeeImage['img'] = $this->upload->data();
                $dataEmployee = array(
                    'EMPLOYEE_ID' => $employeeID,
                    'EMPLOYEE_PASSWORD' => $employeeID,
                    'EMPLOYEE_IDCARD' => $this->input->post('employeeIdCard'),
                    'EMPLOYEE_FIRSTNAME' => $this->input->post('employeeFirstName'),
                    'EMPLOYEE_LASTNAME' => $this->input->post('employeeLastName'),
                    'EMPLOYEE_GENDER' => $this->input->post('employeeGender'),
                    'EMPLOYEE_EMAIL' => $this->input->post('employeeEmail'),
                    'EMPLOYEE_BDATE' => $this->input->post('employeeBdate'),
                    'EMPLOYEE_ADDRESS' => $this->input->post('employeeAddress'),
                    'EMPLOYEE_DISTRICT' => $this->input->post('district'),
                    'EMPLOYEE_POSITION' => $this->input->post('employeePosition'),
                    'EMPLOYEE_SALARY' => $this->input->post('employeeSalary'),
                    'EMPLOYEE_IMAGE' =>  $employeeImage['img']['file_name'],
                    'EMPLOYEE_STATUS' => '1',
                );
                $this->crud_model->insert('employee', $dataEmployee);

                $employeeTel = $this->input->post('employeeTel');
                $i = 1;
                foreach ($employeeTel as $rowTel) {
                    $dataEmployeeTel = array(
                        'EMPLOYEETEL_ID' => $employeeID,
                        'EMPLOYEETEL_NO' => $i,
                        'EMPLOYEETEL_TEL' => $rowTel,
                    );
                    $this->crud_model->insert('employeetel', $dataEmployeeTel);
                    $i++;
                }
                $data['url'] = site_url('admin/employee');
                $data['message'] = 'เพิ่มข้อมูลพนักงานเสร็จสิ้น';
            }
        } else {
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
        }
        echo json_encode($data);
    }


    public function checkIdCard($employeeIdCard)
    {
        //ตรวจรหัสบัตรว่าใช่เลขบัตรจริงไหม
        $rev = strrev($employeeIdCard); // reverse string ขั้นที่ 0 เตรียมตัว
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
            return True; /// ถ้า ตรงกัน แสดงว่าถูก
        else
            return false; // ไม่ตรงกันแสดงว่าผิด
    }


    //genID Employee 
    public function genIdEmployee()
    {
        $maxID =  $this->crud_model->maxID('employee', 'EMPLOYEE_ID');
        $ndate = date('ymd');
        // echo $year;
        if ($maxID == Null) {
            return 'EMP' . $ndate . '001';
        } else {
            $odate = substr($maxID, 3, 6);
            if ($odate != $ndate) {
                return 'EMP' . $ndate . '001';
            } else {
                $no = substr($maxID, 9, 3);
                $no = $no + 1;
                while (strlen($no) < 3) {
                    $no = '0' . $no;
                }
                return 'EMP' . $ndate . $no;
            }
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

    public function editEmployee()
    {
        $employeeID = $this->input->get('employeeID');
        $data['employee'] = $this->employee_model->editEmployee($employeeID);
        $data['province']  = $this->crud_model->findAll('province');
        $provinceID = $data['employee']['0']->D_PROVINCE_ID;
        $data['amphur'] = $this->crud_model->findSelectWhere('amphur', 'AMPHUR_ID,AMPHUR_NAME', 'A_PROVINCE_ID', $provinceID);
        $amphurID =  $data['employee']['0']->D_AMPHUR_ID;
        $data['district'] = $this->crud_model->findSelectWhere('district', 'DISTRICT_ID,DISTRICT_NAME', 'D_AMPHUR_ID', $amphurID);
        $districtID =  $data['employee']['0']->DISTRICT_ID;
        $data['postcode'] = $this->crud_model->findSelectWhere('district', 'POSTCODE', 'DISTRICT_ID', $districtID);
        $data['department'] = $this->crud_model->findAll('department');
        $positionID = $data['employee']['0']->POSITION_ID;
        $data['position'] = $this->crud_model->findSelectWhere('position', 'POSITION_ID,POSITION_NAME', 'POSITION_ID', $positionID);
        $data['employeeTel'] = $this->crud_model->findSelectWhere('employeetel', 'EMPLOYEETEL_ID,EMPLOYEETEL_TEL', 'EMPLOYEETEL_ID',  $employeeID);
        // echo '<pre>';
        // print_r($data);   
        // echo '</pre>' ;
        $data['page'] = 'employee_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateEmployee()
    {
        $data['status'] = true;
        $employeeIdCard =  $this->input->post('employeeIdCard');
        $employeeIdCardOld =  $this->input->post('employeeIdCardOld');
        if ($employeeIdCard != $employeeIdCardOld) {
            $checkIdCard = $this->checkIdCard($employeeIdCard);
            if ($checkIdCard == true) {
                $num = $this->crud_model->count2Where('employee', 'EMPLOYEE_IDCARD', $employeeIdCard, 'EMPLOYEE_STATUS', '1');
                if ($num == 0) {
                    $data['employeeIdCardError'] = '';
                } else {
                    $data['status'] = false;
                    $data['employeeIdCardError'] = 'บัตรประชาชนนี้ได้ถูกใช้ไปแล้ว';
                }
            } else {
                $data['status'] = false;
                $data['employeeIdCardError'] = 'กรุณากรอกบัตรประชาชนให้ถูกต้อง';
            }
        }
        if ($data['status'] == true) {
            $employeeID = $this->input->post('employeeID');
            $employeeFirstName = $this->input->post('employeeFirstName');
            $employeeLastName = $this->input->post('employeeLastName');
            $employeeGender = $this->input->post('employeeGender');
            $employeeEmail = $this->input->post('employeeEmail');
            $employeeBdate = $this->input->post('employeeBdate');
            $employeeAddress = $this->input->post('employeeAddress');
            $employeeDistrict = $this->input->post('district');
            $employeePosition = $this->input->post('employeePosition');
            $employeeSalary = $this->input->post('employeeSalary');
            $employeeTel = $this->input->post('employeeTel');
            if (!empty($_FILES['employeeImage']['name'])) {
                $employeeImageOld = $this->input->post('employeeImageOld');
                unlink('./assets/image/employee/' . $employeeImageOld);
            }
            $config = array();
            $config['upload_path']          =  './assets/image/employee/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = '2000';
            $config['max_width']            = '3000';
            $config['max_height']           = '3000';
            $config['file_name']            = $employeeID;
            $this->load->library('upload', $config);
            $this->upload->do_upload('employeeImage');
            $dataEmployee = array(
                'EMPLOYEE_IDCARD' => $employeeIdCard,
                'EMPLOYEE_FIRSTNAME' => $employeeFirstName,
                'EMPLOYEE_LASTNAME' => $employeeLastName,
                'EMPLOYEE_GENDER' => $employeeGender,
                'EMPLOYEE_EMAIL' => $employeeEmail,
                'EMPLOYEE_BDATE' => $employeeBdate,
                'EMPLOYEE_ADDRESS' => $employeeAddress,
                'EMPLOYEE_DISTRICT' => $employeeDistrict,
                'EMPLOYEE_POSITION' => $employeePosition,
                'EMPLOYEE_SALARY' => $employeeSalary,
            );
            $this->crud_model->update('employee', $dataEmployee, 'EMPLOYEE_ID', $employeeID);
            $this->crud_model->delete('employeeTel', 'EMPLOYEETEL_ID', $employeeID);
            $i = 1;
            foreach ($employeeTel as $rowTel) {
                $dataEmployeeTel = array(
                    'EMPLOYEETEL_ID' => $employeeID,
                    'EMPLOYEETEL_NO' => $i,
                    'EMPLOYEETEL_TEL' => $rowTel,
                );
                $this->crud_model->insert('employeeTel', $dataEmployeeTel);
                $i++;
            }
            $data['url'] = site_url('admin/employee');
        }
        echo json_encode($data);
    }

    public  function resetPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[$i] = $alphabet[$n];
        }
        $pass = implode('', $pass); //turn the array into a string

        $employeeID = $this->input->post('employeeID');
        $this->crud_model->UpdateStatus('employee', 'EMPLOYEE_PASSWORD', $pass, 'EMPLOYEE_ID', $employeeID);
        $data['pass'] = $pass;
        echo json_encode($data);
    }

    public function deleteEmployee()
    {
        $employeeID = $this->input->post('employeeID');
        $this->crud_model->UpdateStatus('employee', 'EMPLOYEE_STATUS', '0', 'EMPLOYEE_ID', $employeeID);

    }
}
