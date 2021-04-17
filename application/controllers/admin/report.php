<?php
defined('BASEPATH') or exit('No direct script access allowed');

class report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('report_model');
    }

    public function reportAmount()
    {
        if ($_GET == null) {
            $data['state'] = false;
            $data['links'] = null;
        } else {
            $data['state'] = true;
            $dateStart = $this->input->get('dateStart');
            $dateEnd = $this->input->get('dateEnd');
            $sorting = $this->input->get('sorting');
            $data['report'] = $this->report_model->reportAmountProduct($dateStart, $dateEnd, $sorting);
        }
        // print_r($data);
        $data['page'] = 'reportamountproduct_view';
        $this->load->view('admin/main_view', $data);
    }

    public function reportProfits()
    {
        if ($_GET == null) {
            $data['state'] = false;
            $data['links'] = null;
        } else {
            $data['state'] = true;
            $dateStart = $this->input->get('dateStart');
            $dateEnd = $this->input->get('dateEnd');
            $data['report'] = $this->report_model->reportProfitProduct($dateStart, $dateEnd);
        }
        // print_r($data);
        $data['page'] = 'reportprofit_view';
        $this->load->view('admin/main_view', $data);
    }
}
