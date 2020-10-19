<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][8] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('promotion_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/promotion/index');
        $config['total_rows'] = $this->promotion_model->CountAllPromotion($search);
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
        $data['promotion'] = $this->promotion_model->promotion($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        // echo '<pre>';
        // print_r($data['promotion']);
        // echo '</pre>';

        $data['page'] = 'promotion_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addPromotion()
    {
        $data['product'] = $this->promotion_model->promotionProduct();
        // echo '<pre>';
        // print_r($data['product']);
        // echo '</pre>';
        $data['page'] = 'promotion_add_view';
        $this->load->view('admin/main_view', $data);
    }


    public function insertPromotion()
    {
        $promotionName = $this->input->post('promotionName');
        $promotionDiscount = $this->input->post('promotionDiscount');
        $typePromotion = $this->input->post('typePromotion');
        $dateStart = $this->input->post('dateStart');
        $dateEnd = $this->input->post('dateEnd');
        $product = $this->input->post('product');
        $promotionID = $this->genPromotionID();
        $status = 0;
        // echo '<pre>';
        // print_r($this->input->post('product'));
        // echo '</pre>';
        $allProduct = $this->promotion_model->CountAllProduct();

        if ($product == null) {
            $amount = 0;
        } else {
            $amount =  count($product);
        }


        if ($allProduct ==  $amount) {
            $typePromotion = 0;
        }

        $datenow = date('Y-m-d');

        if ($datenow >=  $dateStart && $datenow <=  $dateEnd) {
            $status = 1;
        }

        $promotion_detail = array(
            'PROMOTION_ID' => $promotionID,
            'PROMOTION_NAME' => $promotionName,
            'PROMOTION_DISCOUNT_PERCENT' =>  $promotionDiscount,
            'PROMOTION_TYPE' =>  $typePromotion,
            'PROMOTION_START' =>  $dateStart,
            'PROMOTION_END' =>  $dateEnd,
            'PROMOTION_STATUS' =>  $status,
        );
        $this->crud_model->insert('promotion', $promotion_detail);

        if ($typePromotion == 1) {
            if ($amount != 0) {
                for ($i = 0; $i < count($product); $i++) {
                    $promotionDetail_product = array(
                        'DETAIL_PROMOTION_NUMBER' => $i,
                        'DETAIL_PROMOTION_PRODUCT' => $product[$i],
                        'DETAIL_PROMOTION_ID' =>  $promotionID,

                    );
                    $this->crud_model->insert('promotiondetail', $promotionDetail_product);
                }
            }
        }

        return redirect(site_url('admin/promotion/'));
    }

    public function genPromotionID()
    {
        $maxID = $this->crud_model->find('promotion', 'MAX(PROMOTION_ID) as cnt');
        $date =  date('Y') + 543;
        $Y =  substr($date, 2);
        $m = date('m');
        // echo $Y." : ".$m;
        if ($maxID['0']->cnt == null) {
            return 'PRO' . $Y . $m . '001';
        } else {
            $ID = substr($maxID['0']->cnt, 7);
            $ID++;
            while (strlen($ID) < 3) {
                $ID = '0' . $ID;
            }
            return 'PRO' . $Y . $m . $ID;
        }
    }

    public function editpromotion()
    {
        $productInPromotion = "";
        $i = 1;
        $promotionID = $this->input->get('promotionID');
        $data['promotion'] = $this->promotion_model->editProduct($promotionID);
        // print_r($data['promotion']);
        $data['productm'] = $this->promotion_model->productInPromotion($promotionID);
        $end = count($data['productm']);
        // echo $end;

        foreach ($data['productm'] as $row) {
            if ($i < $end) {
                $productInPromotion = $productInPromotion . "'" . $row->PRODUCT_ID . "'" . ",";
            } else {
                $productInPromotion = $productInPromotion . "'" . $row->PRODUCT_ID . "'";
            }
            $i++;
        }

        $data['product']  = $this->promotion_model->productNotInPromotion($productInPromotion);


        $data['page'] = 'promotion_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updatePromotion()
    {
        // print_r($this->input->post());
        $status = 0;
        $promotionName = $this->input->post('promotionName');
        $promotionDiscount = $this->input->post('promotionDiscount');
        $typePromotion = $this->input->post('typePromotion');
        $dateStart = $this->input->post('dateStart');
        $dateEnd = $this->input->post('dateEnd');
        $product = $this->input->post('product');
        $promotionID = $this->input->post('promotionID');
        // echo $promotionID . " : " . $promotionName . " : " . $promotionDiscount . " : " . $typePromotion . " : " . $dateStart . " : " . $dateEnd . " : ";
        // echo '<pre>';
        // print_r($product);
        // echo '</pre>';
        $allProduct = $this->promotion_model->CountAllProduct();
        if ($product == null) {
            $amount = 0;
        } else {
            $amount =  count($product);
        }
        if ($allProduct ==  $amount) {
            $typePromotion = 0;
        }
        // echo $typePromotion;
        $datenow = date('Y-m-d');
        if ($datenow >=  $dateStart && $datenow <=  $dateEnd) {
            $status = 1;
        }

        $promotionDetail = array(
            'PROMOTION_NAME' => $promotionName,
            'PROMOTION_DISCOUNT_PERCENT' =>  $promotionDiscount,
            'PROMOTION_TYPE' =>  $typePromotion,
            'PROMOTION_START' =>  $dateStart,
            'PROMOTION_END' =>  $dateEnd,
            'PROMOTION_STATUS' =>  $status,
        );
        $this->crud_model->update('promotion', $promotionDetail, 'PROMOTION_ID', $promotionID);
        $this->crud_model->delete('promotiondetail', 'DETAIL_PROMOTION_ID', $promotionID);

        if ($typePromotion == 1) {
            if ($amount != 0) {
                for ($i = 0; $i < count($product); $i++) {
                    $promotionDetail_product = array(
                        'DETAIL_PROMOTION_NUMBER' => $i,
                        'DETAIL_PROMOTION_PRODUCT' => $product[$i],
                        'DETAIL_PROMOTION_ID' =>  $promotionID,

                    );
                    $this->crud_model->insert('promotiondetail', $promotionDetail_product);
                }
            }
        }

        return redirect(site_url('admin/promotion/'));
    }

    public function deletePromotion()
    {
        $promotionID = $this->input->post('promotionID');
        $this->promotion_model->deletePromotion($promotionID);
    }
}
