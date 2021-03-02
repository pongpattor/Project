<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queue extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('queue_model');
        $this->load->library('pagination');
    }

    public function index(){
        $data['queueTime'] = $this->queue_model->queuetime();
        $data['page'] = 'queue_view';
        $this->load->view('admin/servicemain_view',$data);
    }

    public function updateQueueTime(){
        $queueTime = $this->input->post('queueTime');
        $dataQueueTime = array(
            'QUEUETYPE_TIME' => $queueTime
        );
        $this->crud_model->update('queuetype',$dataQueueTime,'QUEUETYPE_ID','1');
    }

    public function addQueue(){
        $data['page'] = 'queue_add_view';
        $this->load->view('admin/servicemain_view',$data);
    }

    public function queueDesk(){
        $data['date'] = $_POST['queueDate'];
        $data['desk'] = $this->queue_model->selectDesk();
        $data['karaoke'] = $this->queue_model->selectKaraoke();
        echo json_encode($data);
    }
}
