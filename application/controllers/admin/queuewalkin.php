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
        $search = $this->input->get('search');
        if ($this->input->get('queueStatus') == '1') {
            $queueStatus =  1;
        } else if ($this->input->get('queueStatus') == '2') {
            $queueStatus = 2;
        } else if ($this->input->get('queueStatus') == '3') {
            $queueStatus = 3;
        } else {
            $queueStatus = '1,2,3';
        }
        $config['base_url'] = site_url('admin/recipe/index');
        $config['total_rows'] = $this->queue_model->countAllQueueWalkin($search, $queueStatus);
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
        $data['queue'] = $this->queue_model->queueWalkin($search, $queueStatus, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['queueTime'] = $this->queue_model->queuetime('2');
        $data['page'] = 'queuewalkin_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function updateQueueWalkinTime()
    {
        $queueTime = $this->input->post('queueTime');
        $dataQueueTime = array(
            'QUEUETYPE_TIME' => $queueTime
        );
        $this->crud_model->update('queuetype', $dataQueueTime, 'QUEUETYPE_ID', '2');
    }

    public function addQueueWalkin()
    {
        $data['page'] = 'queuewalkin_add_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function insertQueueWalkin()
    {
        $data['status'] = true;
        $queue['queueType'] = $this->crud_model->findselectWhere('queuetype', 'QUEUETYPE_TIME', 'QUEUETYPE_ID', '1');
        $queueDStart = date('Y-m-d');
        $customerTel = $this->input->post('customerTel');
        $queueNo = $this->queue_model->CheckQueue($customerTel, $queueDStart);
        if ($queueNo != 0) {
            $data['status'] = false;
        }
        if ($data['status'] == true) {
            $queueTStart = date('H:i');
            $queueTEnd = strtotime($queueTStart);
            $queueTEnd += 60 * $queue['queueType']['0']->QUEUETYPE_TIME;
            $queueTEnd = date('H:i', $queueTEnd);
            $queueID = $this->genIdQueue();
            $customerName = $this->input->post('customerName');
            $customerAmount = $this->input->post('customerAmount');
            $note = $this->input->post('QUEUE_NOTE');
            $queueType = 2;
            $queueActive = 1; #1 Wait #2Use #3Late
            $queueStatus = 1;
            $employeeID = $_SESSION['employeeID'];
            $dataWalkin = array(
                'QUEUE_ID' => $queueID,
                'QUEUE_CUSNAME' => $customerName,
                'QUEUE_CUSAMOUNT' => $customerAmount,
                'QUEUE_CUSTEL' => $customerTel,
                'QUEUE_DSTART' => $queueDStart,
                'QUEUE_TSTART' => $queueTStart,
                'QUEUE_NOTE' => $note,
                'QUEUE_TYPE' => $queueType,
                'QUEUE_ACTIVE' => $queueActive,
                'QUEUE_STATUS' => $queueStatus,
                'QUEUE_EMPLOYEE' => $employeeID,
            );
            $this->crud_model->insert('queue', $dataWalkin);
            $data['url'] = site_url('admin/queueWalkin');
        }
        echo json_encode($data);
    }

    public function genIdQueue()
    {
        $maxId = $this->crud_model->maxID('queue', 'QUEUE_ID');
        $ymd = date('ymd');
        if ($maxId == '') {
            $id = 'QUE' . $ymd . '001';
            return $id;
        } else {
            $ymdID = substr($maxId, 3, 6);
            if ($ymdID != $ymd) {
                return 'QUE' . $ymd . '001';
            } else {
                $id = substr($maxId, 9);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                $id = 'QUE' . $ymdID . $id;
                return $id;
            }
        }
    }

    public function editQueueWalkin(){
        $queueID = $this->input->get('queueID');
        $data['queueWalkin'] = $this->queue_model->editQueueWalkin($queueID);
        $data['page'] = 'queuewalkin_edit_view';
        $this->load->view('admin/servicemain_view',$data);
        // print_r($data['queueWalkin']);  
    }
}
