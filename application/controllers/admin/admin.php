<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('base_data_model');
        $this->load->model('crud_model');
        $this->load->model('employee_model');
        $this->load->model('receive_ingredient_model');
        $this->load->model('desk_model');
        $this->load->library('pagination');
    }



    public function home()
    {
        $data['page'] = 'home';
        $this->load->view('admin/main_view', $data);
    }

    // Employee Start

    public function employee()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/admin/employee');
        $config['total_rows'] = $this->employee_model->countEmployee($search);
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
        $data['employee'] = $this->employee_model->fetchEmp($search,$limit, $offset);
        $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'employee_view';
        $this->load->view('admin/main_view', $data);
    }



    public function addEmployee()
    {

        $data['province'] = $this->crud_model->find('province', 'PROVINCE_ID,PROVINCE_NAME');
        $data['department'] = $this->crud_model->findall('department');
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

    public function checkIdCard($idcard)
    {
        //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
        $num = $this->employee_model->checkIdCard($idcard);
        if ($num > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insertEmp()
    {

        $config = array();
        $config['upload_path']          =  './assets/image/employee/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = '2000';
        $config['max_width']            = '3000';
        $config['max_height']           = '3000';
        $this->load->library('upload', $config);

        $idCard = $this->input->post('idcard');
        $num = $this->checkIdCard($idCard);
        $IDposition = $this->input->post('position');
        if ($num == 0) {
            if (!$this->upload->do_upload('imgEmp')) {
                echo '<script>';
                echo 'alert("กรุณาอัพโหลดรูปเท่านั้น");';
                echo 'window.history.back();';
                echo '</script>';
            } else {
                $data['img'] = $this->upload->data();
                $employee_detail = array(
                    'ID' => $this->genID($IDposition),
                    'PASSWORD' => $this->genID($IDposition),
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
                    'AMPHUR' => $this->input->post('amphur'),
                    'PROVINCE' => $this->input->post('province'),
                    'POSTCODE' => $this->input->post('postcode'),
                    'POSITION' =>  $IDposition,
                    'SALARY' => $this->input->post('salary'),
                    'IMG' => $data['img']['file_name'],
                    'CREATE_AT' => date('Y-m-d H:i:s'),
                    'STATUS' => 1
                );
                // echo '<pre>';
                // print_r($employee_detail);
                // echo '</pre>';
                $this->crud_model->insert('employee', $employee_detail);
                $id = $this->employee_model->maxIdEmp($IDposition);
                $tel = $this->input->post('tel');
                foreach ($tel as $row) {
                    $data = array(
                        'PHONE' => $row,
                        'EMPLOYEE_ID' => $id
                    );
                    $this->crud_model->insert('employee_telephone', $data);
                }
                redirect(site_url('admin/admin/employee'));
            }
        } else {
            echo '<script>';
            echo 'alert("รหัสประชาชนได้ถูกใช้แล้ว");';
            echo 'window.history.back();';
            echo '</script>';
        }
    }

    //genID Employee 
    public function genID($posid)
    {
        $maxId = $this->employee_model->maxIdEmp($posid);
        $firstID = substr($maxId, 0, 2);
        $date =  date('Y') + 543;
        $Y =  substr($date, 2);
        $middle = 1100;
        $middle += $posid;

        if ($firstID != $Y) {
            $last = 0001;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $middle . $last;
        } else {
            $last = substr($maxId, 6);
            $last += 1;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $middle . $last;
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
        $id = $this->input->get('empID');
        $data['employee'] = $this->employee_model->editEmp($id);
        $data['province']  = $this->base_data_model->fetch_province();
        $province_id = $data['employee']['0']->PROVINCE;
        $data['amphur'] = $this->crud_model->findwhere('amphur', 'PROVINCE_ID', $province_id);
        $amphur_id =  $data['employee']['0']->AMPHUR;
        $data['district'] = $this->crud_model->findwhere('district', 'AMPHUR_ID', $amphur_id);
        $data['department'] = $this->crud_model->findall('department');
        $department_id = $data['employee']['0']->DEPARTMENT_ID;
        $data['position'] = $this->crud_model->findwhere('position', 'DEPT_ID', $department_id);
        $data['phone'] = $this->employee_model->PhoneEmployee($id);

        // echo '<pre>';
        //     print_r($data['position']);   
        //     echo '</pre>' ;

        $data['page'] = 'employee_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateEmp()
    {
        $idEmp = $this->input->post('idEmp');
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
            'AMPHUR' => $this->input->post('amphur'),
            'PROVINCE' => $this->input->post('province'),
            'POSTCODE' => $this->input->post('postcode'),
            'POSITION' => $this->input->post('position'),
            'SALARY' => $this->input->post('salary'),
        );
        $this->crud_model->update('employee', $employeeDetail, 'ID', $idEmp);
        $tel = $this->input->post('tel');
        $this->crud_model->delete('employee_telephone', 'EMPLOYEE_ID', $idEmp);
        foreach ($tel as $row) {
            $data = array(
                'PHONE' => $row,
                'EMPLOYEE_ID' => $idEmp
            );
            $this->crud_model->insert('employee_telephone', $data);
        }
        redirect(site_url('admin/admin/employee'));
    }


    // Employee End


    // Data Start

    public function fetchamphur()
    {
        $this->load->model('base_data_model');
        $province_id = $this->input->post('PROVINCE_ID');
        $data['amphur'] = $this->base_data_model->fetch_amphur($province_id);
        echo $data['amphur'];
    }

    public function fetchdistrict()
    {
        $this->load->model('base_data_model');
        $amphur_id = $this->input->post("AMPHUR_ID");
        $data['district'] = $this->base_data_model->fetch_district($amphur_id);
        echo $data['district'];
    }
    public function fetchpostcode()
    {
        $this->load->model('base_data_model');
        $district_id = $this->input->post("DISTRICT_ID");
        $data['postcode'] = $this->base_data_model->fetch_postcode($district_id);
        echo $data['postcode'];
    }

    public function fetchdepartment()
    {
        $this->load->model('base_data_model');
        $department_id = $this->input->post('DEPARTMENT_ID');
        $data['department'] = $this->base_data_model->fetch_position($department_id);
        echo $data['department'];
    }

    // Data End

    // Department Start
    public function Department()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['department'] = $this->employee_model->searchDepartment($search);
        } else {
            $data['department'] = $this->crud_model->findall('department');
        }
        $data['page'] = 'department_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDepartment()
    {
        $data['page'] = 'department_add_view';
        $data['employee'] = $this->crud_model->findColumns('ID,FIRSTNAME,LASTNAME', 'employee');
        $this->load->view('admin/main_view', $data);
    }

    public function insertDepartment()
    {
        $dept = array(
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->insert('department', $dept);

        redirect(site_url('admin/admin/department'));
    }
    public function editDepartment()
    {
        $deptID = $this->input->get('departmentID');
        $data['page'] = 'department_edit_view';
        $data['oldDept'] = $this->employee_model->editDept($deptID);
        $this->load->view('admin/main_view', $data);
    }
    public function updateDepartment()
    {
        $DEPARTMENT_ID = $this->input->post('DEPARTMENT_ID');
        $department_detail = array(
            'DEPARTMENT_ID' => $DEPARTMENT_ID,
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->update('department', $department_detail, 'DEPARTMENT_ID', $DEPARTMENT_ID);
        redirect(site_url('admin/admin/department'));
    }

    public function deleteDepartment()
    {
        $dept = $this->input->post('deptID');
        $this->crud_model->delete('department', 'DEPARTMENT_ID', $dept);
    }

    // Department End


    // Position Start
    public function position()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['dept_pos'] = $this->employee_model->searchPosition($search);
        } else {
            $data['dept_pos'] = $this->employee_model->position();
        }
        $data['page'] = 'position_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addPosition()
    {
        $data['page'] = 'position_add_view';
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view', $data);
    }

    public function insertPos()
    {
        $position = array(
            'POSITION_NAME' => $this->input->post('positionName'),
            'DEPT_ID' => $this->input->post('departmentID')
        );

        $this->crud_model->insert('position', $position);

        redirect(site_url('admin/admin/position'));
    }

    public function editPosition()
    {
        $posID = $this->input->get('positionID');
        $data['page'] = 'position_edit_view';
        $data['oldPos'] = $this->crud_model->findwhere('position', 'POSITION_ID', $posID);
        $data['department'] = $this->crud_model->findall('department');



        $this->load->view('admin/main_view', $data);
    }

    public function updatePosition()
    {
        $POSITION_ID = $this->input->post('positionID');
        $position_detail = array(
            'POSITION_NAME' => $this->input->post('positionName'),
            'DEPT_ID' => $this->input->post('departmentID'),
        );
        $this->crud_model->update('position', $position_detail, 'POSITION_ID', $POSITION_ID);
        redirect(site_url('admin/admin/position'));
    }

    public function deletePosition()
    {
        $pos = $this->input->post('posID');
        $this->crud_model->delete('position', 'POSITION_ID', $pos);
    }

    // Position End

    // Table Start
    public function desk()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['desk'] =  $this->desk_model->searchDesk($search);
        } else {
            $data['desk'] =  $this->desk_model->fetchDesk();
        }
        $data['page'] = 'desk_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDesk()
    {
        $data['page'] = 'desk_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertDesk()
    {
        $deskNumber = $this->input->post('deskNumber');
        $count = $this->checkDeskNumber($deskNumber);
        if ($count > 0) {
            echo '<script>';
            echo 'alert("เลขโต๊ะนี้ได้มีการใช้แล้ว");';
            echo 'window.history.back();';
            echo '</script>';
        } else {
            $detailDesk = array(
                'DESK_ID' => $this->genDeskID(),
                'DESK_NUMBER' => $deskNumber,
                'DESK_STATUS' => '0'
            );
            $this->crud_model->insert('desk', $detailDesk);
            redirect(site_url('admin/admin/desk'));
        }
    }

    public function genDeskID()
    {
        $maxId =  $this->desk_model->maxID();
        $ID = substr($maxId, 1) + 1;
        while (strlen($ID) < 3) {
            $ID =  '0' . $ID;
        }

        $deskID = 'D' . $ID;
        return $deskID;
    }

    public function checkDeskNumber($number)
    {
        $count = $this->desk_model->checkNumber($number);
        return $count;
    }

    public function editDesk()
    {
        $deskID = $this->input->get('deskID');
        $data['desk'] = $this->crud_model->findwhere('desk', 'DESK_ID', $deskID);
        $data['page'] = 'desk_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateDesk()
    {
        $deskNumber = $this->input->post('deskNumber');
        $deskStatus = $this->input->post('status');
        $deskID = $this->input->post('deskID');
        $oldNumber = $this->input->post('oldNumber');
        if ($oldNumber == $deskNumber) {
            $deskDetail = array(
                'DESK_NUMBER' => $deskNumber,
                'DESK_STATUS' => $deskStatus
            );
            $this->crud_model->update('desk', $deskDetail, 'DESK_ID', $deskID);
            redirect(site_url('admin/admin/desk'));
        } else {
            $count = $this->checkDeskNumber($deskNumber);
            if ($count > 0) {
                echo '<script>';
                echo 'alert("เลขโต๊ะนี้ได้มีการใช้แล้ว");';
                echo 'window.history.back();';
                echo '</script>';
            } else {
                $deskDetail = array(
                    'DESK_NUMBER' => $deskNumber,
                    'DESK_STATUS' => $deskStatus
                );
                $this->crud_model->update('desk', $deskDetail, 'DESK_ID', $deskID);
                redirect(site_url('admin/admin/desk'));
            }
        }
    }

    public function deleteDesk()
    {
        $deskID = $this->input->post('deskID');
        $this->desk_model->delDesk($deskID);
    }


    // Table End

    // receiveIngredient start
    public function receiveIngredient()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['receive_ingredient'] = $this->receive_ingredient_model->searchReceive($search);
        } else {
            $data['receive_ingredient'] = $this->receive_ingredient_model->fetchReceive();
        }
        $data['page'] = 'receive_ingredient_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addReceiveIngredient()
    {
        $data['page'] = 'receive_ingredient_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function InsertReceiveIngredient()
    {
        $receiveName = $this->input->post("ReceiveName");
        $receivePrice = $this->input->post("ReceivePrice");
        $totalPrice = 0;
        foreach ($receivePrice as $row) {
            $totalPrice += $row;
        }

        $Receive = array(
            'DATE_AT' => date('Y-m-d H:i:s'),
            'TOTAL_PRICE' => $totalPrice,
            'TIME_AT' => date('H:i:s')
        );
        $this->crud_model->insert('receive_ingredient', $Receive);
        $receiveID = $this->receive_ingredient_model->maxIdReceiveIngredien();

        for ($i = 0; $i < count($receiveName); $i++) {
            $receiveDetail = array(
                "INGREDIENT_NO" => $i + 1,
                "INGREDIENT_RECEIVE_ID" => $receiveID,
                "INGREDIENT_NAME" => $receiveName[$i],
                "INGREDIENT_PRICE" => $receivePrice[$i]
            );
            $this->crud_model->insert('receive_ingredient_detail', $receiveDetail);
        }

        redirect(site_url('admin/admin/receiveIngredient'));
    }

    public function editReceiveIngredient()
    {
        $ReceiveID = $this->input->GET("ReceiveID");
        $data['ingredient'] = $this->crud_model->findwhere('receive_ingredient_detail', 'INGREDIENT_RECEIVE_ID', $ReceiveID);
        // print_r($data['ingredient']);
        $data['page'] = 'receive_ingredient_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function UpdateReceiveIngredient()
    {

        $receiveID =  $this->input->POST('receiveID');
        $receiveName = $this->input->POST('ReceiveName');
        $receivePrice = $this->input->POST('ReceivePrice');

        $this->crud_model->delete('receive_ingredient_detail', 'INGREDIENT_RECEIVE_ID', $receiveID);
        for ($i = 0; $i < count($receiveName); $i++) {
            $receiveDetail = array(
                "INGREDIENT_NO" => $i + 1,
                "INGREDIENT_RECEIVE_ID" => $receiveID,
                "INGREDIENT_NAME" => $receiveName[$i],
                "INGREDIENT_PRICE" => $receivePrice[$i]
            );
            $this->crud_model->insert('receive_ingredient_detail', $receiveDetail);
        }
        redirect(site_url('admin/admin/receiveIngredient'));
    }

    public function deleteReceiveIngredient()
    {
        $ReceiveID = $this->input->post('ReceiveID');
        $this->crud_model->delete('receive_ingredient', 'RECEIVE_INGREDIENT_ID', $ReceiveID);
    }

    // receiveIngredient End

    public function test()
    {
        $data['hello'] = $this->employee_model->searchDepartment('30');
        print_r($data['hello']);
        // $data['page'] = 'Test';
        // $this->load->view('admin/main_view', $data);
    }
}
