<?php
defined('BASEPATH') or exit('No direct script access allowed');

class receiveIngredient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][7] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('receive_ingredient_model');
        $this->load->library('pagination');
    }


    // receiveIngredient start
    public function index()
    {

        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/receiveIngredient/index');
        $config['total_rows'] = $this->receive_ingredient_model->countAllReceive($search);
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
        $data['receive_ingredient'] = $this->receive_ingredient_model->fetchReceive($search, $limit, $offset);
        $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'receive_ingredient_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addReceiveIngredient()
    {
        $data['page'] = 'receive_ingredient_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function genIdReceive(){
        $Y = date('y')+43;
        $m = date('m');
        $d = date('d');
        $date =$Y.$m.$d;
        // echo 'LOT'.$Y.$m.$d;
        $max = $this->receive_ingredient_model->maxIdReceiveIngredien();
        if($max == ''){
            return 'LOT'.$date.'001';
        }
        else{
          $max = substr($max,9);
          $max++;
          while(strlen($max) <3){
              $max = '0'.$max;
          }
            return 'LOT'.$date.$max;
        }
        
    }

    public function InsertReceiveIngredient()
    {
        $receiveName = $this->input->post("ReceiveName");
        $receivePrice = $this->input->post("ReceivePrice");
        $idReceive = $this->genIdReceive();
        $totalPrice = 0;
        foreach ($receivePrice as $row) {
            $totalPrice += $row;
          
        }
        echo $totalPrice;
        $Receive = array(
            'RECEIVE_INGREDIENT_ID' =>   $idReceive,
            'DATE_AT' => date('Y-m-d H:i:s'),
            'TOTAL_PRICE' => $totalPrice,
            'TIME_AT' => date('H:i:s')
        );
        $this->crud_model->insert('receive_ingredient', $Receive);
        $receiveID = $this->receive_ingredient_model->maxIdReceiveIngredien();

        for ($i = 0; $i < count($receiveName); $i++) {
            $receiveDetail = array(
                "INGREDIENT_NO" => $i+1,
                "INGREDIENT_RECEIVE_ID" => $receiveID,
                "INGREDIENT_NAME" => $receiveName[$i],
                "INGREDIENT_PRICE" => $receivePrice[$i]
            );
            $this->crud_model->insert('receive_ingredient_detail', $receiveDetail);
        }

        // redirect(site_url('admin/receiveIngredient/'));
    }
    
    public function editReceiveIngredient()
    {
        $ReceiveID = $this->input->get("ReceiveID");
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
        redirect(site_url('admin/receiveIngredient/'));
    }

    public function deleteReceiveIngredient()
    {
        $ReceiveID = $this->input->post('ReceiveID');
        $this->crud_model->delete('receive_ingredient', 'RECEIVE_INGREDIENT_ID', $ReceiveID);
    }

    // receiveIngredient End
}
