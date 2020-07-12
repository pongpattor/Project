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

    public function dashboard()
    {
        $data['page'] = 'dashboard_view';
        $this->load->view('admin/main_view', $data);
    }

    public function customer()
    {
        $data['customer'] = $this->customer_model->findall('customer');
        $data['page'] = 'customer_view';
        $this->load->view('admin/main_view', $data);
    }

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
        $data['page'] = 'add_employee_view';
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
            'FIRSTNAME' =>$this->input->post('firstname'),
            'LASTNAME' =>$this->input->post('lastname'),
            'GENDER' =>$this->input->post('gender'),
            'EMAIL' =>$this->input->post('firstname'),
            'TEL' =>$this->input->post('tel'),
            'BDATE' => $this->input->post('bdate'),
            'ADDRESS' =>$this->input->post('address'),
            'DISTRICT' =>$this->input->post('district'),
            'AMPHUR' =>$this->input->post('amphur'),
            'PROVINCE' =>$this->input->post('province'),
            'POSTCODE' =>$this->input->post('postcode'),
            'DEPARTMENT' =>$this->input->post('department'),
            'POSITION' =>$this->input->post('position'),
            'SALARY' => $this->input->post('salary'),
            'CREATE_AT' => date('Y-m-d H:i:s'),
            'STATUS' => 1
        ); 
        $this->crud_model->insert('employee',$employee_detail);
        redirect(site_url('admin/admin/employee'));
    }

    public function deleteEmployee($id){
        $delete_at = date('Y-m-d H:i:s');
        $this->employee_model->delEmp($id,$delete_at);
        return redirect(site_url('admin/admin/employee'));
    }

    public function editEmployee($id)
    {
        $this->load->model('employee_model');
        $data['result'] = $this->employee_model->editEmployee($id);
        echo '<pre>';
        print_r($data['result']);
        echo '</pre>';
    }

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
}
