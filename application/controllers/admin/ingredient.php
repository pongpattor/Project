<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ingredient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        // if (empty($_SESSION['employeeLogin'])) {
        //     return redirect(site_url('admin/login'));
        // } else if ($_SESSION['employeePermission'][10] != 1) {
        //     echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
        //     return redirect(site_url('admin/admin/'));
        // }
        $this->load->model('crud_model');
        $this->load->model('ingredient_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        if ($this->input->get('ingredientActive')) {
            $ingredientActive = $this->input->get('ingredientActive');
        } else {
            $ingredientActive = '1,2';
        }
        $config['base_url'] = site_url('admin/ingredient/index');
        $config['total_rows'] = $this->ingredient_model->countAllIngredient($search, $ingredientActive);
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
        $data['ingredient'] = $this->ingredient_model->ingredient($search, $ingredientActive, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'ingredient_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addIngredient()
    {
        $data['page'] = 'ingredient_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertIngredient()
    {
        $data['status'] = true;
        $ingredientName = $this->input->post('ingredientName');
        $checkIngredientName =  $this->crud_model->count2Where('ingredient', 'INGREDIENT_NAME', $ingredientName, 'INGREDIENT_STATUS', '1');
        if ($checkIngredientName != 0) {
            $data['status'] = false;
        }

        if ($data['status'] == true) {
            $ingredientID = $this->genIdIngredient();
            $dataIngredient = array(
                'INGREDIENT_ID' => $ingredientID,
                'INGREDIENT_NAME' => $ingredientName,
                'INGREDIENT_ACTIVE' => '1',
                'INGREDIENT_STATUS' => '1',
            );
            $this->crud_model->insert('ingredient', $dataIngredient);
            $data['url'] = site_url('admin/ingredient');
        }
        echo json_encode($data);
    }

    public function genIdIngredient()
    {
        $maxId = $this->crud_model->maxID('ingredient', 'INGREDIENT_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'IN' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 2, 4);
            if ($ymID != $ym) {
                return 'IN' . $ym . '0001';
            } else {
                $id = substr($maxId, 6);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'IN' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editIngredient()
    {
        $ingredientID = $this->input->get("ingredientID");
        $data['ingredient'] = $this->crud_model->findSelectWhere('ingredient', 'INGREDIENT_ID,INGREDIENT_NAME,INGREDIENT_ACTIVE', 'INGREDIENT_ID', $ingredientID);
        $data['page'] = 'ingredient_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateIngredient()
    {
        // $data['input'] = $_POST;
        $data['status'] = true;
        $ingredientName = $this->input->post('ingredientName');
        $ingredientNameOld = $this->input->post('ingredientNameOld');
        if (strtolower($ingredientName) != strtolower($ingredientNameOld)) {
            $checkIngredientName =  $this->crud_model->count2Where('ingredient', 'INGREDIENT_NAME', $ingredientName, 'INGREDIENT_STATUS', '1');
            if ($checkIngredientName != 0) {
                $data['status'] = false;
            }
        }
        if ($data['status'] == true) {
            $ingredientID = $this->input->post('ingredientID');
            $ingredientActive = $this->input->post('ingredientActive');
            $dataIngredient = array(
                'INGREDIENT_NAME' => $ingredientName,
                'INGREDIENT_ACTIVE' => $ingredientActive,
            );
            $this->crud_model->update('ingredient', $dataIngredient, 'INGREDIENT_ID', $ingredientID);

            $data['url'] = site_url('admin/ingredient');
        }
        echo json_encode($data);
    }

    public function deleteIngredient()
    {
        $ingredientID = $this->input->post('ingredientID');
        $dataIngredient = array(
            'INGREDIENT_STATUS' => '0',
        );
        $this->crud_model->update('ingredient', $dataIngredient, 'INGREDIENT_ID', $ingredientID);
        // echo json_encode($data);
    }
}
