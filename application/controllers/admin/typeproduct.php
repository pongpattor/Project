<?php
defined('BASEPATH') or exit('No direct script access allowed');

class typeproduct extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][5] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('product_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {

        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/typeproduct/index');
        $config['total_rows'] = $this->product_model->countAllTypeProduct($search);
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

        redirect(site_url('admin/typeproduct/'));
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
        $typeID = $this->input->post('typeProductId');
        $typeName = $this->input->post('typeProductName');
        $typeGroup = $this->input->post('typeProductGroup');

        $typeProductDetail = array(
            'TYPEPRODUCT_NAME' => $typeName,
            'TYPEPRODUCT_GROUP' => $typeGroup
        );

        $this->crud_model->update('typeproduct', $typeProductDetail, 'TYPEPRODUCT_ID', $typeID);
        redirect(site_url('admin/typeproduct/'));
    }

    public function deleteTypeProduct()
    {
        $id = $this->input->post('typeProductId');
        $this->crud_model->delete('typeproduct', 'TYPEPRODUCT_ID', $id);
    }
}
