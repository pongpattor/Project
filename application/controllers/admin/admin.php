<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('base_data_model');
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

   

   

    // Table Start
    public function desk()
    {
        $search = '';
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            $data['desk'] =  $this->desk_model->searchDesk($search);
        } else {
            $data['desk'] =  $this->desk_model->fetchDesk();
        }
        $data['page'] = 'desk_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDesk()
    {
        $data['page'] = 'desk_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertDesk()
    {
        $deskNumber = $this->input->post('deskNumber');
        $count = $this->checkDeskNumber($deskNumber);
        if ($count > 0) {
            echo '<script>';
            echo 'alert("เลขโต๊ะนี้ได้มีการใช้แล้ว");';
            echo 'window.history.back();';
            echo '</script>';
        } else {
            $detailDesk = array(
                'DESK_ID' => $this->genDeskID(),
                'DESK_NUMBER' => $deskNumber,
                'DESK_STATUS' => '0'
            );
            $this->crud_model->insert('desk', $detailDesk);
            redirect(site_url('admin/admin/desk'));
        }
    }

    public function genDeskID()
    {
        $maxId =  $this->desk_model->maxID();
        $ID = substr($maxId, 1) + 1;
        while (strlen($ID) < 3) {
            $ID =  '0' . $ID;
        }

        $deskID = 'D' . $ID;
        return $deskID;
    }

    public function checkDeskNumber($number)
    {
        $count = $this->desk_model->checkNumber($number);
        return $count;
    }

    public function editDesk()
    {
        $deskID = $this->input->get('deskID');
        $data['desk'] = $this->crud_model->findwhere('desk', 'DESK_ID', $deskID);
        $data['page'] = 'desk_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateDesk()
    {
        $deskNumber = $this->input->post('deskNumber');
        $deskStatus = $this->input->post('status');
        $deskID = $this->input->post('deskID');
        $oldNumber = $this->input->post('oldNumber');
        if ($oldNumber == $deskNumber) {
            $deskDetail = array(
                'DESK_NUMBER' => $deskNumber,
                'DESK_STATUS' => $deskStatus
            );
            $this->crud_model->update('desk', $deskDetail, 'DESK_ID', $deskID);
            redirect(site_url('admin/admin/desk'));
        } else {
            $count = $this->checkDeskNumber($deskNumber);
            if ($count > 0) {
                echo '<script>';
                echo 'alert("เลขโต๊ะนี้ได้มีการใช้แล้ว");';
                echo 'window.history.back();';
                echo '</script>';
            } else {
                $deskDetail = array(
                    'DESK_NUMBER' => $deskNumber,
                    'DESK_STATUS' => $deskStatus
                );
                $this->crud_model->update('desk', $deskDetail, 'DESK_ID', $deskID);
                redirect(site_url('admin/admin/desk'));
            }
        }
    }

    public function deleteDesk()
    {
        $deskID = $this->input->post('deskID');
        $this->desk_model->delDesk($deskID);
    }


    // Table End

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
