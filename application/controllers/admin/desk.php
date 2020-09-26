<?php
defined('BASEPATH') or exit('No direct script access allowed');

class desk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['login'])){
            return redirect(site_url('admin/login'));
        }
        else if($_SESSION['permission'][3] != 1){
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/home'));
        }
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('desk_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    // Table Start
    public function index()
    {
        
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/desk/index');
        $config['total_rows'] = $this->desk_model->countAllDesk($search);
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
        $data['desk'] = $this->desk_model->desk($search, $limit, $offset);
        $data['total_rows'] = $config['total_rows'];
        $data['links'] = $this->pagination->create_links();
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
            redirect(site_url('admin/desk/'));
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
            redirect(site_url('admin/desk/'));
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
                redirect(site_url('admin/desk/'));
            }
        }
    }

    public function deleteDesk()
    {
        $deskID = $this->input->post('deskID');
        $this->desk_model->delDesk($deskID);
    }


    // Table End
}
