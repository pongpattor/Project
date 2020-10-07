<?php
defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][4] != 1) {
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
        $config['base_url'] = site_url('admin/product/index');
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
        $data['product'] = $this->product_model->product($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        // print_r($data['product']);
        $data['page'] = 'product_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addProduct()
    {
        $data['meat'] = $this->crud_model->find('meat', 'MEAT_ID,MEAT_NAME');
        $data['page'] = 'product_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function checkProductName()
    {
        $productName = $this->input->post('productName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $typeProductName = $this->input->post('typeProductName');
        $meatName = $this->input->post('meatName');

        $check = $this->product_model->checkProductName($productName, $typeProductGroup, $typeProductName, $meatName);
        echo $check;
    }

    public function insertProduct()
    {
        $productID = $this->genProductID();
        $config = array();
        $config['upload_path']          =  './assets/image/product/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = '2000';
        $config['max_width']            = '3000';
        $config['max_height']           = '3000';
        $config['file_name']           = $productID;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('imgProduct')) {
            echo '<script>';
            echo 'alert("กรุณาอัพโหลดรูป");';
            echo 'location.href= "' . site_url('admin/product/addProduct') . '"';
            echo '</script>';
        } else {
            $data['img'] = $this->upload->data();
            $typeProductGroup = $this->input->post('typeProductGroup');
            $productName = $this->input->post('productName');
            $productType = $this->input->post('typeProductName');
            $productCostPrice = $this->input->post('costPrice');
            $productSellPrice = $this->input->post('sellPrice');
            $productImgName = $data['img']['file_name'];

            $productDetail = array(
                'PRODUCT_ID' => $productID,
                'PRODUCT_NAME' =>  $productName,
                'PRODUCT_TYPE' => $productType,
                'PRODUCT_COSTPRICE' => $productCostPrice,
                'PRODUCT_SELLPRICE' => $productSellPrice,
                'PRODUCT_IMG' =>  $productImgName,
                'PRODUCT_STATUS' => 1,
            );
            $this->crud_model->insert('product', $productDetail);
            if ($typeProductGroup == 'อาหาร') {
                $foodDetail = array(
                    'PRODUCT_FOOD_ID' => $productID,
                    'MEAT_FOOD_ID' => $this->input->post('meatName'),
                );
                $this->crud_model->insert('food', $foodDetail);
            } else if ($typeProductGroup == 'เครื่องดื่ม') {
                $drinkDetail = array(
                    'PRODUCT_DRINK_ID' => $productID,
                );
                $this->crud_model->insert('drink', $drinkDetail);
            } else if ($typeProductGroup == 'ท็อปปิ้ง') {
                $ToppingDetail = array(
                    'PRODUCT_TOPPING_ID' => $productID,
                );
                $this->crud_model->insert('topping', $ToppingDetail);
            }

            redirect(site_url('admin/product/'));
        }
    }

    public function editProduct()
    {
        $productID = $this->input->get('productID');
        $data['product'] = $this->product_model->editProduct($productID);
        if ($data['product'] == null) {
            echo '<script>';
            echo 'alert("ไม่มีข้อมูลสินค้ารหัส ' . $productID . '");';
            echo 'location.href= "' . site_url('admin/product/') . '"';
            echo '</script>';
        } else {
            $typeProductGroup = $data['product']['0']->TYPEPRODUCT_GROUP;
            $data['typeproduct'] = $this->crud_model->findwhere('typeproduct', 'TYPEPRODUCT_GROUP', $typeProductGroup);
            $data['meat'] = $this->crud_model->find('meat', 'MEAT_ID,MEAT_NAME');
            $data['page'] = 'product_edit_view';
            // echo '<pre>';
            // print_r($data['product']);
            // echo '</pre>';
            $this->load->view('admin/main_view', $data);
        }
        // echo '<pre>';
        // print_r($data['product']);
        // echo '</pre>';
    }

    public function genProductID()
    {
        $maxId = $this->product_model->maxProductID();
        if ($maxId == '') {
            return 'PD0001';
        } else {
            $maxId = substr($maxId, 2);
            $maxId++;
            while (strlen($maxId) < 4) {
                $maxId = '0' . $maxId;
            }
            return 'PD' . $maxId;
        }
    }

    public function checkProductNameUpdate()
    {
        $productName = $this->input->post('productName');
        $typeProductGroup = $this->input->post('typeProductGroup');
        $typeProductName = $this->input->post('typeProductName');
        $meatName = $this->input->post('meatName');
        $oldName = $this->input->post('oldName');
        $oldTpGroup = $this->input->post('oldTpGroup');
        $oldType = $this->input->post('oldType');
        $oldMeat = $this->input->post('oldMeat');
        // echo $productName.$typeProductGroup.$typeProductName.$meatName."ค่าเก่า".$oldName.$oldTpGroup.$oldType.$oldMeat;
        if ($productName == $oldName && $typeProductGroup == $oldTpGroup && $typeProductName == $oldType && $meatName == $oldMeat) {
            echo 0;
        } else {
            $check = $this->product_model->checkProductName($productName, $typeProductGroup, $typeProductName, $meatName);
            echo $check;
        }
    }

    public function updateProduct()
    {
        // echo '<pre>';
        // print_r($this->input->post());
        // echo '</pre>';

        $productID = $this->input->post('productID');
        // echo $productID;
        $typeProductGroup = $this->input->post('typeProductGroup');
        $oldProductGroup = $this->input->post('oldTpGroup');
        if (empty($_FILES['imgProduct']['name'])) {
            $productDetail = array(
                'PRODUCT_NAME' => $this->input->post('productName'),
                'PRODUCT_TYPE' => $this->input->post('typeProductName'),
                'PRODUCT_COSTPRICE' => $this->input->post('costPrice'),
                'PRODUCT_SELLPRICE' => $this->input->post('sellPrice'),
            );
        } else {
            $config = array();
            $config['upload_path']          =  './assets/image/product/';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = '2000';
            $config['max_width']            = '3000';
            $config['max_height']           = '3000';
            $config['file_name']            = $productID;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('imgProduct')) {
                echo '<script>';
                echo 'alert("กรุณาอัพโหลดรูปเท่านั้น");';
                echo 'window.history.back();';
                echo '</script>';
            } else {
                $oldImg = $this->input->post('oldImg');
                unlink('./assets/image/product/' . $oldImg);
                $data['img'] = $this->upload->data();
                $productDetail = array(
                    'PRODUCT_NAME' => $this->input->post('productName'),
                    'PRODUCT_TYPE' => $this->input->post('typeProductName'),
                    'PRODUCT_COSTPRICE' => $this->input->post('costPrice'),
                    'PRODUCT_SELLPRICE' => $this->input->post('sellPrice'),
                    'PRODUCT_IMG' => $data['img']['file_name'],
                );
            }
        }

        $this->crud_model->update('product', $productDetail, 'PRODUCT_ID', $productID);


        if ($oldProductGroup == 'อาหาร') {
            $this->crud_model->delete('food', 'PRODUCT_FOOD_ID', $productID);
        } else if ($oldProductGroup == 'เครื่องดื่ม') {
            $this->crud_model->delete('drink', 'PRODUCT_DRINK_ID', $productID);
        } else if ($oldProductGroup == 'ท็อปปิ้ง') {
            $this->crud_model->delete('topping', 'PRODUCT_TOPPING_ID', $productID);
        }

        if ($typeProductGroup == 'อาหาร') {

            $foodDetail = array(
                'PRODUCT_FOOD_ID' => $productID,
                'MEAT_FOOD_ID' => $this->input->post('meatName'),
            );
            $this->crud_model->insert('food', $foodDetail);
        } else if ($typeProductGroup == 'เครื่องดื่ม') {
            $drinkDetail = array(
                'PRODUCT_DRINK_ID' => $productID,
            );
            $this->crud_model->insert('drink', $drinkDetail);
        } else if ($typeProductGroup == 'ท็อปปิ้ง') {
            $ToppingDetail = array(
                'PRODUCT_TOPPING_ID' => $productID,
            );
            $this->crud_model->insert('topping', $ToppingDetail);
        }
        // echo '<pre>';
        // print_r($productDetail);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($foodDetail);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($drinkDetail);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($ToppingDetail);
        // echo '</pre>';

        redirect(site_url('admin/product/'));
    }

    public function deleteProduct()
    {
        $productID = $this->input->post('productID');
        $productDetail = array(
            'PRODUCT_STATUS' => '0',
        );
        $this->crud_model->update('product', $productDetail, 'PRODUCT_ID', $productID);
    }


    public function fetchTypeProductName()
    {
        $typeProductGroup = $this->input->post('typeProductGroup');
        $data['TypeProductName'] = $this->product_model->fetch_typeProductName($typeProductGroup);
        echo $data['TypeProductName'];
    }
}
