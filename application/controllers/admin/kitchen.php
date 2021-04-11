<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kitchen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('kitchen_model');
    }

    public function kitchenFood()
    {
        $data['food'] = $this->kitchen_model->kitchen('1');
        $data['foodsame'] = $this->kitchen_model->kitchenSame('1');
        $data['foodsameIdNo'] = $this->kitchen_model->kitchenFoodSameIdNo();
        // echo '<pre>';
        // print_r($data['food']);
        // echo '</pre>';
        $data['page'] = 'kitchenfood_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function cookSameService()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $productID = $this->input->post('productID');
        $serviceDate = $this->input->post('serviceDate');
        $serviceTime = $this->input->post('serviceTime');
        $serviceID = substr($serviceID, 0, strlen($serviceID) - 1);
        $serviceNO = substr($serviceNO, 0, strlen($serviceNO) - 1);
        $serviceDate = substr($serviceDate, 0, strlen($serviceDate) - 1);
        $serviceTime = substr($serviceTime, 0, strlen($serviceTime) - 1);
        $serviceID = explode(',', $serviceID);
        $serviceNO = explode(',', $serviceNO);
        $serviceDate = explode(',', $serviceDate);
        $serviceTime = explode(',', $serviceTime);
        for ($i = 0; $i < count($serviceID); $i++) {
            $typeOrder = $this->kitchen_model->checkSameTypeOrder($serviceID[$i], $serviceNO[$i]);
            if ($typeOrder == 1) {
                $this->kitchen_model->updateDetailFoodDrink($serviceID[$i], $serviceNO[$i]);
            } 
            else {
                $dataKeySameOrder = $this->kitchen_model->findKeySameOrder($serviceID[$i], $serviceNO[$i], $serviceDate[$i], $serviceTime[$i], $productID);
                foreach($dataKeySameOrder as $rowSameOrder){
                    $this->kitchen_model->updateDetailProset($rowSameOrder->DTSER_ID,$rowSameOrder->DTSER_NO,$rowSameOrder->DPRODTSER_DETAILNO);
                }
                $dataCheckStatusProset = $this->kitchen_model->checkStatusProset($serviceID[$i], $serviceNO[$i]);
                foreach($dataCheckStatusProset as $rowStatusProset){
                    if($rowStatusProset->CNT > 0){
                        $this->kitchen_model->updateServiceDetailProset($serviceID[$i], $serviceNO[$i]);
                    }
                }
            }
        }
        $data['serviceID'] = $serviceID;
        echo json_encode($data);
    }
}
