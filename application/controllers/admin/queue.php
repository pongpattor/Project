<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('recipe_model');
        $this->load->library('pagination');
    }

    public function index(){
        $data['page'] = 'queue_view';
        $this->load->view('admin/servicemain_view',$data);
    }
}
