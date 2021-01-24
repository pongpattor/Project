<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/admin/'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('employee_model');
    }

    public function index()
    {
        $this->load->view('admin/login_view');
    }


    public function userLogin()
    {
        $data['status'] = true;
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $check = $this->employee_model->checklogin($username, $password);
        if ($check == 1) {
            $data['employee'] = $this->employee_model->login($username, $password);
            if ($data['employee']['0']->POSITION_PERMISSION == NULL) {
                $data['employee']['0']->POSITION_PERMISSION =  '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0';
            }
            $permission = explode(',', $data['employee']['0']->POSITION_PERMISSION);
            $sessions = array(
                'employeeID' => $data['employee']['0']->EMPLOYEE_ID,
                'employeeName' =>  $data['employee']['0']->EMPLOYEE_FIRSTNAME . ' ' . $data['employee']['0']->EMPLOYEE_LASTNAME,
                'employeePermission' => $permission,
                'employeeLogin' => true,
            );
            $this->session->set_userdata($sessions);
            $data['url'] = site_url('admin/admin/');
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }
}
