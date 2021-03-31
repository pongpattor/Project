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
        if ($this->input->get('queueActive') == '1') {
            $queueActive =  1;
        } else if ($this->input->get('queueActive') == '2') {
            $queueActive = 2;
        } else if ($this->input->get('queueActive') == '3') {
            $queueActive = 3;
        } else {
            $queueActive = '1,2,3';
        }
        $config['base_url'] = site_url('admin/queue/index');
        $config['total_rows'] = $this->queue_model->countAllQueue($search, $queueActive);
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
        $data['queue'] = $this->queue_model->queue($search, $queueActive, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['queueTime'] = $this->queue_model->queuetime('1');
        if ($data['queue'] != null) {
            $arrQueueSeat = [];
            foreach ($data['queue'] as $row) {
                array_push($arrQueueSeat, $row->QUEUEID);
            }
            $queueID = implode(",", $arrQueueSeat);
            $data['queueSeat'] = $this->queue_model->selectQueueSeat($queueID);
        }
        $data['page'] = 'queue_view';
        $this->load->view('admin/servicemain_view', $data);
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

    public function selectSeat()
    {
        $date = $_POST['queueDate'];
        $data['seat'] = $this->queue_model->selectSeat($date);
        echo json_encode($data);
    }

    public function checkCallQueue()
    {
        $customerTel = $this->input->post('customerTel');
        $queueDStart = $this->input->post('queueDate');
        $data['1'] = $customerTel;
        $data['2'] = $queueDStart;
        $queueNo = $this->queue_model->checkCallQueue($customerTel, $queueDStart);
        $data['checkCallQueue'] = $queueNo;
        echo json_encode($data);
    }

    public function insertQueue()
    {

        $queue['queueType'] = $this->crud_model->findselectWhere('queuetype', 'QUEUETYPE_TIME', 'QUEUETYPE_ID', '1');
        $customerTel = $this->input->post('customerTel');
        $queueDStart = $this->input->post('queueDate');
        $queueTStart = $this->input->post('queueTime');
        $queueTEnd = strtotime($queueTStart);
        $queueTEnd += 60 * $queue['queueType']['0']->QUEUETYPE_TIME;
        $queueTEnd = date('H:i', $queueTEnd);
        $queueID = $this->genIdQueue();
        $customerName = $this->input->post('customerName');
        $customerAmount = $this->input->post('customerAmount');

        $note = $this->input->post('note');
        $queueType = 1; #จองคิวล่วงหน้า
        $queueActive = 1; #1 Wait #2Use #3Late
        $queueStatus = 1;
        $employeeID = $_SESSION['employeeID'];
        $desk = $this->input->post('deskID');
        if ($desk == null) {
            $countDesk = 0;
        } else {
            $countDesk = count($desk);
        }
        $karaoke = $this->input->post('karaokeID');
        if ($karaoke == null) {
            $countKaraoke = 0;
        } else {
            $countKaraoke = count($karaoke);
        }
        $karaokeAmount = $this->input->post('karaokeUseAmount');
        $karaokeUseType = $this->input->post('karaokeUseType');
        $dataQueue = array(
            'QUEUE_ID' => $queueID,
            'QUEUE_CUSNAME' => $customerName,
            'QUEUE_CUSAMOUNT' => $customerAmount,
            'QUEUE_CUSTEL' => $customerTel,
            'QUEUE_DSTART' => $queueDStart,
            'QUEUE_TSTART' => $queueTStart,
            'QUEUE_DEND' => $queueDStart,
            'QUEUE_TEND' => $queueTEnd,
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
        }
        $data['url'] = site_url('admin/queue');


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

    public function editQueue()
    {
        $queueID = $this->input->get('queueID');
        $data['queue'] = $this->queue_model->editqueue($queueID);
        $data['queueSeat'] = $this->queue_model->editQueueSeat($queueID);
        $date =  $data['queue']['0']->QUEUE_DSTART;
        $data['seat'] = $this->queue_model->selectSeat($date);
        $data['page'] = 'queue_edit_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function updateQueue()
    {

        $customerTel = $this->input->post('customerTel');
        $queueDStart = $this->input->post('queueDate');
        $queue['queueType'] = $this->crud_model->findselectWhere('queuetype', 'QUEUETYPE_TIME', 'QUEUETYPE_ID', '1');
        $queueTStart = $this->input->post('queueTime');
        $queueTEnd = strtotime($queueTStart);
        $queueTEnd += 60 * $queue['queueType']['0']->QUEUETYPE_TIME;
        $queueTEnd = date('H:i', $queueTEnd);
        $queueID = $this->input->post('queueID');
        $customerName = $this->input->post('customerName');
        $customerAmount = $this->input->post('customerAmount');
        $note = $this->input->post('note');
        $desk = $this->input->post('deskID');
        if ($desk == null) {
            $countDesk = 0;
        } else {
            $countDesk = count($desk);
        }
        $karaoke = $this->input->post('karaokeID');
        if ($karaoke == null) {
            $countKaraoke = 0;
        } else {
            $countKaraoke = count($karaoke);
        }
        $karaokeAmount = $this->input->post('karaokeUseAmount');
        $karaokeUseType = $this->input->post('karaokeUseType');
        $dataQueue = array(
            'QUEUE_CUSNAME' => $customerName,
            'QUEUE_CUSAMOUNT' => $customerAmount,
            'QUEUE_CUSTEL' => $customerTel,
            'QUEUE_DSTART' => $queueDStart,
            'QUEUE_TSTART' => $queueTStart,
            'QUEUE_DEND' => $queueDStart,
            'QUEUE_TEND' => $queueTEnd,
            'QUEUE_NOTE' => $note,
        );
        $this->crud_model->update('queue', $dataQueue, 'QUEUE_ID', $queueID);
        $this->crud_model->delete('queueseat', 'QS_QUEUEID', $queueID);
        if ($countDesk > 0) {
            for ($i = 0; $i < $countDesk; $i++) {
                $dataQS = array(
                    'QS_QUEUEID' => $queueID,
                    'QS_SEATID' => $desk[$i],
                );
                $this->crud_model->insert('queueseat', $dataQS);
            }
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
        }
        $data['url'] = site_url('admin/queue');


        echo json_encode($data);
    }

    public function deleteQueue()
    {
        $queueID = $this->input->post('queueID');
        $dataDelete = array(
            'QUEUE_STATUS' => '0'
        );
        $this->crud_model->update('queue', $dataDelete, 'QUEUE_ID', $queueID);
    }

    public function checkin()
    {
        // $data['status'] = true;
        $queueID = $this->input->post("queueID");
        $chkQueue = $this->queue_model->checkStatusQueue($queueID);
        $data['chkQueue'] = $chkQueue;
        if ($chkQueue == '1') {
            $dataqueue = array(
                'QUEUE_ACTIVE' => '2'
            );
            $this->crud_model->update('queue', $dataqueue, 'QUEUE_ID', $queueID);
        }

        echo json_encode($data);
    }

    public function queueTimeOut()
    {
        $this->queue_model->queueTimeOut();
    }
}
