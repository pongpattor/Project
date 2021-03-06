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

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/recipe/index');
        $config['total_rows'] = $this->queue_model->countAllQueue($search);
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
        $data['queue'] = $this->queue_model->queue($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['queueTime'] = $this->queue_model->queuetime();
        $data['page'] = 'queue_view';
        $this->load->view('admin/servicemain_view', $data);
        // print_r($_SESSION['employeeID']);
    }

    public function updateQueueTime()
    {
        $queueTime = $this->input->post('queueTime');
        $dataQueueTime = array(
            'QUEUETYPE_TIME' => $queueTime
        );
        $this->crud_model->update('queuetype', $dataQueueTime, 'QUEUETYPE_ID', '1');
    }

    public function addQueue()
    {
        $data['page'] = 'queue_add_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function queueDesk()
    {
        $data['date'] = $_POST['queueDate'];
        $data['desk'] = $this->queue_model->selectDesk();
        $data['karaoke'] = $this->queue_model->selectKaraoke();
        echo json_encode($data);
    }

    public function insertQueue()
    {
        $data['status'] = true;
        $customerTel = $this->input->post('customerTel');
        $queueDateTime = $this->input->post('queueDateTime');
        $dtString = strtotime($queueDateTime);
        $checkDateQueue = date('Y-m-d', $dtString);
        $queueNo = $this->queue_model->CheckQueue($customerTel, $checkDateQueue);
        if ($queueNo != 0) {
            $data['status'] = false;
        }
        if ($data['status'] == true) {
            $queue['queueType'] = $this->crud_model->findselectWhere('queuetype', 'QUEUETYPE_TIME', 'QUEUETYPE_ID', '1');
            $dtLatestring = $dtString + (60 * $queue['queueType']['0']->QUEUETYPE_TIME);
            $queueID = $this->genIdQueue();
            $dateTimeQueue = date('Y-m-d H:i:s', $dtString);
            $dateTimeLate = date('Y-m-d H:i:s', $dtLatestring);
            $customerName = $this->input->post('customerName');
            $customerAmount = $this->input->post('customerAmount');
            $desk = $this->input->post('deskID');
            if($desk == null){
                $countDesk = 0;
            }
            else{
                $countDesk = count($desk);
            }
            $karaoke = $this->input->post('karaokeID');
            if($karaoke == null){
                $countKaraoke = 0;
            }
            else{
                $countKaraoke = count($karaoke);
            }
            $karaokeAmount = $this->input->post('karaokeUseAmount');
            $karaokeUseType = $this->input->post('karaokeUseType');
            $note = $this->input->post('note');
            $queueType = 1; #จองคิวล่วงหน้า
            $queueActive = 1; #1 Wait #2Use #3Late
            $queueStatus = 1;
            $employeeID = $_SESSION['employeeID'];
            $dataQueue = array(
                'QUEUE_ID' => $queueID,
                'QUEUE_CUSNAME' => $customerName,
                'QUEUE_CUSAMOUNT' => $customerAmount,
                'QUEUE_CUSTEL' => $customerTel,
                'QUEUE_DTSTART' => $dateTimeQueue,
                'QUEUE_DTEND' => $dateTimeLate,
                'QUEUE_NOTE' => $note,
                'QUEUE_TYPE' => $queueType,
                'QUEUE_ACTIVE' => $queueActive,
                'QUEUE_STATUS' => $queueStatus,
                'QUEUE_EMPLOYEE' => $employeeID,
            );
            $this->crud_model->insert('queue', $dataQueue);
            if ($countDesk > 0) {
                for ($i = 0; $i < $countDesk; $i++) {
                    $dataQS = array(
                        'QS_QUEUEID' => $queueID,
                        'QS_SEATID' => $desk[$i],
                    );
                    $this->crud_model->insert('queueseat', $dataQS);
                }
                $data['desk'] = 'success';
            }
            if ($countKaraoke > 0) {
                for ($i = 0; $i < $countKaraoke; $i++) {
                    $dataQS = array(
                        'QS_QUEUEID' => $queueID,
                        'QS_SEATID' => $karaoke[$i],

                    );
                    $this->crud_model->insert('queueseat', $dataQS);
                }
                for ($i = 0; $i < $countKaraoke; $i++) {
                    $dataQSK = array(
                        'QSK_QUEUEID' => $queueID,
                        'QSK_KARAOKEID' => $karaoke[$i],
                        'QSK_KARAOKEUSETYPE' =>  $karaokeUseType[$i],
                        'QSK_KARAOKEUSEAMOUNT' => $karaokeAmount[$i]
                    );
                    $this->crud_model->insert('queuekaraoke', $dataQSK);
                }
                $data['karaoke'] = 'success';

            }
            $data['url'] = site_url('admin/queue');
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
}
