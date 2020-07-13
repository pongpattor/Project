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
            'FIRSTNAME' => $this->input->post('firstname'),
            'LASTNAME' => $this->input->post('lastname'),
            'GENDER' => $this->input->post('gender'),
            'EMAIL' => $this->input->post('firstname'),
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
        $data['position'] = $this->crud_model->find('position','DEPT_ID',$department_id);


        //  echo '<pre>';
        //  print_r($data['department']);
        //  echo $department_id;
        //  echo '</pre>';

        $data['page'] = 'edit_employee_view';
        $this->load->view('admin/main_view',$data);
    }

    public function updateEmp(){
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
            $this->crud_model->update('employee',$employeeDetail,'ID',$idEmp);
            redirect(site_url('admin/admin/employee'));
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

    public function Department()
    {
        $data['page'] = 'department_view';
        $this->load->view('admin/main_view', $data);
    }

    public function addDepartment()
    {
        $data['page'] = 'add_department_view';
        $data['employee'] =  $this->employee_model->fetchEmpForDepartment();
        // echo '<pre>';
        // print_r($data['employee']);
        // echo '</pre>';
        $this->load->view('admin/main_view', $data);
    }
}
