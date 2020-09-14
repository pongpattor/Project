<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('employee_model');
        $this->load->model('receive_ingredient_model');
        $this->load->model('desk_model');
        $this->load->library('pagination');
    }


    public function home()
    {
        $data['page'] = 'home';
        $this->load->view('admin/main_view', $data);
    }

   

    // receiveIngredient start
    public function receiveIngredient()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['receive_ingredient'] = $this->receive_ingredient_model->searchReceive($search);
        } else {
            $data['receive_ingredient'] = $this->receive_ingredient_model->fetchReceive();
        }
        $data['page'] = 'receive_ingredient_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addReceiveIngredient()
    {
        $data['page'] = 'receive_ingredient_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function InsertReceiveIngredient()
    {
        $receiveName = $this->input->post("ReceiveName");
        $receivePrice = $this->input->post("ReceivePrice");
        $totalPrice = 0;
        foreach ($receivePrice as $row) {
            $totalPrice += $row;
        }

        $Receive = array(
            'DATE_AT' => date('Y-m-d H:i:s'),
            'TOTAL_PRICE' => $totalPrice,
            'TIME_AT' => date('H:i:s')
        );
        $this->crud_model->insert('receive_ingredient', $Receive);
        $receiveID = $this->receive_ingredient_model->maxIdReceiveIngredien();

        for ($i = 0; $i < count($receiveName); $i++) {
            $receiveDetail = array(
                "INGREDIENT_NO" => $i + 1,
                "INGREDIENT_RECEIVE_ID" => $receiveID,
                "INGREDIENT_NAME" => $receiveName[$i],
                "INGREDIENT_PRICE" => $receivePrice[$i]
            );
            $this->crud_model->insert('receive_ingredient_detail', $receiveDetail);
        }

        redirect(site_url('admin/admin/receiveIngredient'));
    }

    public function editReceiveIngredient()
    {
        $ReceiveID = $this->input->GET("ReceiveID");
        $data['ingredient'] = $this->crud_model->findwhere('receive_ingredient_detail', 'INGREDIENT_RECEIVE_ID', $ReceiveID);
        // print_r($data['ingredient']);
        $data['page'] = 'receive_ingredient_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function UpdateReceiveIngredient()
    {

        $receiveID =  $this->input->POST('receiveID');
        $receiveName = $this->input->POST('ReceiveName');
        $receivePrice = $this->input->POST('ReceivePrice');

        $this->crud_model->delete('receive_ingredient_detail', 'INGREDIENT_RECEIVE_ID', $receiveID);
        for ($i = 0; $i < count($receiveName); $i++) {
            $receiveDetail = array(
                "INGREDIENT_NO" => $i + 1,
                "INGREDIENT_RECEIVE_ID" => $receiveID,
                "INGREDIENT_NAME" => $receiveName[$i],
                "INGREDIENT_PRICE" => $receivePrice[$i]
            );
            $this->crud_model->insert('receive_ingredient_detail', $receiveDetail);
        }
        redirect(site_url('admin/admin/receiveIngredient'));
    }

    public function deleteReceiveIngredient()
    {
        $ReceiveID = $this->input->post('ReceiveID');
        $this->crud_model->delete('receive_ingredient', 'RECEIVE_INGREDIENT_ID', $ReceiveID);
    }

    // receiveIngredient End

    public function test()
    {
        $data['hello'] = $this->employee_model->searchDepartment('30');
        print_r($data['hello']);
        // $data['page'] = 'Test';
        // $this->load->view('admin/main_view', $data);
    }
}
