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
        //$data['page'] = 'main';
        $this->load->view('welcome_message');
    }
    public function test(){
        echo 'hello';
    }
}
