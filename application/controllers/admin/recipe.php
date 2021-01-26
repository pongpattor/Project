<?php
defined('BASEPATH') or exit('No direct script access allowed');

class recipe extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        // if (empty($_SESSION['employeeLogin'])) {
        //     return redirect(site_url('admin/login'));
        // } else if ($_SESSION['employeePermission'][10] != 1) {
        //     echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
        //     return redirect(site_url('admin/admin/'));
        // }
        $this->load->model('crud_model');
        $this->load->model('recipe_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/recipe/index');
        $config['total_rows'] = $this->recipe_model->countAllRecipe($search);
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
        $data['recipe'] = $this->recipe_model->recipe($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'recipe_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addRecipe(){
        $data['product'] = $this->crud_model->find('product','PRODUCT_ID,PRODUCT_NAME');
        print_r($data);
    }
}
