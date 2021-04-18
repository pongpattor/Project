<?php
defined('BASEPATH') or exit('No direct script access allowed');

class recipe extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['employeePermission'][7] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
        $this->load->model('crud_model');
        $this->load->model('recipe_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/recipe/index');
        $config['total_rows'] = $this->recipe_model->countAllRecipe($search);
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
        $data['recipe'] = $this->recipe_model->recipe($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'recipe_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addRecipe()
    {
        $data['product'] = $this->recipe_model->productMenuRecipe();
        $data['ingredient'] = $this->crud_model->findselectWhere('ingredient', 'INGREDIENT_ID,INGREDIENT_NAME', 'INGREDIENT_STATUS', '1');
        $data['page'] = 'recipe_add_view';
        // $data['customer'] = $this->crud_model->findAll('customer');

        // $data['page'] = 'test2_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertRecipe()
    {
        $data['input'] = $_POST;
        $data['status'] = true;
        $productID = $this->input->post('recipeProductID');
        $checkRecipeProduct = $this->crud_model->countWhere('recipe', 'RECIPE_PRODUCT', $productID);
        $data['check'] = $checkRecipeProduct;
        if ($checkRecipeProduct != 0) {
            $data['status'] = false;
        }

        if ($data['status'] == true) {
            $recipeID = $this->genIdRecipe();
            $dataRecipe = array(
                'RECIPE_ID' => $recipeID,
                'RECIPE_PRODUCT' => $productID,
            );
            $this->crud_model->insert('recipe', $dataRecipe);
            $recipeIngredientID = $this->input->post('recipeIngredientID');
            $ingredientImportant = $this->input->post('ingredientImportant');
            for ($i = 0; $i < count($recipeIngredientID); $i++) {
                $dataRecipeDetail = array(
                    'RECIPEDETAIL_RECIPEID' => $recipeID,
                    'RECIPEDETAIL_NO' => ($i + 1),
                    'RECIPEDETAIL_INGREDIENT' => $recipeIngredientID[$i],
                    'RECIPEDETAIL_IMPORTANT' => $ingredientImportant[$i],
                );
                $this->crud_model->insert('recipedetail', $dataRecipeDetail);
            }
            $data['url'] = site_url('admin/recipe');
        }
        echo json_encode($data);
    }


    public function genIdRecipe()
    {
        $maxId = $this->crud_model->maxID('recipe', 'RECIPE_ID');
        $ym = date('ym');
        if ($maxId == '') {
            $id = 'RCP' . $ym . '0001';
            return $id;
        } else {
            $ymID = substr($maxId, 3, 4);
            if ($ymID != $ym) {
                return 'RCP' . $ym . '0001';
            } else {
                $id = substr($maxId, 7);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'RCP' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editRecipe()
    {
        $recipeID = $this->input->get('recipeID');
        $data['recipe'] =  $this->recipe_model->editRecipe($recipeID);
        $data['recipeDetail'] =  $this->recipe_model->editRecipeDetail($recipeID);
        $data['product'] = $this->recipe_model->productMenuRecipe();
        $data['ingredient'] = $this->crud_model->findselectWhere('ingredient', 'INGREDIENT_ID,INGREDIENT_NAME', 'INGREDIENT_STATUS', '1');
        $data['page'] = 'recipe_edit_view';
        $this->load->view('admin/main_view', $data);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    }

    public function updateRecipe()
    {
        $data['input'] = $_POST;
        $data['status'] = true;
        $productID = $this->input->post('recipeProductID');
        $productIDOld = $this->input->post('recipeProductIDOld');
        if ($productID != $productIDOld) {
            $checkRecipeProduct = $this->crud_model->countWhere('recipe', 'RECIPE_PRODUCT', $productID);
            if ($checkRecipeProduct != 0) {
                $data['status'] = false;
            }
        }

        if ($data['status'] == true) {
            $recipeID = $this->input->post('recipeID');
            $dataRecipe = array(
                'RECIPE_PRODUCT' => $productID,
            );
            $this->crud_model->update('recipe', $dataRecipe, 'RECIPE_ID', $recipeID);
            $this->crud_model->delete('recipedetail', 'RECIPEDETAIL_RECIPEID', $recipeID);
            $recipeIngredientID = $this->input->post('recipeIngredientID');
            $ingredientImportant = $this->input->post('ingredientImportant');
            for ($i = 0; $i < count($recipeIngredientID); $i++) {
                $dataRecipeDetail = array(
                    'RECIPEDETAIL_RECIPEID' => $recipeID,
                    'RECIPEDETAIL_NO' => ($i + 1),
                    'RECIPEDETAIL_INGREDIENT' => $recipeIngredientID[$i],
                    'RECIPEDETAIL_IMPORTANT' => $ingredientImportant[$i],
                );
                $this->crud_model->insert('recipedetail', $dataRecipeDetail);
            }
            $data['url'] = site_url('admin/recipe');
        }
        echo json_encode($data);
    }

    public function deleteRecipe()
    {
        $recipeID = $this->input->post('recipeID');
        $this->crud_model->delete('recipe', 'RECIPE_ID', $recipeID);
    }
}
