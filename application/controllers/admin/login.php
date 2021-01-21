<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if (isset($_SESSION['login'])) {
        //     return redirect(site_url('admin/admin/home'));
        // }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('employee_model');
    }

    public function index()
    {
        $this->load->view('admin/login');
    }


    public function Login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $check = $this->employee_model->checklogin($username, $password);
        if ($check == 1) {
            $data['user'] = $this->employee_model->login($username, $password);
            if ($data['user']['0']->PERMISSION == NULL) {
                $data['user']['0']->PERMISSION =  '0,0,0,0,0,0,0,0,0,0,0,0,0';
                // echo    $data['user']['0']->PERMISSION;
            }
            $permission = explode(',', $data['user']['0']->PERMISSION);
            $sessions = array(
                'EmpID' => $data['user']['0']->ID,
                'Empname' =>  $data['user']['0']->FIRSTNAME . ' ' . $data['user']['0']->LASTNAME,
                'permission' => $permission,
                'login' => TRUE
            );
            // echo '<pre>';
            // print_r(  $data['user']);
            // echo '</pre>';
            $this->session->set_userdata($sessions);
            redirect(site_url('admin/admin/home'));
        } else {
            echo '<script>';
            echo 'alert("กรุณา Username หรือ Password ให้ถูกต้อง");';
            echo 'location.href= "' . site_url('admin/login/') . '"';
            echo '</script>';
        }
    }

    // หน้าLogin อีกแบบ
    // public function testlogin(){
    //     $this->load->view('admin/testlogin');
    // }
}
