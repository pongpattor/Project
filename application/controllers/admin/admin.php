<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if(empty($_SESSION['employeeLogin'])){
            return redirect(site_url('admin/login'));
        }
        $this->load->model('crud_model');
        $this->load->model('data_model');
        $this->load->library('pagination');
    }

    
    public function index()
    {
        $data['page'] = 'home';
        $this->load->view('admin/main_view', $data);
    }


    public function logout(){
        $this->session->sess_destroy();
       redirect(site_url('admin/login'));
    }

    public function changePassword(){
        $data['page'] = 'changepassword_view';
        $this->load->view('admin/main_view',$data);
    }


    public function rePassword(){
        $data['status'] = true;
        $passwordOld = $this->input->post('passwordOld');
        $check = $this->crud_model->count2Where('employee','EMPLOYEE_ID',$_SESSION['employeeID'],'EMPLOYEE_PASSWORD',$passwordOld);
        if($check==1){
            $passwordNew = $this->input->post('passwordNew');
            $this->crud_model->updateStatus('employee','EMPLOYEE_PASSWORD',$passwordNew,'EMPLOYEE_ID',$_SESSION['employeeID']);
            $data['url'] = site_url('admin/admin');
        }
        else{
            $data['status'] = false;
        }
        echo json_encode($data);
    }


    public function fetchAmphur()
    {
        $provinceID = $this->input->post('provinceID');
        $data['amphur'] = $this->data_model->fetchAmphur($provinceID);
        echo json_encode($data);
    }

    public function fetchDistrict()
    {
        $amphurID = $this->input->post("amphurID");
        $data['district'] = $this->data_model->fetchDistrict($amphurID);
        echo json_encode($data);
    }

    public function fetchPostcode()
    {
        $districtID = $this->input->post("districtID");
        $data['postcode'] = $this->data_model->fetchPostcode($districtID);
        echo json_encode($data);
    }

    
    public function fetchPosition(){
        $departmentID = $this->input->post('departmentID');
        $data['position'] = $this->data_model->fetchPosition($departmentID);
        echo json_encode($data);
    }

    public function test(){
        echo '<pre>';
        print_r($_SESSION['employeePermission']);
        echo '</pre>';
    }
}
