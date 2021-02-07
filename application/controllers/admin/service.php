<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');

    }

    public function index(){
        $data['page'] = 'home';
        $this->load->view('admin/servicemain_view',$data);
    }

}