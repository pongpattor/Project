<?php
defined('BASEPATH') or exit('No direct script access allowed');

class promotionset extends CI_Controller
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
        $this->load->model('promotionset_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/promotionset/index');
        $config['total_rows'] = $this->promotionset_model->countAllPromotionSet($search);
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
        $data['promotionset'] = $this->promotionset_model->promotionSet($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'promotionset_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addPromotionSet()
    {
        $data['page'] = 'promotionset_add_view';
        $data['product'] = $this->crud_model->findselectWhere('product', 'PRODUCT_ID,PRODUCT_NAME,PRODUCT_COSTPRICE,PRODUCT_SELLPRICE', 'PRODUCT_STATUS', '1');
        $this->load->view('admin/main_view', $data);
        // print_r($data);
    }

    public function insertPromotionSet()
    {
        $data['input'] = $_POST;
        $data['status'] = true;
        $promotionSetName  = $this->input->post('promotionSetName');
        $checkPromotionSetName = $this->crud_model->countWhere('promotionset', 'PROMOTIONSET_NAME', $promotionSetName);
        if ($checkPromotionSetName != 0) {
            $data['status'] = false;
        }

        if ($data['status'] == true) {
            // $promotionSetCost = $this->input->post('promotionSetCost');
            $promotionSetID = $this->genIdPromotionSet();
            $promotionSetPrice = $this->input->post('promotionSetPrice');
            $promotionSetDateStart = $this->input->post('promotionSetDateStart');
            $promotionSetDateEnd = $this->input->post('promotionSetDateEnd');
            $promotionSetProduct = $this->input->post('promotionSetProduct');
            $promotionSetAmount = $this->input->post('promotionSetAmount');
            $dataPromotionSet = array(
                'PROMOTIONSET_ID' => $promotionSetID,
                'PROMOTIONSET_NAME' => $promotionSetName,
                'PROMOTIONSET_PRICE' => $promotionSetPrice,
                'PROMOTIONSET_DATESTART' => $promotionSetDateStart,
                'PROMOTIONSET_DATEEND' => $promotionSetDateEnd,
                'PROMOTIONSET_STATUS' => '1',

            );
            $this->crud_model->insert('promotionSet', $dataPromotionSet);
            for ($i = 0; $i < count($promotionSetProduct); $i++) {
                $dataPromotionSetDetail = array(
                    'PROSETDETAIL_ID' => $promotionSetID,
                    'PROSETDETAIL_NO' => ($i + 1),
                    'PROSETDETAIL_PRODUCT' => $promotionSetProduct[$i],
                    'PROSETDETAIL_AMOUNT' => $promotionSetAmount[$i],
                );
                $this->crud_model->insert('promotionsetdetail', $dataPromotionSetDetail);
            }
            $data['url'] = site_url('admin/promotionset/');
        }
        echo json_encode($data);
    }

    public function genIdPromotionSet()
    {
        $maxId = $this->crud_model->maxID('promotionset', 'PROMOTIONSET_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'PROS' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 4, 4);
            if ($ymID != $ym) {
                return 'PROS' . $ym . '0001';
            } else {
                $id = substr($maxId, 8);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'PROS' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editPromotionSet()
    {
        $promotionSetID = $this->input->get('promotionSetID');
        $data['product'] = $this->crud_model->findselectWhere('product', 'PRODUCT_ID,PRODUCT_NAME,PRODUCT_COSTPRICE,PRODUCT_SELLPRICE', 'PRODUCT_STATUS', '1');
        $data['promotionset'] = $this->promotionset_model->editPromotionSet($promotionSetID);
        $data['promotionsetdetail'] = $this->promotionset_model->editPromotionSetDetail($promotionSetID);
        $data['page'] = 'promotionset_edit_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data['promotionsetdetail']);
        // echo '</pre>';

    }
    public function updatePromotionSet()
    {
        $data['status'] = true;
        $promotionSetName  = $this->input->post('promotionSetName');
        $promotionSetNameOld  = $this->input->post('promotionSetNameOld');
        if (strtolower($promotionSetName) != strtolower($promotionSetNameOld)) {
            $checkPromotionSetName = $this->crud_model->countWhere('promotionset', 'PROMOTIONSET_NAME', $promotionSetName);
            if ($checkPromotionSetName != 0) {
                $data['status'] = false;
            }
        }

        if ($data['status'] == true) {
            $promotionSetID = $this->input->post('promotionSetID');
            $promotionSetPrice = $this->input->post('promotionSetPrice');
            $promotionSetDateStart = $this->input->post('promotionSetDateStart');
            $promotionSetDateEnd = $this->input->post('promotionSetDateEnd');
            $promotionSetProduct = $this->input->post('promotionSetProduct');
            $promotionSetAmount = $this->input->post('promotionSetAmount');
            $dataPromotionSet = array(
                'PROMOTIONSET_NAME' => $promotionSetName,
                'PROMOTIONSET_PRICE' => $promotionSetPrice,
                'PROMOTIONSET_DATESTART' => $promotionSetDateStart,
                'PROMOTIONSET_DATEEND' => $promotionSetDateEnd,
            );
            $this->crud_model->update('promotionset', $dataPromotionSet, 'PROMOTIONSET_ID', $promotionSetID);
            $this->crud_model->delete('promotionsetdetail', 'PROSETDETAIL_ID', $promotionSetID);
            for ($i = 0; $i < count($promotionSetProduct); $i++) {
                $dataPromotionSetDetail = array(
                    'PROSETDETAIL_ID' => $promotionSetID,
                    'PROSETDETAIL_NO' => ($i + 1),
                    'PROSETDETAIL_PRODUCT' => $promotionSetProduct[$i],
                    'PROSETDETAIL_AMOUNT' => $promotionSetAmount[$i],
                );
                $this->crud_model->insert('promotionsetdetail', $dataPromotionSetDetail);
            }
            $data['url'] = site_url('admin/promotionset/');
        }
        echo json_encode($data);
    }

    public function deletePromotionSet(){
        $promotionSetID = $this->input->post('promotionSetID');
        $dataPromotionSet = array(
            'PROMOTIONSET_STATUS' => '0',
        );
        $this->crud_model->update('promotionset', $dataPromotionSet, 'PROMOTIONSET_ID', $promotionSetID);
    }
}
