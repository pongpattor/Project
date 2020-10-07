<?php
defined('BASEPATH') or exit('No direct script access allowed');

class position extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['login'])) {
            return redirect(site_url('admin/login'));
        } else if ($_SESSION['permission'][2] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('position_model');
        $this->load->library('pagination');
    }


    // Position Start
    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/position/index');
        $config['total_rows'] = $this->position_model->countAllPosition($search);
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
        $data['dept_pos'] = $this->position_model->position($search, $limit, $offset);
        // $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'position_view';
        $this->load->view('admin/main_view', $data);
        // echo $config['total_rows'];
    }

    public function addPosition()
    {
        $data['page'] = 'position_add_view';
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view', $data);
    }

    public function genIdPosition()
    {
        $maxIdPosition = $this->position_model->maxIdPosition();
        if ($maxIdPosition == '') {
            $id = 'POS001';
            return $id;
        } else {
            $id = substr($maxIdPosition, 3);
            $id += 1;
            while (strlen($id) < 3) {
                $id = '0' . $id;
            }
            $id = 'POS' . $id;
            return $id;
        }
    }

    public function insertPos()
    {

        $position = array(
            'POSITION_ID' => $this->genIdPosition(),
            'POSITION_NAME' => $this->input->post('positionName'),
            'DEPT_ID' => $this->input->post('departmentID'),
            'PERMISSION' =>  $this->input->post('perPosition')
        );

        $this->crud_model->insert('position', $position);
        redirect(site_url('admin/position/'));


        // Convert String to Array
        // $array = explode(",",$d);
        // print_r($array);
    }

    public function editPosition()
    {
        $posID = $this->input->get('positionID');
        $data['oldPos'] = $this->crud_model->findwhere('position', 'POSITION_ID', $posID);

        if ($data['oldPos'] == null) {
            echo '<script>';
            echo 'alert("ไม่มีข้อมูลตำแหน่งรหัส ' . $posID . '");';
            echo 'location.href= "' . site_url('admin/position/') . '"';
            echo '</script>';
        } else {
            $data['page'] = 'position_edit_view';
            $data['department'] = $this->crud_model->findall('department');


            if ($data['oldPos'][0]->PERMISSION == "") {
                $data['permission'] = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
            } else {
                $data['permission'] = explode(',', $data['oldPos']['0']->PERMISSION);
            }
            // print_r($data['permission']);
            $this->load->view('admin/main_view', $data);
        }
    }

    public function updatePosition()
    {
        $positionID = $this->input->post('positionID');
        $positionName = $this->input->post('positionName');
        $deptID = $this->input->post('departmentID');
        $permission =  $this->input->post('perPosition');
        $this->position_model->updatePosition($positionID, $positionName, $deptID, $permission);

        return redirect(site_url('admin/position/'));
    }

    public function deletePosition()
    {
        $pos = $this->input->post('posID');
        $this->crud_model->delete('position', 'POSITION_ID', $pos);
    }

    public function checkPositionNameInsert()
    {
        $departmentId = $this->input->post("departmentId");
        $positionName = $this->input->post("positionName");
        $check = $this->position_model->checkName($departmentId, $positionName);
        if ($check != 0) {
            //ซ้ำ
            echo 1;
        } else {
            //ไม่ซ้ำ
            echo 0;
        }
    }


    public function checkPositionNameUpdate()
    {
        $departmentId = $this->input->post("departmentId");
        $positionName = $this->input->post("positionName");
        $oldname = $this->input->post("oldPositionName");
        $oldDepartment = $this->input->post("oldDepartment");
        if ($oldname == $positionName && $departmentId == $oldDepartment) {
            echo 0;
        } else {
            $check = $this->position_model->checkName($departmentId, $positionName);
            if ($check != 0) {
                //ซ้ำ
                echo 1;
            } else {
                //ไม่ซ้ำ
                echo 0;
            }
        }
    }
    // Position End

}
