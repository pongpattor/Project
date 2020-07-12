<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->library('form_validation');
    }

    public function signup()
    {
        $this->load->model('base_data_model');
        $data['page'] = "signup";
        $data['province'] = $this->base_data_model->fetch_province();
        $this->load->view('main', $data);
    }

    public function register()
    {
        $md5_password =  md5($this->input->post('password'));
        $this->load->model('customer_model');
        $customer_detail = array(
            'USERNAME' => $this->input->post('username'),
            'PASSWORD' => $md5_password,
            'GENDER' => $this->input->post('gender'),
            'FIRSTNAME' => $this->input->post('firstname'),
            'LASTNAME' => $this->input->post('lastname'),
            'EMAIL' => $this->input->post('email'),
            'TEL' => $this->input->post('tel'),
            'DATE' => $this->input->post('date'),
            'PROVINCE' => $this->input->post('province'),
            'AMPHUR' => $this->input->post('amphur'),
            'DISTRICT' => $this->input->post('district'),
            'POSTCODE' => $this->input->post('postcode'),
            'CREATE_AT' => date('Y-m-d H:i:s')
        );
       $data['count'] = $this->customer_model->check_user($customer_detail['USERNAME']);
       if($data['count']>0){
           echo "<script>alert('ไอดีนี้ถูกใช้ไปแล้ว');</script>";
           echo "<script>window.history.back();</script>";
       }
       else{
           $this->customer_model->insert('customer',$customer_detail);
           redirect(site_url());
       }
    }

    public function amphur()
    {
        $this->load->model('base_data_model');
        $province_id = $this->input->post('PROVINCE_ID');
        $data['amphur'] = $this->base_data_model->fetch_amphur($province_id);
        echo $data['amphur'];
    }

    public function district()
    {
        $this->load->model('base_data_model');
        $amphur_id = $this->input->post("AMPHUR_ID");
        $data['district'] = $this->base_data_model->fetch_district($amphur_id);
        echo $data['district'];
    }
    public function postcode()
    {
        $this->load->model('base_data_model');
        $district_id = $this->input->post("DISTRICT_ID");
        $data['postcode'] = $this->base_data_model->fetch_postcode($district_id);
        echo $data['postcode'];
    }

    public function department()
    {
        $this->load->model('base_data_model');
        $department_id = $this->input->post('DEPARTMENT_ID');
        $data['department'] = $this->base_data_model->fetch_position($department_id);
        echo $data['department'];
    }

    public function test($username="")
    {
        $this->load->model('customer_model');
        $data['count'] = $this->customer_model->check_user('customer',$username);
        print_r($data['count']);
    }

    public function datetime()
    {
    }
}
