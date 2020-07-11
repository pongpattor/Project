<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('crud_model');

    }

    public function index(){
        $this->load->view('admin/adminlogin');
    }

    public function dashboard(){
        $data['page'] = 'dashboard_view';
        $this->load->view('admin/main_view',$data);
    }

    public function customer(){
        $data['customer'] = $this->customer_model->findall('customer');
        $data['page'] = 'customer_view';
        $this->load->view('admin/main_view',$data);
    }

    public function employee(){
        $data['employee'] = $this->crud_model->findall('employee');
        $data['page'] = 'employee_view';
        $this->load->view('admin/main_view',$data);
    }

    public function addEmployee(){
        $this->load->model('dependent_model');
        $this->load->model('crud_model');
        $data['page'] = 'add_employee_view';
        $data['province'] = $this->dependent_model->fetch_province();
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view',$data);
    }

    
}
