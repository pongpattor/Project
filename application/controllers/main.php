<?php
defined('BASEPATH') or exit('No direct script access allowed');

class main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'productstore_view';
        $this->load->view('main', $data);
    }
    public function recommendProduct()
    {
    }
    public function hotSellProduct()
    {
    }
}
