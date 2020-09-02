<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('base_data_model');
        $this->load->model('crud_model');
        $this->load->model('employee_model');
    }

    public function index()
    {
        $this->load->view('admin/adminlogin');
    }

    public function login()
    {
        $this->load->view('admin/login');
    }

    public function dashboard()
    {
        $data['page'] = 'dashboard_view';
        $this->load->view('admin/main_view', $data);
    }
    // Customer Start
    public function customer()
    {
        $data['customer'] = $this->crud_model->findall('customer');
        $data['page'] = 'customer_view';
        // echo '<pre>';
        // print_r($data['customer']);
        // echo '</pre>';
        $this->load->view('admin/main_view', $data);
    }

    public function editCustomer()
    {
        $customerUSERNAME = $this->input->get('username');
        $data['customer'] = $this->crud_model->find('customer', 'USERNAME', $customerUSERNAME);
        echo $customerUSERNAME;
        $data['province']  = $this->base_data_model->fetch_province();
        $province_id = $data['customer']['0']->PROVINCE;
        $data['amphur'] = $this->crud_model->find('amphur', 'PROVINCE_ID', $province_id);
        $amphur_id =  $data['customer']['0']->AMPHUR;
        $data['district'] = $this->crud_model->find('district', 'AMPHUR_ID', $amphur_id);
        $data['page'] = 'customer_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateCustomer()
    {
        $username = $this->input->post('username');
        $customer_detail = array(
            'GENDER' => $this->input->post('gender'),
            'FIRSTNAME' => $this->input->post('firstname'),
            'LASTNAME' => $this->input->post('lastname'),
            'EMAIL' => $this->input->post('email'),
            'TEL' => $this->input->post('tel'),
            'BDATE' => $this->input->post('bdate'),
            'PROVINCE' => $this->input->post('province'),
            'AMPHUR' => $this->input->post('amphur'),
            'DISTRICT' => $this->input->post('district'),
            'POSTCODE' => $this->input->post('postcode'),
            'UPDATE_AT' => date('Y-m-d')
        );
        $this->crud_model->update('customer', $customer_detail, 'USERNAME', $username);
        redirect(site_url('admin/admin/customer'));
    }


    // Customer End

    // Employee Start

    public function employee()
    {
        $data['employee'] = $this->employee_model->fetchEmp();
        $data['page'] = 'employee_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addEmployee()
    {
        $this->load->model('base_data_model');
        $this->load->model('crud_model');
        $data['page'] = 'employee_add_view';
        $data['province'] = $this->base_data_model->fetch_province();
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view', $data);
    }

    public function insertEmp()
    {
        $employee_detail = array(
            'ID' => $this->genID(),
            'PASSWORD' => $this->genID(),
            'IDCARD' => $this->input->post('idcard'),
            'TITLENAME' => $this->input->post('title'),
            'FIRSTNAME' => $this->input->post('firstname'),
            'LASTNAME' => $this->input->post('lastname'),
            'GENDER' => $this->input->post('gender'),
            'EMAIL' => $this->input->post('email'),
            'TEL' => $this->input->post('tel'),
            'BDATE' => $this->input->post('bdate'),
            'ADDRESS' => $this->input->post('address'),
            'DISTRICT' => $this->input->post('district'),
            'AMPHUR' => $this->input->post('amphur'),
            'PROVINCE' => $this->input->post('province'),
            'POSTCODE' => $this->input->post('postcode'),
            'DEPARTMENT' => $this->input->post('department'),
            'POSITION' => $this->input->post('position'),
            'SALARY' => $this->input->post('salary'),
            'CREATE_AT' => date('Y-m-d H:i:s'),
            'STATUS' => 1
        );
        $this->crud_model->insert('employee', $employee_detail);
        redirect(site_url('admin/admin/employee'));
    }

    public function deleteEmployee()
    {
        $delete_at = date('Y-m-d H:i:s');
        $empID = $this->input->post('empID');
        $this->employee_model->delEmp($empID, $delete_at);
    }

    public function editEmployee()
    {
        $id = $this->input->get('empID');
        $data['employee'] = $this->crud_model->find('employee', 'ID', $id);
        $data['province']  = $this->base_data_model->fetch_province();
        $province_id = $data['employee']['0']->PROVINCE;
        $data['amphur'] = $this->crud_model->find('amphur', 'PROVINCE_ID', $province_id);
        $amphur_id =  $data['employee']['0']->AMPHUR;
        $data['district'] = $this->crud_model->find('district', 'AMPHUR_ID', $amphur_id);
        $data['department'] = $this->crud_model->findall('department');
        $department_id = $data['employee']['0']->DEPARTMENT;
        $data['position'] = $this->crud_model->find('position', 'DEPT_ID', $department_id);
        $data['page'] = 'employee_edit_view';
        $this->load->view('admin/main_view', $data);
    }

    public function updateEmp()
    {
        $idEmp = $this->input->post('idEmp');
        $employeeDetail = array(
            'IDCARD' => $this->input->post('idcard'),
            'TITLENAME' => $this->input->post('title'),
            'FIRSTNAME' => $this->input->post('firstname'),
            'LASTNAME' => $this->input->post('lastname'),
            'GENDER' => $this->input->post('gender'),
            'TEL' => $this->input->post('tel'),
            'EMAIL' => $this->input->post('email'),
            'BDATE' => $this->input->post('bdate'),
            'ADDRESS' => $this->input->post('address'),
            'DISTRICT' => $this->input->post('district'),
            'AMPHUR' => $this->input->post('amphur'),
            'PROVINCE' => $this->input->post('province'),
            'POSTCODE' => $this->input->post('postcode'),
            'DEPARTMENT' => $this->input->post('department'),
            'POSITION' => $this->input->post('position'),
            'SALARY' => $this->input->post('salary'),
            'UPDATE_AT' => date('Y-m-d H:i:s'),
        );
        $this->crud_model->update('employee', $employeeDetail, 'ID', $idEmp);
        redirect(site_url('admin/admin/employee'));
    }

    //genID Employee 
    public function genID()
    {
        $this->load->model('employee_model');
        $maxId = $this->employee_model->maxIdEmp();
        $firstID = substr($maxId, 0, 2);
        $date =  date('Y') + 543;
        $Y =  substr($date, 2);
        $middle = 1110;
        $middle += 1;
        if ($firstID != $Y) {
            $last = 0001;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $middle . $last;
        } else {
            $last = substr($maxId, 6);
            $last += 1;
            while (strlen($last) < 4) {
                $last = '0' . $last;
            }
            return $Y . $middle . $last;
        }
    }

    // Employee End

    // Department Start
    public function Department()
    {
        $data['page'] = 'department_view';
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view', $data);
    }

    public function addDepartment()
    {
        $data['page'] = 'department_add_view';
        $data['employee'] = $this->crud_model->findColumns('ID,FIRSTNAME,LASTNAME', 'employee');
       $this->load->view('admin/main_view', $data);
    }

    public function insertDepartment()
    {
        $dept = array(
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->insert('department', $dept);

        redirect(site_url('admin/admin/department'));
    }
    public function editDepartment()
    {
        $deptID = $this->input->get('departmentID');
        $data['page'] = 'department_edit_view';
        $data['oldDept'] = $this->employee_model->editDept($deptID);
        $this->load->view('admin/main_view', $data);
    }
    public function updateDepartment()
    {
        $DEPARTMENT_ID = $this->input->post('DEPARTMENT_ID');
        $department_detail = array(
            'DEPARTMENT_ID' => $DEPARTMENT_ID,
            'DEPARTMENT_NAME' => $this->input->post('DEPARTMENT_NAME'),
        );
        $this->crud_model->update('department', $department_detail, 'DEPARTMENT_ID', $DEPARTMENT_ID);
        redirect(site_url('admin/admin/department'));
    }

    public function deleteDepartment()
    {
        $dept = $this->input->post('deptID');
        $this->crud_model->delete('department', 'DEPARTMENT_ID', $dept);
    }

    // Department End


    // Position Start
    public function position()
    {
        $data['dept_pos'] = $this->employee_model->position();
        $data['page'] = 'position_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addPosition()
    {
        $data['page'] = 'position_add_view';
        $data['department'] = $this->crud_model->findall('department');
        $this->load->view('admin/main_view', $data);
    }

    public function insertPos()
    {
        $position = array(
            'POSITION_NAME' => $this->input->post('positionName'),
            'DEPT_ID' => $this->input->post('departmentID')
        );

        $this->crud_model->insert('position', $position);

        redirect(site_url('admin/admin/position'));
    }

    public function editPosition()
    {
        $posID = $this->input->get('positionID');
        $data['page'] = 'position_edit_view';
        $data['oldPos'] = $this->crud_model->find('position', 'POSITION_ID', $posID);
        $data['department'] = $this->crud_model->findall('department');



        $this->load->view('admin/main_view', $data);
    }

    public function updatePosition()
    {
        $POSITION_ID = $this->input->post('positionID');
        $position_detail = array(
            'POSITION_NAME' => $this->input->post('positionName'),
            'DEPT_ID' => $this->input->post('departmentID'),
        );
        $this->crud_model->update('position', $position_detail, 'POSITION_ID', $POSITION_ID);
        redirect(site_url('admin/admin/position'));
    }

    public function deletePosition()
    {
        $pos = $this->input->post('posID');
        $this->crud_model->delete('position', 'POSITION_ID', $pos);
    }

    // Position End

    public function table()
    {
        $data['page'] = 'table_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addTable()
    {
        $data['page'] = 'table_add_view';
        $this->load->view('admin/main_view', $data);
    }
}
