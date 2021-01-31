<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lotingredient extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('lot_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/lotingredient/index');
        $config['total_rows'] = $this->lot_model->countAllLotIngredient($search);
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
        $data['lotingredient'] = $this->lot_model->lotIngredient($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'lotingredient_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addLotIngredient()
    {
        $data['ingredient'] = $this->crud_model->findselectWhere('ingredient', 'INGREDIENT_ID,INGREDIENT_NAME', 'INGREDIENT_STATUS', '1');
        $data['page'] = 'lotingredient_add_view';
        $this->load->view('admin/main_view', $data);
        //     echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    }

    public function insertLotIngredient()
    {
        // $data['input'] = $_POST;
        $lotID = $this->genIdLotIngredient();
        $lotDate = date('Y-m-d');
        $lotTime = date('H:i:s');
        $lotEmployee = $_SESSION['employeeID'];
        $lotTotal = $this->input->post('lotTotal');
        $lotIngredientID = $this->input->post('lotIngredientID');
        $lotIngredientPrice = $this->input->post('lotIngredientPrice');

        $dataLot = array(
            'LOT_ID' => $lotID,
            'LOT_EMPLOYEE' => $lotEmployee,
            'LOT_TOTAL' => $lotTotal,
            'LOT_DATE' => $lotDate,
            'LOT_TIME' => $lotTime,
            'LOT_TYPE' => '2',
            'LOT_STATUS' => '1',
        );
        $this->crud_model->insert('lot', $dataLot);

        for ($i = 0; $i < count($lotIngredientPrice); $i++) {
            $dataLotDetail = array(
                'LOTDETAIL_ID' => $lotID,
                'LOTDETAIL_NO' => ($i + 1),
                'LOTDETAIL_PRICE' => $lotIngredientPrice[$i],
            );
            $this->crud_model->insert('lotdetail', $dataLotDetail);
        }

        for ($i = 0; $i < count($lotIngredientID); $i++) {
            $dataLotDrink = array(
                'LOTINGREDIENT_ID' => $lotID,
                'LOTINGREDIENT_NO' => ($i + 1),
                'LOTINGREDIENT_INGREDIENT' => $lotIngredientID[$i],
            );
            $this->crud_model->insert('lotingredient', $dataLotDrink);
        }
        $data['url'] = site_url('admin/lotingredient');

        echo json_encode($data);
    }


    public function genIdLotIngredient()
    {
        $maxId = $this->crud_model->maxID('lot', 'LOT_ID');
        $ymd = date('ymd');
        if ($maxId == '') {
            $id = 'LOT' . $ymd . '001';
            return $id;
        } else {
            $ymdID = substr($maxId, 3, 6);
            if ($ymdID != $ymd) {
                return 'LOT' . $ymd . '001';
            } else {
                $id = substr($maxId, 9);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                $id = 'LOT' . $ymdID . $id;
                return $id;
            }
        }
    }

    public function editLotIngredient()
    {
        $lotIngredientID = $this->input->get('lotIngredientID');
        $data['lotingredient'] = $this->lot_model->editLotIngredient($lotIngredientID);
        $data['lotdetail'] = $this->lot_model->editLotIngredientDetail($lotIngredientID);
        $data['ingredient'] = $this->crud_model->findselectWhere('ingredient', 'INGREDIENT_ID,INGREDIENT_NAME', 'INGREDIENT_STATUS', '1');
        $data['page'] = 'lotingredient_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateLotIngredient()
    {
        $data['input'] = $_POST;
        $lotID = $this->input->post('lotID');
        $lotTotal = $this->input->post('lotTotal');
        $lotIngredientID = $this->input->post('lotIngredientID');
        $lotIngredientPrice = $this->input->post('lotIngredientPrice');
        $dataLot = array(
            'LOT_TOTAL' => $lotTotal,
        );
        $this->crud_model->update('lot', $dataLot, 'LOT_ID', $lotID);
        $this->crud_model->delete('lotdetail', 'LOTDETAIL_ID', $lotID);
        for ($i = 0; $i < count($lotIngredientPrice); $i++) {
            $dataLotDetail = array(
                'LOTDETAIL_ID' => $lotID,
                'LOTDETAIL_NO' => ($i + 1),
                'LOTDETAIL_PRICE' => $lotIngredientPrice[$i],
            );
            $this->crud_model->insert('lotdetail', $dataLotDetail);
        }
        for ($i = 0; $i < count($lotIngredientID); $i++) {
            $dataLotDrink = array(
                'LOTINGREDIENT_ID' => $lotID,
                'LOTINGREDIENT_NO' => ($i + 1),
                'LOTINGREDIENT_INGREDIENT' => $lotIngredientID[$i],
            );
            $this->crud_model->insert('lotingredient', $dataLotDrink);
        }
        $data['url'] = site_url('admin/lotingredient');

        echo json_encode($data);
    }

    public function deleteLotIngredient(){
        $lotIngredientID = $this->input->post('lotIngredientID');
        $dataLotIngredient = array(
            'LOT_STATUS' => '0',
        );
        $this->crud_model->update('lot', $dataLotIngredient, 'LOT_ID', $lotIngredientID);

    }
}
