<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotionprice extends CI_Controller
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
        $this->load->model('promotionprice_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }
    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/promotionprice/index');
        $config['total_rows'] = $this->promotionprice_model->countAllPromotionPrice($search);
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
        $data['promotionPrice'] = $this->promotionprice_model->promotionPrice($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'promotionprice_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addPromotionPrice()
    {
        $data['product'] = $this->crud_model->findselectWhere('product', 'PRODUCT_ID,PRODUCT_NAME', 'PRODUCT_STATUS', '1');
        $data['page'] = 'promotionprice_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertPromotionPrice()
    {
        $data['input'] = $_POST;
        $data['status'] = true;
        $promotionPriceName  = $this->input->post('promotionPriceName');
        $promotionPriceDateStart = $this->input->post('promotionPriceDateStart');
        $promotionPriceDateEnd = $this->input->post('promotionPriceDateEnd');
        $promotionPriceProductID   = $this->input->post('promotionPriceProductID');
        $checkPromotionPriceName = $this->crud_model->count2Where('promotionprice', 'PROMOTIONPRICE_NAME', $promotionPriceName, 'PROMOTIONPRICE_STATUS', '1');
        if ($checkPromotionPriceName != 0) {
            $data['status'] = false;
            $data['sameProname'] = '';
        } else {
            $data['sameProname'] = 'ชื่อโปรโมชั่นซ้ำ';
        }
        $i = 0;
        $productID = '';
        foreach ($promotionPriceProductID as $row) {
            $productID .=  "'$row'";
            if ($i < (count($promotionPriceProductID) - 1)) {
                $productID .= ',';
            }
            $i++;
        }
        $productActivePro = $this->promotionprice_model->checkProduct($promotionPriceDateStart, $promotionPriceDateEnd, $productID);
        if ($productActivePro != null) {
            $j = 0;
            $productName = '';
            foreach ($productActivePro as $row2) {
                $productName .=  $row2->PRODUCT_NAME;
                if ($j < (count($productActivePro) - 1)) {
                    $productName .= ',';
                }
                $j++;
            }
            $productName .= ' ถูกใช้ในโปรโมชั่นอื่นในช่วงเวลานี้แล้ว';
            $data['status'] = false;
            $data['productActivePro'] = $productName;
        } else {
            $data['productActivePro'] = '';
        }
        if ($data['status'] == true) {
            $promotionPriceID = $this->genIdPromotionPrice();
            $promotionPriceDiscount = $this->input->post('promotionPriceDiscount');
            $dataPromotionPrice = array(
                'PROMOTIONPRICE_ID' => $promotionPriceID,
                'PROMOTIONPRICE_NAME' => $promotionPriceName,
                'PROMOTIONPRICE_DISCOUNT' => $promotionPriceDiscount,
                'PROMOTIONPRICE_DATESTART' => $promotionPriceDateStart,
                'PROMOTIONPRICE_DATEEND' => $promotionPriceDateEnd,
                'PROMOTIONPRICE_STATUS' => '1',

            );
            $this->crud_model->insert('promotionprice', $dataPromotionPrice);
            for ($i = 0; $i < count($promotionPriceProductID); $i++) {
                $dataPromotionPriceDetail = array(
                    'PROPRICE_ID' => $promotionPriceID,
                    'PROPRICE_NO' => ($i + 1),
                    'PROPRICE_PRODUCT' => $promotionPriceProductID[$i],
                );
                $this->crud_model->insert('promotionpricedetail', $dataPromotionPriceDetail);
            }
            $data['url'] = site_url('admin/promotionprice/');
        }
        echo json_encode($data);
    }

    public function genIdPromotionPrice()
    {
        $maxId = $this->crud_model->maxID('promotionprice', 'PROMOTIONPRICE_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'PROP' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 4, 4);
            if ($ymID != $ym) {
                return 'PROP' . $ym . '0001';
            } else {
                $id = substr($maxId, 8);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'PROP' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editPromotionPrice()
    {
        $promotionPriceID = $this->input->get('promotionPriceID');
        $data['promotionprice'] = $this->crud_model->findselectWhere('promotionprice', 'PROMOTIONPRICE_ID,PROMOTIONPRICE_NAME,PROMOTIONPRICE_DISCOUNT,
                                                                    PROMOTIONPRICE_DATESTART,PROMOTIONPRICE_DATEEND', 'PROMOTIONPRICE_ID', $promotionPriceID);
        $data['propricedetail'] = $this->promotionprice_model->editPromotionPriceDetail($promotionPriceID);
        $data['product'] = $this->crud_model->findselectWhere('product', 'PRODUCT_ID,PRODUCT_NAME', 'PRODUCT_STATUS', '1');
        $data['page'] = 'promotionprice_edit_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    }

    public function updatePromotionPrice()
    {
        // $data['input'] = $_POST;
        $data['status'] = true;
        $promotionPriceName  = $this->input->post('promotionPriceName');
        $promotionPriceNameOld  = $this->input->post('promotionPriceNameOld');
        if (strtolower($promotionPriceName) != strtolower($promotionPriceNameOld)) {
            $checkPromotionPriceName = $this->crud_model->count2Where('promotionprice', 'PROMOTIONPRICE_NAME', $promotionPriceName, 'PROMOTIONPRICE_STATUS', '1');
            if ($checkPromotionPriceName != 0) {
                $data['status'] = false;
                $data['sameProname'] = '';
            } else {
                $data['sameProname'] = 'ชื่อโปรโมชั่นซ้ำ';
            }
        }
        $promotionPriceDateStart = $this->input->post('promotionPriceDateStart');
        $promotionPriceDateEnd = $this->input->post('promotionPriceDateEnd');
        $promotionPriceProductID   = $this->input->post('promotionPriceProductID');
        $i = 0;
        $productID = '';
        foreach ($promotionPriceProductID as $row) {
            $productID .=  "'$row'";
            if ($i < (count($promotionPriceProductID) - 1)) {
                $productID .= ',';
            }
            $i++;
        }
        $productActivePro = $this->promotionprice_model->checkProduct($promotionPriceDateStart, $promotionPriceDateEnd, $productID);
        if ($productActivePro != null) {
            $j = 0;
            $productName = '';
            foreach ($productActivePro as $row2) {
                $productName .=  $row2->PRODUCT_NAME;
                if ($j < (count($productActivePro) - 1)) {
                    $productName .= ',';
                }
                $j++;
            }
            $productName .= ' ถูกใช้ในโปรโมชั่นอื่นในช่วงเวลานี้แล้ว';
            $data['status'] = false;
            $data['productActivePro'] = $productName;
        } else {
            $data['productActivePro'] = '';
        }
        if ($data['status'] == true) {
            $promotionPriceID = $this->input->post('promotionPriceID');
            $promotionPriceDiscount = $this->input->post('promotionPriceDiscount');

            $dataPromotionPrice = array(
                'PROMOTIONPRICE_NAME' => $promotionPriceName,
                'PROMOTIONPRICE_DISCOUNT' => $promotionPriceDiscount,
                'PROMOTIONPRICE_DATESTART' => $promotionPriceDateStart,
                'PROMOTIONPRICE_DATEEND' => $promotionPriceDateEnd,

            );
            $this->crud_model->update('promotionprice', $dataPromotionPrice, 'PROMOTIONPRICE_ID', $promotionPriceID);
            $this->crud_model->delete('promotionpricedetail', 'PROPRICE_ID', $promotionPriceID);
            for ($i = 0; $i < count($promotionPriceProductID); $i++) {
                $dataPromotionPriceDetail = array(
                    'PROPRICE_ID' => $promotionPriceID,
                    'PROPRICE_NO' => ($i + 1),
                    'PROPRICE_PRODUCT' => $promotionPriceProductID[$i],
                );
                $this->crud_model->insert('promotionpricedetail', $dataPromotionPriceDetail);
            }
            $data['url'] = site_url('admin/promotionprice/');
        }

        echo json_encode($data);
    }

    public function deletePromotionPrice()
    {
        $promotionPriceID = $this->input->post('promotionPriceID');
        $dataPromotionPrice = array(
            'PROMOTIONPRICE_STATUS' => '0',
        );
        $this->crud_model->update('promotionprice', $dataPromotionPrice, 'PROMOTIONPRICE_ID', $promotionPriceID);
    }
}
