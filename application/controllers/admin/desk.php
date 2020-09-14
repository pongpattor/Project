<?php
defined('BASEPATH') or exit('No direct script access allowed');

class desk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('desk_model');
        $this->load->library('pagination');
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
}
