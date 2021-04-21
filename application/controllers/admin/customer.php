<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } 
        else if ($_SESSION['employeePermission'][0] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('customer_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/customer/index');
        $config['total_rows'] = $this->customer_model->countAllCustomer($search);
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
        $data['customer'] = $this->customer_model->Customer($search, $limit, $offset);
        if ($data['customer'] != null) {
            $arrCustomer = [];
            foreach ($data['customer'] as $row) {
                array_push($arrCustomer, $row->cusID);
            }
            $cusID = implode(",", $arrCustomer);

            $data['customertel'] = $this->customer_model->fetchCustomerTel($cusID);
        }
        // echo '<pre>';
        // print_r($data['customertel']);
        // echo '</pre>';
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'customer_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addCustomer()
    {
        $data['customerType'] = $this->crud_model->findSelectWhere('customerType','CUSTOMERTYPE_ID,CUSTOMERTYPE_NAME','CUSTOMERTYPE_STATUS','1');
        $data['province'] = $this->crud_model->findAll('province');
        $data['page'] = 'customer_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertCustomer()
    {
        $customerTel = $this->input->post('customerTel');
        $customerIdCard = $this->input->post('customerIdCard');
        $data['asd'] = $this->input->post();
        $data['status'] = true;
        // ตรวจความถูกต้องของบัตรประชาชน
        $checkCustomerIdCard = $this->checkIdCard($customerIdCard);
        if ($checkCustomerIdCard == true) {
            //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
            $num = $this->crud_model->count2Where('customer', 'CUSTOMER_IDCARD', $customerIdCard, 'CUSTOMER_STATUS', '1');
            if ($num == 0) {
                $data['errorIdCard'] = '';
            } else {
                $data['errorIdCard'] = 'บัตรประชาชนนี้ได้ถูกใช้ไปแล้ว';
                $data['status'] = false;
            }
        } else {
            $data['errorIdCard'] = 'กรุณากรอกบัตรประชาชนให้ถูกต้อง';
            $data['status'] = false;
        }
        //จบตรวจบัตร

        // ตรวจเบอร์ซ้ำ
        $allTel = '';
        for ($i = 0; $i < count($customerTel); $i++) {
            $allTel .= '\'';
            $allTel .= $customerTel[$i];
            $allTel .= '\'';
            if ($i != (count($customerTel) - 1)) {
                $allTel .= ',';
            }
        }
        $data['allTel'] = $allTel;
        $checkCustomerTel = $this->customer_model->checkCustomerTel($allTel);
        if ($checkCustomerTel == 0) {
            $data['errorTel'] = '';
        } else {
            $allDupliTel = $this->crud_model->findIn('customertel', 'CUSTOMERTEL_TEL', 'CUSTOMERTEL_TEL', $allTel);
            $arrTel = [];
            foreach ($allDupliTel as $row) {
                array_push($arrTel, $row->CUSTOMERTEL_TEL);
            }
            $error = implode(',', $arrTel);
            $error .= ' ได้ถูกใช้ไปแล้ว';
            $data['errorTel'] = $error;
            $data['status'] = false;
        }
        // จบตรวจเบอร์
        // เพิ่มข้อมูล
        if ($data['status'] == true) {
            $customerID = $this->genIdCustomer();
            $customerFirstName = $this->input->post('customerFirstName');
            $customerLastName = $this->input->post('customerLastName');
            $customerGender = $this->input->post('customerGender');
            $customerBdate = $this->input->post('customerBdate');
            $customerAddress = $this->input->post('customerAddress');
            $customerDistrict = $this->input->post('district');
            $customerType = $this->input->post('customerType');
            $datacustomer = array(
                'CUSTOMER_ID' => $customerID,
                'CUSTOMER_IDCARD' => $customerIdCard,
                'CUSTOMER_FIRSTNAME' => $customerFirstName,
                'CUSTOMER_LASTNAME' => $customerLastName,
                'CUSTOMER_GENDER' => $customerGender,
                'CUSTOMER_BDATE' => $customerBdate,
                'CUSTOMER_ADDRESS' => $customerAddress,
                'CUSTOMER_DISTRICT' => $customerDistrict,
                'CUSTOMER_CUSTOMERTYPE' => $customerType,
                'CUSTOMER_STATUS' => '1',
            );
            $data['id'] = $customerID;
            $this->crud_model->insert('customer', $datacustomer);
            $i = 1;
            foreach ($customerTel as $row) {
                $dataCustomerTel = array(
                    'CUSTOMERTEL_ID' => $customerID,
                    'CUSTOMERTEL_TEL' => $row,
                    'CUSTOMERTEL_NO' => $i,
                );
                $this->crud_model->insert('customertel', $dataCustomerTel);
                $i++;
            }
            $data['url'] = site_url('admin/customer');
            $data['message'] = 'เพิ่มข้อมูลสมาชิกเสร็จสิ้น';
        } else {
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
        }
        echo json_encode($data);
    }

    public function genIdCustomer()
    {
        $maxID =  $this->crud_model->maxID('customer', 'CUSTOMER_ID');
        $ndate = date('ymd');
        // echo $year;
        if ($maxID == Null) {
            return 'CUS' . $ndate . '001';
        } else {
            $odate = substr($maxID, 3, 6);
            if ($odate != $ndate) {
                return 'CUS' . $ndate . '001';
            } else {
                $no = substr($maxID, 9, 3);
                $no = $no + 1;
                while (strlen($no) < 3) {
                    $no = '0' . $no;
                }
                return 'CUS' . $ndate . $no;
            }
        }
    }
    public function checkIdCard($customerIdCard)
    {
        //ตรวจรหัสบัตรว่าใช่เลขบัตรจริงไหม
        $rev = strrev($customerIdCard); // reverse string ขั้นที่ 0 เตรียมตัว
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

    public function editCustomer()
    {
        $customerID = $this->input->get('customerID');
        $data['customer'] = $this->customer_model->editCustomer($customerID);
        $data['customerTel'] = $this->crud_model->findSelectWhere('customertel', 'CUSTOMERTEL_ID,CUSTOMERTEL_TEL', 'CUSTOMERTEL_ID',  $customerID);
        $data['customerType'] = $this->crud_model->findSelectWhere('customerType','CUSTOMERTYPE_ID,CUSTOMERTYPE_NAME','CUSTOMERTYPE_STATUS','1');
        $data['province'] = $this->crud_model->findAll('province');
        $province = $data['customer']['0']->PROVINCE_ID;
        $data['amphur'] = $this->crud_model->findSelectWhere('amphur', 'AMPHUR_ID,AMPHUR_NAME', 'A_PROVINCE_ID', $province);
        $amphur = $data['customer']['0']->AMPHUR_ID;
        $data['district'] = $this->crud_model->findSelectWhere('district', 'DISTRICT_ID,DISTRICT_NAME', 'D_AMPHUR_ID', $amphur);
        $district = $data['customer']['0']->DISTRICT_ID;
        $data['postcode'] = $this->crud_model->findSelectWhere('district', 'POSTCODE', 'DISTRICT_ID', $district);
        $data['page'] = 'customer_edit_view';
        // echo '<pre>';
        // print_r($data['customer']);
        // echo '</pre>';
        $this->load->view('admin/main_view', $data);
    }

    public function updateCustomer()
    {
        // $data['input'] = $this->input->post();
        $data['status'] = true;
        $customerIdCard = $this->input->post('customerIdCard');
        $customerIdCardOld = $this->input->post('customerIdCardOld');

        //เลขประชาชนกรอกใหม่
        if ($customerIdCard != $customerIdCardOld) {
            // // ตรวจความถูกต้องของบัตรประชาชน
            $checkCustomerIdCard = $this->checkIdCard($customerIdCard);
            if ($checkCustomerIdCard == true) {
                //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
                $num = $this->crud_model->count2Where('customer', 'CUSTOMER_IDCARD', $customerIdCard, 'CUSTOMER_STATUS', '1');
                if ($num == 0) {
                    $data['errorIdCard'] = '';
                } else {
                    $data['errorIdCard'] = 'บัตรประชาชนนี้ได้ถูกใช้ไปแล้ว';
                    $data['status'] = false;
                }
            } else {
                $data['errorIdCard'] = 'กรุณากรอกบัตรประชาชนให้ถูกต้อง';
                $data['status'] = false;
            }
            // //จบตรวจบัตร
        }

        // //ตรวจเบอร์ซ้ำ
        $customerTel = $this->input->post('customerTel');
        $customerTelOld = $this->input->post('customerTelOld');
        $newTel = array_diff($customerTel, $customerTelOld);
        //ถ้าจำนวนเบอร์ใหม่ไม่เท่ากับ 0 หรือ มากกว่า 0
        $arrNewTel = [];
        foreach ($newTel as $rowNewTel) {
            array_push($arrNewTel, $rowNewTel);
        }
        // $data['checkNewTel'] = $arrNewTel;
        if (count($arrNewTel) > 0) {
            $allTel = '';
            for ($i = 0; $i < count($arrNewTel); $i++) {
                $allTel .= '\'';
                $allTel .= $arrNewTel[$i];
                $allTel .= '\'';
                if ($i != (count($arrNewTel) - 1)) {
                    $allTel .= ',';
                }
            }
            $data['allTel'] = $allTel;
            $checkCustomerTel = $this->customer_model->checkCustomerTel($allTel);
            if ($checkCustomerTel == 0) {
                $data['errorTel'] = '';
            } else {
                $allDupliTel = $this->crud_model->findIn('customertel', 'CUSTOMERTEL_TEL', 'CUSTOMERTEL_TEL', $allTel);
                $arrTel = [];
                foreach ($allDupliTel as $row) {
                    array_push($arrTel, $row->CUSTOMERTEL_TEL);
                }
                $error = implode(',', $arrTel);
                $error .= ' ได้ถูกใช้ไปแล้ว';
                $data['errorTel'] = $error;
                $data['status'] = false;
            }
            // จบตรวจเบอร์

        }
        // จบตรวจเบอร์


        // แก้ไขข้อมูล
        if ($data['status'] == true) {
            $customerID = $this->input->post('customerID');
            $customerFirstName = $this->input->post('customerFirstName');
            $customerLastName = $this->input->post('customerLastName');
            $customerGender = $this->input->post('customerGender');
            $customerBdate = $this->input->post('customerBdate');
            $customerAddress = $this->input->post('customerAddress');
            $customerDistrict = $this->input->post('district');
            $customerType = $this->input->post('customerType');
            $datacustomer = array(
                'CUSTOMER_IDCARD' => $customerIdCard,
                'CUSTOMER_FIRSTNAME' => $customerFirstName,
                'CUSTOMER_LASTNAME' => $customerLastName,
                'CUSTOMER_GENDER' => $customerGender,
                'CUSTOMER_BDATE' => $customerBdate,
                'CUSTOMER_ADDRESS' => $customerAddress,
                'CUSTOMER_DISTRICT' => $customerDistrict,
                'CUSTOMER_CUSTOMERTYPE' => $customerType,
            );
            $this->crud_model->update('customer', $datacustomer, 'CUSTOMER_ID', $customerID);
            $this->crud_model->delete('customertel', 'CUSTOMERTEL_ID', $customerID);
            $i = 1;
            foreach ($customerTel as $row) {
                $dataCustomerTel = array(
                    'CUSTOMERTEL_ID' => $customerID,
                    'CUSTOMERTEL_TEL' => $row,
                    'CUSTOMERTEL_NO' => $i,
                );
                $this->crud_model->insert('customertel', $dataCustomerTel);
                $i++;
            }
            $data['url'] = site_url('admin/customer');
            $data['message'] = 'แก้ไขข้อมูลสมาชิกเสร็จสิ้น';
        } else {
            $data['message'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
        }
        echo json_encode($data);
    }

    public function deleteCustomer()
    {
        $customerID = $this->input->post('customerID');
        $this->crud_model->UpdateStatus('customer', 'CUSTOMER_STATUS', '0', 'CUSTOMER_ID', $customerID);
        $data['url'] = site_url('admin/customer');
        echo json_encode($data);
    }
}
