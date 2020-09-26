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
        $this->load->model('crud_model');
        $this->load->model('employee_model');
        $this->load->model('receive_ingredient_model');
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

    public function test()
    {
        $data['hello'] = $this->employee_model->searchDepartment('30');
        print_r($data['hello']);
        // $data['page'] = 'Test';
        // $this->load->view('admin/main_view', $data);
    }
}
