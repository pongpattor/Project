<?php
defined('BASEPATH') or exit('No direct script access allowed');

class test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');

    }

    public function index(){
        // $data['page'] = 'test_view';
        $this->load->view('admin/test_view');
        // echo 'hello';
    }

}