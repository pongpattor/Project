<?php
defined('BASEPATH') or exit('No direct script access allowed');

class typeproduct extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][6] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('typeproduct_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
        } else {
            $search = '';
        }
        if ($this->input->get('typeProductGroup')) {
            $typeProductGroup = $this->input->get('typeProductGroup');
        } else {
            $typeProductGroup = '1,2';
        }
        $config['base_url'] = site_url('admin/typeproduct/index');
        $config['total_rows'] = $this->typeproduct_model->countAllTypeProduct($search, $typeProductGroup);
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
        $data['typeProduct'] = $this->typeproduct_model->typeProduct($search, $typeProductGroup, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['total'] = $config['total_rows'];
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

        $data['status'] = true;

        $typeProductName = $this->input->post('typeProductName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $check = $this->crud_model->count2Where('typeproduct', 'TYPEPRODUCT_NAME', $typeProductName, 'TYPEPRODUCT_GROUP', $typeProductGroup);
        if ($check == 0) {
            $typeProductID = $this->genIdTypeProduct();
            $dataTypeProduct = array(
                'TYPEPRODUCT_ID' => $typeProductID,
                'TYPEPRODUCT_NAME' => $typeProductName,
                'TYPEPRODUCT_GROUP' => $typeProductGroup,
            );
            $this->crud_model->insert('typeproduct', $dataTypeProduct);
            $data['url'] = site_url('admin/typeproduct');
        } else {
            $data['status'] = false;
        }

        echo json_encode($data);
    }

    public function genIdTypeProduct()
    {
        $maxID = $this->crud_model->maxID('typeproduct', 'TYPEPRODUCT_ID');
        $y = date('y');
        if ($maxID == '') {
            $id = 'TP' . $y . '0001';
            return $id;
        } else {
            $year = substr($maxID, 2, 2);
            if ($y != $year) {
                return 'TP' . $y . '0001';
            } else {
                $id = substr($maxID, 5);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                return 'TP' . $year . $id;
            }
        }
    }


    public function editTypeProduct()
    {
        $typeProductID = $this->input->get('typeProductID');
        $data['typeProduct'] = $this->crud_model->findwhere('typeproduct', 'TYPEPRODUCT_ID', $typeProductID);
        $data['page'] = 'typeproduct_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateTypeProduct()
    {
        $data['status'] = true;
        $typeProductID = $this->input->post('typeProductID');
        $typeProductName = $this->input->post('typeProductName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $typeProductNameOld = $this->input->post('typeProductNameOld');
        $typeProductGroupOld = $this->input->post('typeProductGroupOld');
        if (strtolower($typeProductName) == strtolower($typeProductNameOld) && $typeProductGroup == $typeProductGroupOld) {
            $dataTypeProduct = array(
                'TYPEPRODUCT_NAME' => $typeProductName,
                'TYPEPRODUCT_GROUP' => $typeProductGroup,
            );
        } else {
            $check = $this->crud_model->count2Where('typeproduct', 'TYPEPRODUCT_NAME', $typeProductName, 'TYPEPRODUCT_GROUP', $typeProductGroup);
            if ($check == 0) {
                $dataTypeProduct = array(
                    'TYPEPRODUCT_NAME' => $typeProductName,
                    'TYPEPRODUCT_GROUP' => $typeProductGroup,
                );
            } else {
                $data['status'] = false;
            }
        }

        if ($data['status'] == true) {
            $this->crud_model->update('typeproduct', $dataTypeProduct, 'TYPEPRODUCT_ID', $typeProductID);
            $data['url'] = site_url('admin/typeproduct');
        }
        echo json_encode($data);
    }

    public function deleteTypeProduct()
    {
        $typeProductID = $this->input->post('typeProductID');
        $this->crud_model->delete('typeproduct', 'TYPEPRODUCT_ID', $typeProductID);
    }
}
