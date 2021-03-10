<?php
defined('BASEPATH') or exit('No direct script access allowed');

class queuewalkin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('queue_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['queueTime'] = $this->queue_model->queuetime('2');
        $data['page'] = 'queuewalkin_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function updateQueueWalkinTime(){
        $queueTime = $this->input->post('queueTime');
        $dataQueueTime = array(
            'QUEUETYPE_TIME' => $queueTime
        );
        $this->crud_model->update('queuetype', $dataQueueTime, 'QUEUETYPE_ID', '2');
    }

    public function addQueueWalkin(){
        $data['page'] = 'queuewalkin_add_view';
        $this->load->view('admin/servicemain_view', $data);

    }

    public function insertQueueWalkin(){
        $data['test'] = $_POST;
        $queue['queueType'] = $this->crud_model->findselectWhere('queuetype', 'QUEUETYPE_TIME', 'QUEUETYPE_ID', '1');
        $queueDStart = date('Y-m-d');
        $queueTStart = date('H:i');
        $queueTEnd = strtotime($queueTStart);
        $queueTEnd += 60 * $queue['queueType']['0']->QUEUETYPE_TIME;
        $queueTEnd = date('H:i', $queueTEnd);
        $data['wow'] = array(
            'DStart' => $queueDStart,
            'TStart' => $queueTStart,
            'TEnd' => $queueTEnd,

        );
        echo json_encode($data);
    }
}
