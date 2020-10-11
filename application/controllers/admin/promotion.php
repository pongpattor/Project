<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][8] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page'] = 'promotion_view' ;
        $this->load->view('admin/main_view', $data);
    }
}
