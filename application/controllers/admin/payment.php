<?php
defined('BASEPATH') or exit('No direct script access allowed');

class payment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('payment_model');
        $this->load->library('pagination');
    }

    public function pay()
    {
        $serviceID = $this->input->get('serviceID');
        $serviceID = "'$serviceID'";
        $data['payment'] = $this->payment_model->paymentNormal($serviceID);
        $data['page'] = 'payment_view';
        $this->load->view('admin/servicemain_view', $data);
        // echo '<pre>';
        // print_r($data['payment']);
        // echo '</pre>';
    }

    public function telMemberDiscount()
    {
        $tel = $this->input->post('tel');
        $dataMember = $this->payment_model->telMemberDiscount($tel);
        if ($dataMember == null || $dataMember == '') {
            $data['search'] = false;
        } else {
            $data['search'] = true;
            $data['member'] = $dataMember;
        }
        echo json_encode($data);
    }

    public function typePayment()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/payment/typePayment');
        $config['total_rows'] = $this->payment_model->countAllTypePayment($search);
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
        $data['typePayment'] = $this->payment_model->typePayment($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'typepayment_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addTypePayment()
    {
        $data['page'] = 'typepayment_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertTypePayment()
    {
        $typePaymentName = $this->input->post('typePaymentName');
        $chk = $this->payment_model->checkTypePaymentName($typePaymentName);
        if ($chk == 0) {
            $dataTypePayment = array(
                'TYPEPAYMENT_ID' => $this->genIdTypePayment(),
                'TYPEPAYMENT_NAME' => $typePaymentName,
                'TYPEPAYMENT_STATUS' => '1',
            );
            $this->crud_model->insert('typepayment', $dataTypePayment);
            $data['url'] = site_url('admin/payment/typepayment');
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function genIdTypePayment()
    {
        $maxId = $this->crud_model->maxID('typepayment', 'TYPEPAYMENT_ID');
        $y = date('y');
        if ($maxId == '') {
            $id = 'TP' . $y . '001';
            return $id;
        } else {
            $ymID = substr($maxId, 2, 2);
            if ($ymID != $y) {
                return 'TP' . $y . '0001';
            } else {
                $id = substr($maxId, 4);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                $id = 'TP' . $ymID . $id;
                return $id;
            }
        }
    }

    public function editTypePayment()
    {
        $typePaymentID = $this->input->get('typePaymentID');
        $data['typepayment'] = $this->payment_model->editTypePayment($typePaymentID);
        $data['page'] = 'typepayment_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateTypePayment()
    {
        $typePaymentName = $this->input->post('typePaymentName');
        $typePaymentNameOld = $this->input->post('typePaymentNameOld');
        if (strtolower($typePaymentName) == strtolower($typePaymentNameOld)) {
            $data['status'] = true;
            $data['url'] = site_url('admin/payment/typepayment');
        } else {
            $chk = $this->payment_model->checkTypePaymentName($typePaymentName);
            if ($chk == 0) {
                $typePaymentID = $this->input->post('typePaymentID');
                $dataTypePayment = array(
                    'TYPEPAYMENT_NAME' => $typePaymentName,
                );
                $this->crud_model->update('typepayment', $dataTypePayment, 'TYPEPAYMENT_ID', $typePaymentID);
                $data['url'] = site_url('admin/payment/typepayment');
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        }
        echo json_encode($data);
    }

    public function deleteTypePayment()
    {
        $typePaymentID = $this->input->post('typePaymentID');
        $dataTypePayment = array(
            'TYPEPAYMENT_STATUS' => '0',
        );
        $this->crud_model->update('typepayment', $dataTypePayment, 'TYPEPAYMENT_ID', $typePaymentID);
    }
}
