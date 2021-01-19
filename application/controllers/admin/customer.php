<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('customer_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/customer/index');
        $config['total_rows'] = $this->customer_model->countAllCustomer($search);
        $config['per_page'] = 5;
        $config['reuse_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item ">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" >';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $limit = $config['per_page'];
        $offset = $this->uri->segment(4, 0);
        $this->pagination->initialize($config);
        $data['total'] = $config['total_rows'];
        $data['customer'] = $this->customer_model->Customer($search, $limit, $offset);
        if ($data['customer'] != null) {
            $arrCustomer = [];
            foreach ($data['customer'] as $row) {
                array_push($arrCustomer, $row->cusID);
            }
            $cusID = implode(",", $arrCustomer);

            $data['customertel'] = $this->customer_model->fetchCustomerTel($cusID);
        }
        // echo '<pre>';
        // print_r($data['customertel']);
        // echo '</pre>';
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'customer_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addCustomer(){
        $data['page'] = 'customer_add_view';
        $this->load->view('admin/main_view',$data);
    }
}
