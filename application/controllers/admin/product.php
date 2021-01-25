<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (empty($_SESSION['login'])) {
        //     return redirect(site_url('admin/login'));
        // } else if ($_SESSION['permission'][4] != 1) {
        //     echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
        //     return redirect(site_url('admin/admin/home'));
        // }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('data_model');
        $this->load->model('product_model');
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
        if ($this->input->get('productActive')) {
            $productActive = $this->input->get('productActive');
        } else {
            $productActive = '1,2';
        }

        $config['base_url'] = site_url('admin/product/index');
        $config['total_rows'] = $this->product_model->countAllProduct($search, $productActive);
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
        $data['product'] = $this->product_model->product($search, $productActive, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        // print_r($data['product']);
        $data['page'] = 'product_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addProduct()
    {
        $data['page'] = 'product_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertProduct()
    {
        $data['status'] = true;
        $productName = $this->input->post('productName');
        $checkProductName =  $this->crud_model->countWhere('product', 'PRODUCT_NAME', $productName);
        //ตรวจชื่อซ้ำ
        if ($checkProductName != 0) {
            $data['status'] = false;
        }
        //เพิ่มข้อมูล
        if ($data['status'] == true) {
            $productID = $this->genProductID();
            $config = array();
            $config['upload_path']          =  './assets/image/product/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = '2000';
            $config['max_width']            = '3000';
            $config['max_height']           = '3000';
            $config['file_name']           = $productID;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('productImage')) {
                $data['img'] = $this->upload->data();
                $productType = $this->input->post('productType');
                $productCostPrice = $this->input->post('productCostPrice');
                $productSellPrice = $this->input->post('productSellPrice');
                $productImage = $data['img']['file_name'];
                $dataProduct = array(
                    'PRODUCT_ID' => $productID,
                    'PRODUCT_NAME' => $productName,
                    'PRODUCT_TYPEPRODUCT' => $productType,
                    'PRODUCT_COSTPRICE' => $productCostPrice,
                    'PRODUCT_SELLPRICE' => $productSellPrice,
                    'PRODUCT_IMAGE' => $productImage,
                    'PRODUCT_ACTIVE' => '1',
                    'PRODUCT_STATUS' => '1',
                );
                $this->crud_model->insert('product', $dataProduct);
                $data['url'] = site_url('admin/product');
            }
        } else {
            $data['productNameError'] = 'ชื่อนี้ได้ถูกใช้ไปแล้ว';
        }
        echo json_encode($data);
    }

    public function genProductID()
    {
        $maxId = $this->crud_model->maxID('product', 'PRODUCT_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'PD' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 2, 4);
            if ($ymID != $ym) {
                return 'PD' . $ym . '0001';
            } else {
                $id = substr($maxId, 6);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'PD' . $ymID . $id;
                return $id;
            }
        }
    }


    public function editProduct()
    {
        $productID = $this->input->get('productID');
        $data['product'] = $this->product_model->editProduct($productID);
        $typeProductGroup = $data['product']['0']->TYPEPRODUCT_GROUP;
        $data['typeProduct'] = $this->crud_model->findSelectWhere('typeproduct', 'TYPEPRODUCT_ID,TYPEPRODUCT_NAME', 'TYPEPRODUCT_GROUP', $typeProductGroup);
        $data['page'] = 'product_edit_view';
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $this->load->view('admin/main_view', $data);
    }




    public function updateProduct()
    {
        // $data['input'] =$this->input->post();
        // $data['image'] = $_FILES;
        $data['status'] = true;
        $productNameOld = $this->input->post('productNameOld');
        $productName = $this->input->post('productName');
        if (strtolower($productName) != strtolower($productNameOld)) {
            $checkProductName =  $this->crud_model->countWhere('product', 'PRODUCT_NAME', $productName);
            if ($checkProductName != 0) {
                $data['status'] = false;
            }
        }
        if ($data['status'] == true) {
            $productID = $this->input->post('productID');
            $productType = $this->input->post('productType');
            $productCostPrice = $this->input->post('productCostPrice');
            $productSellPrice = $this->input->post('productSellPrice');
            $productActive = $this->input->post('productActive');
            if (!empty($_FILES['productImage']['name'])) {
                $productImageOld = $this->input->post('productImageOld');
                unlink('./assets/image/product/' . $productImageOld);
                $config = array();
                $config['upload_path']          =  './assets/image/product/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = '2000';
                $config['max_width']            = '3000';
                $config['max_height']           = '3000';
                $config['file_name']            = $productID;
                $this->load->library('upload', $config);
                $this->upload->do_upload('productImage');
            }
            $dataProduct = array(
                'PRODUCT_NAME' => $productName,
                'PRODUCT_TYPEPRODUCT' => $productType,
                'PRODUCT_COSTPRICE' => $productCostPrice,
                'PRODUCT_SELLPRICE' => $productSellPrice,
                'PRODUCT_ACTIVE' => $productActive,
            );
            $this->crud_model->update('product', $dataProduct, 'PRODUCT_ID', $productID);
            $data['url'] = site_url('admin/product');
        }

        echo json_encode($data);
    }


    public function fetchTypeProduct()
    {
        $typeProductGroup = $this->input->post('typeProductGroup');
        $data['productType'] = $this->data_model->fetchTypeProduct($typeProductGroup);
        echo json_encode($data);
    }

    public function deleteProduct()
    {
        $productID = $this->input->post('productID');
        $dataProduct = array(
            'PRODUCT_STATUS' => '0',
        );
        $this->crud_model->update('product', $dataProduct, 'PRODUCT_ID', $productID);
    }

    //ตัดช่องว่าง
    // public function trimSpace($name)
    // {
    //     $newStr2 = mb_ereg_replace('[[:space:]]+', '', trim($name));
    //     return $newStr2;
    // }
}
