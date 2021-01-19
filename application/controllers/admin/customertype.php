<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customertype extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('customertype_model');
        $this->load->model('crud_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/customertype/index');
        $config['total_rows'] = $this->customertype_model->countAllCustomerType($search);
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
        $data['customerType'] = $this->customertype_model->customerType($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'customertype_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addCustomerType()
    {
        $data['page'] = 'customertype_add_view';
        $this->load->view('admin/main_view', $data);
    }

    public function insertCustomerType()
    {
        $customerTypeName = $this->input->post('customerTypeName');
        $count = $this->customertype_model->checkCustomerTypeName($customerTypeName);
        if ($count == 0) {
            $customerTypeDiscount = $this->input->post('customerTypeDiscount');
            $customerTypeDiscountBdate = $this->input->post('customerTypeDiscountBdate');
            $dataCustomer = array(
                'CUSTOMERTYPE_ID' => $this->genIdCustomerType(),
                'CUSTOMERTYPE_NAME' => $customerTypeName,
                'CUSTOMERTYPE_DISCOUNT' => $customerTypeDiscount,
                'CUSTOMERTYPE_DISCOUNTBDATE' => $customerTypeDiscountBdate
            );
            $this->crud_model->insert('customertype', $dataCustomer);
            $data['customer'] = $dataCustomer;
            $data['status'] = true;
            $data['message'] = "เพิ่มประเภทสมาชิกสำเร็จ";
            echo json_encode($data);
        } else {
            $data['status'] = false;
            $data['message'] = "ชื่อ $customerTypeName ได้ถูกใช้ไปแล้ว";
            echo json_encode($data);
        }
    }

    public function genIdCustomerType()
    {
        $maxID =  $this->customertype_model->maxID();
        $year = date('y');
        if ($maxID == Null) {
            return 'TCUS' . $year . '0001';
        } else {
            $y = substr($maxID, 4, 2);
            $no = substr($maxID, 6, 4);
            if ($y != $year) {
                return 'TCUS' . $y . $no;
            } else {
                $no = $no + 1;
                while (strlen($no) < 4) {
                    $no = '0' . $no;
                }
                return 'TCUS' . $y . $no;
            }
        }
    }

    //genID Employee 
    public function genIdEmployee($idPosition)
    {
        $idDept =  $this->employee_model->idDeptGenIdEmp($idPosition);
        $maxIdEmployee = $this->employee_model->maxIdEmployee($idDept);
        $firstID = substr($maxIdEmployee, 0, 2);
        $idDept = substr($idDept, 3);
        $date =  date('Y') + 543;
        $Y =  substr($date, 2);
        $m = date('m');
        $midfront =  $m;
        $midback = 00;
        $midback = +$idDept;
        $midback = '0' . $midback;
        $last = '';
        if ($firstID != $Y) {
            $last = 0001;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $midfront .   $midback . $last;
        } else {
            $last = substr($maxIdEmployee, 6);
            $last += 1;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $midfront .   $midback . $last;
        }
    }

    public function editCustomerType(){
        $customerTypeID = $this->input->get('customerTypeID');
        $data['customerType'] = $this->crud_model->findwhere('customerType','CUSTOMERTYPE_ID',$customerTypeID);
        $data['page'] = 'admin/customertype_edit_view';
        $this->load->view('admin/main_view', $data);
    }
}
