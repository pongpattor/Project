<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
        $data['customerType'] = $this->crud_model->find('customerType', 'CUSTOMERTYPE_ID,CUSTOMERTYPE_NAME');
        $data['province'] = $this->crud_model->findAll('province');
        $data['page'] = 'customer_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertCustomer()
    {
        $customerTel = $this->input->post('customerTel');
        $customerIdCard = $this->input->post('customerIdCard');
        $data['status'] = true;
        // ตรวจความถูกต้องของบัตรประชาชน
        $checkCustomerIdCard = $this->checkIdCard($customerIdCard);
        if ($checkCustomerIdCard == true) {
            //ตรวจว่าในข้อมูลมีรหัสซ้ำไหม ถ้าซ้ำคนนั้นลาออกไปหรือยัง ถ้ายังไม่ให้เพิ่ม
            $num = $this->crud_model->countWhere('customer', 'CUSTOMER_IDCARD', $customerIdCard);
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

        //ตรวจเบอร์ซ้ำ
        $allTel = '';
        for ($i = 0; $i < count($customerTel); $i++) {
            $allTel .= '\'';
            $allTel .= $customerTel[$i];
            $allTel .= '\'';
            if ($i != (count($customerTel) - 1)) {
                $allTel .= ',';
            }
        }
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
        //จบตรวจเบอร์

        //เพิ่มข้อมูล
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
            );
            $data['id'] = $customerID;
            $this->crud_model->insert('customer',$datacustomer);
            $i = 1;
            foreach($customerTel as $row){
                $dataCustomerTel = array(
                    'CUSTOMERTEL_ID' => $customerID,
                    'CUSTOMERTEL_TEL' => $row,
                    'CUSTOMERTEL_NO' => $i,
                );
                $this->crud_model->insert('customertel',$dataCustomerTel);
                $i++;
            }
            $data['url'] = site_url('admin/customer');
            $data['message'] = 'เพิ่มข้อมูลสมาชิกเสร็จสิ้น';
        }
        else{
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
            $no = substr($maxID, 9, 3);
            if ($odate != $ndate) {
                return 'CUS' . $ndate . $no;
            } else {
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

}
