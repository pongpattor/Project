<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kitchen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][17] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            echo '<script>window.history.back();</script>';
        }
        $this->load->model('crud_model');
        $this->load->model('kitchen_model');
        $this->load->library('pagination');

    }

    public function kitchenFood()
    {
        $data['food'] = $this->kitchen_model->kitchen('1');
        $data['foodsame'] = $this->kitchen_model->kitchenSame('1');
        $data['foodsameIdNo'] = $this->kitchen_model->kitchenSameIdNo('1');
        $data['page'] = 'kitchenfood_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function kitchenDrink()
    {
        $data['drink'] = $this->kitchen_model->kitchen('2');
        $data['drinksame'] = $this->kitchen_model->kitchenSame('2');
        $data['drinksameIdNo'] = $this->kitchen_model->kitchenSameIdNo('2');
        $data['page'] = 'kitchendrink_view';
        $this->load->view('admin/servicemain_view', $data);
    }


    public function cook()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $productID = $this->input->post('productID');
        $serviceTypeOrder = $this->input->post('serviceTypeOrder');
        if ($serviceTypeOrder == '1') {
            $this->kitchen_model->updateDetailFoodDrink($serviceID, $serviceNO, '1');
        } else {
            $dataKeySameOrder = $this->kitchen_model->findKeySameOrder($serviceID, $serviceNO, $productID);
            foreach ($dataKeySameOrder as $rowSameOrder) {
                $this->kitchen_model->updateDetailProset($rowSameOrder->DTSER_ID, $rowSameOrder->DTSER_NO, $rowSameOrder->DPRODTSER_DETAILNO, '1');
            }
            $dataCheckStatusProset = $this->kitchen_model->checkStatusProset($serviceID, $serviceNO);
            foreach ($dataCheckStatusProset as $rowStatusProset) {
                if ($rowStatusProset->CNT > 0) {
                    $this->kitchen_model->updateServiceDetailProset($serviceID, $serviceNO);
                }
            }
        }
    }

    public function served()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $productID = $this->input->post('productID');
        $serviceTypeOrder = $this->input->post('serviceTypeOrder');

        if ($serviceTypeOrder == '1') {
            $this->kitchen_model->updateDetailFoodDrink($serviceID, $serviceNO, '2');
        } else {
            $dataKeySameOrder = $this->kitchen_model->findKeySameOrder($serviceID, $serviceNO, $productID);
            foreach ($dataKeySameOrder as $rowSameOrder) {
                $this->kitchen_model->updateDetailProset($rowSameOrder->DTSER_ID, $rowSameOrder->DTSER_NO, $rowSameOrder->DPRODTSER_DETAILNO, '2');
            }
            $dataCheckStatusProset = $this->kitchen_model->checkStatusProset($serviceID, $serviceNO);
            foreach ($dataCheckStatusProset as $rowStatusProset) {
                if ($rowStatusProset->CNT > 0) {
                    $this->kitchen_model->updateServiceDetailProset($serviceID, $serviceNO);
                }
            }
        }
    }

    public function cookSameService()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $productID = $this->input->post('productID');
        // $serviceDate = $this->input->post('serviceDate');
        // $serviceTime = $this->input->post('serviceTime');
        $serviceID = substr($serviceID, 0, strlen($serviceID) - 1);
        $serviceNO = substr($serviceNO, 0, strlen($serviceNO) - 1);
        // $serviceDate = substr($serviceDate, 0, strlen($serviceDate) - 1);
        // $serviceTime = substr($serviceTime, 0, strlen($serviceTime) - 1);
        $serviceID = explode(',', $serviceID);
        $serviceNO = explode(',', $serviceNO);
        // $serviceDate = explode(',', $serviceDate);
        // $serviceTime = explode(',', $serviceTime);
        for ($i = 0; $i < count($serviceID); $i++) {
            $typeOrder = $this->kitchen_model->checkSameTypeOrder($serviceID[$i], $serviceNO[$i]);
            if ($typeOrder == 1) {
                $this->kitchen_model->updateDetailFoodDrink($serviceID[$i], $serviceNO[$i], '1');
            } else {
                $dataKeySameOrder = $this->kitchen_model->findKeySameOrder($serviceID[$i], $serviceNO[$i], $productID);
                foreach ($dataKeySameOrder as $rowSameOrder) {
                    $this->kitchen_model->updateDetailProset($rowSameOrder->DTSER_ID, $rowSameOrder->DTSER_NO, $rowSameOrder->DPRODTSER_DETAILNO, '1');
                }
                $dataCheckStatusProset = $this->kitchen_model->checkStatusProset($serviceID[$i], $serviceNO[$i]);
                foreach ($dataCheckStatusProset as $rowStatusProset) {
                    if ($rowStatusProset->CNT > 0) {
                        $this->kitchen_model->updateServiceDetailProset($serviceID[$i], $serviceNO[$i]);
                    }
                }
            }
        }
    }

    public function cookCallServed()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $productID = $this->input->post('productID');
        // $serviceDate = $this->input->post('serviceDate');
        // $serviceTime = $this->input->post('serviceTime');
        $serviceID = substr($serviceID, 0, strlen($serviceID) - 1);
        $serviceNO = substr($serviceNO, 0, strlen($serviceNO) - 1);
        // $serviceDate = substr($serviceDate, 0, strlen($serviceDate) - 1);
        // $serviceTime = substr($serviceTime, 0, strlen($serviceTime) - 1);
        $serviceID = explode(',', $serviceID);
        $serviceNO = explode(',', $serviceNO);
        // $serviceDate = explode(',', $serviceDate);
        // $serviceTime = explode(',', $serviceTime);
        for ($i = 0; $i < count($serviceID); $i++) {
            $typeOrder = $this->kitchen_model->checkSameTypeOrder($serviceID[$i], $serviceNO[$i]);
            if ($typeOrder == 1) {
                $this->kitchen_model->updateDetailFoodDrink($serviceID[$i], $serviceNO[$i], '2');
            } else {
                $dataKeySameOrder = $this->kitchen_model->findKeySameOrder($serviceID[$i], $serviceNO[$i], $productID);
                foreach ($dataKeySameOrder as $rowSameOrder) {
                    $this->kitchen_model->updateDetailProset($rowSameOrder->DTSER_ID, $rowSameOrder->DTSER_NO, $rowSameOrder->DPRODTSER_DETAILNO, '2');
                }
            }
        }
    }

    public function changeIngredient()
    {
        $search = $this->input->get('search');

        $config['base_url'] = site_url('admin/kitchen/changeIngredient');
        $config['total_rows'] = $this->kitchen_model->countAllIngredient($search);
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
        $data['ingredient'] = $this->kitchen_model->ingredient($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['title'] = 'วัตถุดิบ';
        $data['page'] = 'kitcheningredient_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function changeIngredientDrink()
    {
        $search = $this->input->get('search');

        $config['base_url'] = site_url('admin/kitchen/changeIngredientDrink');
        $config['total_rows'] = $this->kitchen_model->countAllDrink($search);
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
        $data['drink'] = $this->kitchen_model->drink($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['title'] = 'เครื่องดื่ม';
        $data['page'] = 'kitcheningredientdrink_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function haveIngredient(){
        $ingredientID = $this->input->post('ingredientID');
        $dataIngredient = array(
            'INGREDIENT_ACTIVE' => '1',
        );
        $this->crud_model->update('ingredient',$dataIngredient,'INGREDIENT_ID',$ingredientID);
        $this->kitchen_model->changeStatusProduct($ingredientID);
    }

    public function haventIngredient(){
        $ingredientID = $this->input->post('ingredientID');
        $dataIngredient = array(
            'INGREDIENT_ACTIVE' => '2',
        );
        $this->crud_model->update('ingredient',$dataIngredient,'INGREDIENT_ID',$ingredientID);
        $this->kitchen_model->ingredientFood($ingredientID);
    }

    public function haventDrink(){
        $productID = $this->input->post('productID');
        $dataProduct = array(
            'PRODUCT_ACTIVE' => '2'
        );
        $this->crud_model->update('product',$dataProduct,'PRODUCT_ID',$productID);
    }

    public function haveDrink(){
        $productID = $this->input->post('productID');
        $dataProduct = array(
            'PRODUCT_ACTIVE' => '1'
        );
        $this->crud_model->update('product',$dataProduct,'PRODUCT_ID',$productID);
    }

   
}
