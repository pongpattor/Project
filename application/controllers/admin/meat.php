<?php
defined('BASEPATH') or exit('No direct script access allowed');

class meat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][6] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        $this->load->model('product_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }


    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/meat/index');
        $config['total_rows'] = $this->product_model->countAllMeat($search);
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
        $data['meat'] = $this->product_model->meat($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'meat_view';
        $this->load->view('admin/main_view', $data);
        // echo '<pre>';
        // print_r($data['meat']);
        // echo '</pre>';

    }

    public function addMeat()
    {
        $data['page'] =  'meat_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function genMeatID()
    {

        $maxId = $this->product_model->maxMeatID();
        if ($maxId == '') {
            return 'M001';
        } else {
            $maxId = substr($maxId, 1);
            $maxId++;
            while (strlen($maxId) < 3) {
                $maxId = '0' . $maxId;
            }
            return 'M' . $maxId;
        }
    }

    public function insertMeat()
    {
        $meatName =  $this->input->post('meatName');
        $meatDetail = array(
            'MEAT_ID' => $this->genMeatID(),
            'MEAT_NAME' => $meatName,
            'MEAT_STATUS' => 1,
        );
        $this->crud_model->insert('meat', $meatDetail);
        return redirect(site_url('admin/meat/'));
    }

    public function checkMeatName()
    {
        $meatName = $this->input->post('meatName');
        $check = $this->product_model->checkMeatName($meatName);
        if ($check != 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function updateCheckMeatName()
    {
        $meatName = $this->input->post('meatName');
        $oldMeatName = $this->input->post('oldName');
        if ($oldMeatName == $meatName) {
            echo 0;
        } else {
            $check = $this->product_model->checkMeatName($meatName);
            if ($check != 0) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function editMeat()
    {
        $meatId = $this->input->get('meatID');
        $data['meat'] = $this->crud_model->findwhere('meat', 'MEAT_ID', $meatId);
        if ($data['meat'] == null) {
            echo '<script>';
            echo 'alert("ไม่มีข้อมูลเนื้อสัตว์รหัส ' . $meatId . '");';
            echo 'location.href= "' . site_url('admin/meat/') . '"';
            echo '</script>';
        } else {
            $data['page'] = 'meat_edit_view';
            $this->load->view('admin/main_view', $data);
        }
    }

    public function updateMeat()
    {
        $meatID = $this->input->post('meatID');
        $meatName = $this->input->post('meatName');
        $meatStatus = $this->input->post('meatStatus');
        $meatDetail = array(
            'MEAT_NAME' => $meatName,
            'MEAT_STATUS' => $meatStatus,
        );
        $this->crud_model->update('meat', $meatDetail, 'MEAT_ID', $meatID);
        return redirect(site_url('admin/meat/'));
    }

    public function deleteMeat()
    {
        $id = $this->input->post('meatId');
        $this->crud_model->delete('meat', 'MEAT_ID', $id);
    }
}
