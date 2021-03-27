<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('service_model');
        $this->load->library('pagination');
    }

    public function index()
    {
    }

    public function storefont()
    {
        $data['deskEmpty'] = $this->service_model->deskEmpty();
        $data['karaokeEmpty'] = $this->service_model->karaokeEmpty();
        $data['zone'] = $this->crud_model->findSelectWhere('zone','ZONE_ID,ZONE_NAME','ZONE_STATUS','1');


        $data['page'] = 'storefont_view';
        $this->load->view('admin/servicemain_view', $data);
    }
}
