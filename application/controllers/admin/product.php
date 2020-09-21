<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('product_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page'] = 'product_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addProduct()
    {
        $data['page'] = 'product_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function typeProduct()
    {

        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/product/typeProduct');
        $config['total_rows'] = $this->product_model->countAllProduct($search);
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
        $data['typeProduct'] = $this->product_model->typeProduct($search, $limit, $offset);
        $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        //print_r($data['typeProduct']);
        $data['page'] = 'typeproduct_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addTypeProduct()
    {
        $data['page'] = 'typeproduct_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertTypeProduct()
    {
        $typeProductDetail = array(
            'TYPEPRODUCT_ID'  => $this->genIdTypeProduct(),
            'TYPEPRODUCT_NAME' => $this->input->post('typeProductName'),
            'TYPEPRODUCT_GROUP' =>  $this->input->post('typeProductGroup'),
        );
        $this->db->insert('typeproduct', $typeProductDetail);

        redirect(site_url('admin/product/typeproduct'));
    }

    public function genIdTypeProduct()
    {
        $maxId = $this->product_model->maxTypeProductId();
        if ($maxId == '') {
            return 'TP001';
        } else {
            $maxId = substr($maxId, 2);
            $maxId++;
            while (strlen($maxId) < 3) {
                $maxId = '0' . $maxId;
            }
            return 'TP' . $maxId;
        }
    }

    public function checkTypeProductName()
    {
        $typeProductName = $this->input->post('typeProductName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $check = $this->product_model->checkTypeProductName($typeProductName, $typeProductGroup);
        if ($check > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function checkTypeProductNameUpdate()
    {
        $typeProductName = $this->input->post('typeProductName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $typeProductOldName = $this->input->post('typeProductOldName');
        if ($typeProductName  == $typeProductOldName) {
            echo 0;
        } else {
            $check = $this->product_model->checkTypeProductNameUpdate($typeProductName, $typeProductGroup);
            if ($check > 0) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function editTypeProduct()
    {
        $typeId = $this->input->get('typeProductId');
        $data['typeProduct'] = $this->product_model->editTypeProduct($typeId);
        // echo '<pre>';
        // print_r($data['typeProductId']);
        // echo'</pre>';
        $data['page'] = 'typeproduct_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateTypeProduct()
    {
        $typeId = $this->input->post('typeProductId');
        echo $typeId;
    }



    public function deleteTypeProduct()
    {
        $id = $this->input->post('typeProductId');
        $this->crud_model->delete('typeproduct', 'TYPEPRODUCT_ID', $id);
    }

    public function meat()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/product/meat');
        $config['total_rows'] = $this->product_model->countAllMeat($search);
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
        $data['meat'] = $this->product_model->meat($search, $limit, $offset);
        $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'meat_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data['meat']);
        // echo '</pre>';

    }

    public function addMeat()
    {
        $data['page'] =  'meat_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function genMeatID(){

        $maxId = $this->product_model->maxMeatID();
        if ($maxId == '') {
            return 'M001';
        } else {
            $maxId = substr($maxId, 1);
            $maxId++;
            while (strlen($maxId) < 3) {
                $maxId = '0' . $maxId;
            }
            return 'M' . $maxId;
        }
    }

    public function insertMeat()
    {
        $meatName =  $this->input->post('meatName');
        $meatDetail = array(
            'MEAT_ID' => $this->genMeatID(),
            'MEAT_NAME' => $meatName,
            'MEAT_STATUS' => 1,
        );
       $this->crud_model->insert('meat', $meatDetail);
        redirect(site_url('admin/product/meat'));
        
    }

    public function checkMeatName()
    {
        $meatName = $this->input->post('meatName');
        $check = $this->product_model->checkMeatName($meatName);
        if ($check != 0) {
            echo 1;
        }
        else{
            echo 0;
        }
    }

    public function editMeat(){
        $meatId = $this->input->get('meatID');
        $data['meat'] = $this->crud_model->findwhere('meat','MEAT_ID',$meatId);
        $data['page'] = 'meat_edit_view';
        $this->load->view('admin/main_view',$data);
    }
}
