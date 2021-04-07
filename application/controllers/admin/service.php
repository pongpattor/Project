<?php
defined('BASEPATH') or exit('No direct script access allowed');

class service extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('ASIA/BANGKOK');
        $this->load->model('crud_model');
        $this->load->model('service_model');
        $this->load->library('pagination');
    }

    public function index()
    {
    }

    public function storefont()
    {
        $data['deskEmpty'] = $this->service_model->deskEmpty();
        $data['karaokeEmpty'] = $this->service_model->karaokeEmpty();
        $data['zone'] = $this->crud_model->findSelectWhere('zone', 'ZONE_ID,ZONE_NAME', 'ZONE_STATUS', '1');


        $data['page'] = 'storefont_view';
        $this->load->view('admin/servicemain_view', $data);
    }


    public function insertEnterService()
    {
        $enterTypeService =  $this->input->post('enterServiceType');
        $AmountCustomerE = $this->input->post('AmountCustomerE');
        $serviceDStart = date('Y-m-d');
        $serviceTStart = date('H:i');
        $useKaraoke = 0;
        if ($this->input->post('deskEmpty') != null) {
            $serviceSeat = $this->input->post('deskEmpty');
        } else {
            $serviceSeat = $this->input->post('karaokeEmpty');
            $useKaraoke = 1;
        }
        $data['serviceSeat'] = $serviceSeat;
        if ($enterTypeService == '1') {
            $serviceID = $this->genServiceID();
            $dataService = array(
                'SERVICE_ID' => $serviceID,
                'SERVICE_CUSAMOUNT' => $AmountCustomerE,
                'SERVICE_DSTART' => $serviceDStart,
                'SERVICE_TSTART' => $serviceTStart,
                'SERVICE_ACTIVE' => '1',
                'SERVICE_STATUS' => '1'
            );
            $this->crud_model->insert('service', $dataService);
            for ($i = 0; $i < count($serviceSeat); $i++) {
                $dataServiceSeat = array(
                    'SERSEAT_SEATID' => $serviceSeat[$i],
                    'SERSEAT_SERVICEID' => $serviceID,
                );
                $this->crud_model->insert('serviceseat', $dataServiceSeat);
                $dataSeatActive = array(
                    'SEAT_ACTIVE' => '2'
                );
                $this->crud_model->update('seat', $dataSeatActive, 'SEAT_ID', $serviceSeat[$i]);
            }
            if ($useKaraoke == 1) {
                $karaokeUsetype = $this->input->post('karaokeUsetype');
                $karaokeUseAmount = $this->input->post('karaokeUseAmount');

                $dataDetailService = array(
                    'DTSER_ID' => $serviceID,
                    'DTSER_NO' => '1',
                    'DTSER_TYPE' => '2', #DTSERTYPE 1 = PRODUCT , 2 = KARAOKE , 3 = PROMOTION
                    'DTSER_DATE' => $serviceDStart,
                    'DTSER_TIME' => $serviceTStart,
                    'DTSER_AMOUNT' => $AmountCustomerE,
                    'DTSER_NOTE' => '',
                    'DTSER_REMAINDER' => '1',
                    'DTSER_ACTIVE' => '1',
                    'DTSER_STATUS' => '1',
                );
                $this->crud_model->insert('servicedetail', $dataDetailService);
                $dataKaraokeService = array(
                    'KARADTSER_ID' => $serviceID,
                    'KARADTSER_NO' => '1',
                    'KARADTSER_KARAOKEID' => $serviceSeat['0'],
                    'KARADTSER_AMOUNT' => $karaokeUseAmount,
                    'KARADTSER_USETYPE' => $karaokeUsetype,
                );
                $this->crud_model->insert('servicedetailkaraoke', $dataKaraokeService);
            }
        } else {
            $abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for ($i = 0; $i < count($AmountCustomerE); $i++) {
                $serviceID = $this->genServiceID();
                $dataService = array(
                    'SERVICE_ID' => $serviceID,
                    'SERVICE_CUSAMOUNT' => $AmountCustomerE[$i],
                    'SERVICE_DSTART' => $serviceDStart,
                    'SERVICE_TSTART' => $serviceTStart,
                    'SERVICE_ACTIVE' => '1',
                    'SERVICE_STATUS' => '1'
                );
                $this->crud_model->insert('service', $dataService);
                $dataServiceSeat = array(
                    'SERSEAT_SEATID' => $serviceSeat[0],
                    'SERSEAT_SERVICEID' => $serviceID,
                    'SERSEAT_SEATSPLIT' => $abc[$i],
                );
                $this->crud_model->insert('serviceseat', $dataServiceSeat);
            }
            $dataSeatActive = array(
                'SEAT_ACTIVE' => '2'
            );
            $this->crud_model->update('seat', $dataSeatActive, 'SEAT_ID', $serviceSeat[0]);
        }
        $data['url'] = site_url('admin/service/instore');
        
        echo json_encode($data);
    }

    public function genServiceID()
    {
        $maxId = $this->crud_model->maxID('service', 'SERVICE_ID');
        $ymd = date('ymd');
        if ($maxId == '') {
            $id = 'SER' . $ymd . '001';
            return $id;
        } else {
            $ymdID = substr($maxId, 3, 6);
            if ($ymdID != $ymd) {
                return 'SER' . $ymd . '001';
            } else {
                $id = substr($maxId, 9);
                $id += 1;
                while (strlen($id) < 3) {
                    $id = '0' . $id;
                }
                $id = 'SER' . $ymdID . $id;
                return $id;
            }
        }
    }

    public function instore(){

        $search = $this->input->get('search');
        if ($this->input->get('productActive')) {
            $productActive = $this->input->get('productActive');
        } else {
            $productActive = '1,2';
        }

        $config['base_url'] = site_url('admin/product/index');
        $config['total_rows'] = $this->service_model->countAllService($search, $productActive);
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
        $data['service'] = $this->service_model->service($search, $limit, $offset);
        if ($data['service'] != null) {
            $arrService = [];
            foreach ($data['service'] as $row) {
                array_push($arrService, $row->serID);
            }
            $serviceID = implode(",", $arrService);

            $data['serviceSeat'] = $this->service_model->fetchServiceSeat($serviceID);
        }
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'serviceinstore_view';
        $this->load->view('admin/servicemain_view', $data);
    }
}
