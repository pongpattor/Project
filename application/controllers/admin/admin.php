<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if(empty($_SESSION['login'])){
            return redirect(site_url('admin/login'));
        }
        $this->load->model('data_model');
        $this->load->model('employee_model');
        $this->load->library('pagination');
    }

    
    public function home()
    {
        $data['page'] = 'home';
        $this->load->view('admin/main_view', $data);
    }


    public function logout(){
        $this->session->sess_destroy();
       redirect(site_url('admin/login'));
    }

    public function repassword(){
        $data['page'] = 'repassword';
        $this->load->view('admin/main_view',$data);
    }

    public function checkOldPass(){
    //    $oldpass = $this->input->post('oldpass');
       $empID = $this->input->post('empID');
       $pass = $this->employee_model->checkOldPass($empID);
        echo $pass;

    }

    public function repass(){
        $newPass = $this->input->post('newPass');
        $empID = $this->input->post('empID');
        $this->employee_model->rePassword($empID, $newPass);
        return redirect(site_url('admin/admin/home'));
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



}
