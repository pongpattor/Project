<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customertype extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['employeeLogin'])) {
            return redirect(site_url('admin/login'));
        } 
        else if ($_SESSION['employeePermission'][1] != 1) {
            echo '<script>alert("คุณไม่มีสิทธิ์ในการใช้งานระบบนี้")</script>';
            return redirect(site_url('admin/admin/'));
        }
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
        $data['status'] = true;
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
            $data['message'] = "เพิ่มประเภทสมาชิกสำเร็จ";
            $data['url'] = site_url('admin/customertype');
        } else {
            $data['status'] = false;
            $data['message'] = "ชื่อนี้ได้ถูกใช้ไปแล้ว";
        }
        echo json_encode($data);
    }

    public function genIdCustomerType()
    {
        $maxID =  $this->crud_model->maxID('customertype', 'CUSTOMERTYPE_ID');
        $year = date('y');
        if ($maxID == Null) {
            return 'TCUS' . $year . '0001';
        } else {
            $y = substr($maxID, 4, 2);
            if ($y != $year) {
                return 'TCUS' . $year . '0001';
            } else {
                $no = substr($maxID, 6, 4);
                $no = $no + 1;
                while (strlen($no) < 4) {
                    $no = '0' . $no;
                }
                return 'TCUS' . $y . $no;
            }
        }
    }

    public function editCustomerType()
    {
        $customerTypeID = $this->input->get('customerTypeID');
        $data['customerType'] = $this->crud_model->findwhere('customerType', 'CUSTOMERTYPE_ID', $customerTypeID);
        $data['page'] = 'customertype_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateCustomerType()
    {
        $data['status'] = true;
        $customerTypeName = $this->input->post('customerTypeName');
        $customerTypeNameOld = $this->input->post('customerTypeNameOld');
        $customerTypeID = $this->input->post('customerTypeID');
        $customerTypeDiscount = $this->input->post('customerTypeDiscount');
        $customerTypeDiscountBdate = $this->input->post('customerTypeDiscountBdate');
        if (strtolower($customerTypeName) == strtolower($customerTypeNameOld)) {
            $dataCustomer = array(
                'CUSTOMERTYPE_DISCOUNT' => $customerTypeDiscount,
                'CUSTOMERTYPE_DISCOUNTBDATE' => $customerTypeDiscountBdate
            );
            $this->crud_model->update('customertype', $dataCustomer, 'CUSTOMERTYPE_ID', $customerTypeID);
            $data['message'] = 'แก้ไขข้อมูลเสร็จสิ้น';
            $data['url'] = site_url('admin/customertype');
        } else {
            $count = $this->customertype_model->checkCustomerTypeName($customerTypeName);
            if ($count == 0) {
                $dataCustomer = array(
                    'CUSTOMERTYPE_NAME' => $customerTypeName,
                    'CUSTOMERTYPE_DISCOUNT' => $customerTypeDiscount,
                    'CUSTOMERTYPE_DISCOUNTBDATE' => $customerTypeDiscountBdate
                );
                $this->crud_model->update('customertype', $dataCustomer, 'CUSTOMERTYPE_ID', $customerTypeID);
                $data['message'] = 'แก้ไขข้อมูลเสร็จสิ้น';
                $data['url'] = site_url('admin/customertype');
            } else {
                $data['status'] = false;
                $data['message'] = "ชื่อนี้ัได้ถูกใช้ไปแล้ว";
            }
        }
        echo json_encode($data);
    }

    public function deleteCustomerType()
    {
        $customerTypeID = $this->input->post('customerTypeID');
        $this->crud_model->delete('customertype', 'CUSTOMERTYPE_ID', $customerTypeID);
        $data['url'] = site_url('admin/customertype');
        echo json_encode($data);
    }
}
