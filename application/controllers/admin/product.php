<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
    }

    public function product(){
        $data['page'] = 'product_view';
        $this->load->view('admin/admin/main_view',$data);
    }
}
