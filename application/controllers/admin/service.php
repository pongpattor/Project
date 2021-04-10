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
                    'DTSER_TYPEORDER' => '3', #DTSERTYPE 1 = PRODUCT , 2 = PROMOTION , 3 = KARAOKE
                    'DTSER_TYPEUSE' => '2', #DTSERTYPE 1 = HERE , 2 = HOME 
                    'DTSER_DATE' => $serviceDStart,
                    'DTSER_TIME' => $serviceTStart,
                    'DTSER_AMOUNT' => $karaokeUseAmount,
                    'DTSER_NOTE' => '',
                    'DTSER_REMAINDER' => '1',
                    'DTSER_STATUS' => '1',
                );
                $this->crud_model->insert('servicedetail', $dataDetailService);
                $dataKaraokeService = array(
                    'KARADTSER_ID' => $serviceID,
                    'KARADTSER_NO' => '1',
                    'KARADTSER_KARAOKEID' => $serviceSeat['0'],
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

    public function instore()
    {

        $search = $this->input->get('search');
        if ($this->input->get('productActive')) {
            $productActive = $this->input->get('productActive');
        } else {
            $productActive = '1,2';
        }

        $config['base_url'] = site_url('admin/service/instore');
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

    public function serviceDetail()
    {
        $serviceID = $this->input->get('detailServiceID');
        $data['serviceDetail'] = $this->service_model->serviceDetail($serviceID);
        // echo '<pre>';
        // print_r($data['serviceDetail']);
        // echo '</pre>';
        $data['page'] = 'servicedetail_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function serviceOrder()
    {
        $data['order'] = $this->service_model->order();
        $data['page'] = 'serviceorder_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function indexOrder()
    {
        $data['order'] = $this->service_model->order();
        echo json_encode($data);
    }


    public function indexPromotionSet()
    {
        $data['order'] = $this->service_model->promotionSet();
        echo json_encode($data);
    }

    public function indexPromotionSetDetail()
    {
        $promotionSetID = $this->input->post('promotionSetID');
        $data['promotionSetDetail'] = $this->service_model->promotionSetDetail($promotionSetID);
        echo json_encode($data);
    }

    public function insertOrder()
    {
        $serviceID = $this->input->post('serviceID');
        $ServiceMaxNo = $this->crud_model->maxWhere('servicedetail', 'DTSER_NO', 'DTSER_ID', $serviceID);
        if ($ServiceMaxNo == null) {
            $ServiceMaxNo = 1;
        } else {
            $ServiceMaxNo++;
        }
        $data['testss'] = $ServiceMaxNo;
        $changeTypeOrder = $this->input->post('changeTypeOrder');
        $selectOrderID = $this->input->post('selectOrderID');
        $amountOrder = $this->input->post('amountOrder');
        $selectNote = $this->input->post('selectNote');
        $selectOrderType = $this->input->post('selectOrderType');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        for ($i = 0; $i < count($selectOrderID); $i++) {
            $dataDetailService = array(
                'DTSER_ID' => $serviceID,
                'DTSER_NO' => $ServiceMaxNo,
                'DTSER_TYPEORDER' => $changeTypeOrder[$i], #DTSER_TYPEORDER 1 = FD, 2 = PROSET
                'DTSER_TYPEUSE' => $selectOrderType[$i], #DTSERTYPE 1 = HERE , 2 = HOME 
                'DTSER_DATE' => $date,
                'DTSER_TIME' => $time,
                'DTSER_AMOUNT' =>  $amountOrder[$i],
                'DTSER_REMAINDER' => $amountOrder[$i],
                'DTSER_NOTE' => $selectNote[$i],
                'DTSER_STATUS' => '0',
            );
            $this->crud_model->insert('servicedetail', $dataDetailService);
            if ($changeTypeOrder[$i] == 1) {
                $dataDetailServiceType = array(
                    'FDDTSER_SERVICEID' => $serviceID,
                    'FDDTSER_NO' => $ServiceMaxNo,
                    'FDDTSER_PRODUCTID' => $selectOrderID[$i],
                );
                $this->crud_model->insert('servicedetailfd', $dataDetailServiceType);
            } else {
                $dataDetailServiceType = array(
                    'PRODTSER_SERVICEID' => $serviceID,
                    'PRODTSER_NO' => $ServiceMaxNo,
                    'PRODTSER_PROSETID' => $selectOrderID[$i],
                );
                $this->crud_model->insert('servicedetailproset', $dataDetailServiceType);
                $dataprosetDetail = $this->crud_model->findSelectWhere('promotionsetdetail', 'PROSETDETAIL_PRODUCT,PROSETDETAIL_AMOUNT', 'PROSETDETAIL_ID', $selectOrderID[$i]);
                $maxnoProset = $this->crud_model->maxWhere('servicedetailprosetdetail', 'DPRODTSER_DETAILNO', 'DPRODTSER_SERVICEID', $serviceID);
                if ($maxnoProset == null) {
                    $maxnoProset = 1;
                } else {
                    $maxnoProset++;
                }
                foreach ($dataprosetDetail as $row) {
                    $amountdetailproset = $amountOrder[$i] * $row->PROSETDETAIL_AMOUNT;
                    $dataServiceProsetDetail = array(
                        'DPRODTSER_SERVICEID' => $serviceID,
                        'DPRODTSER_NO' => $ServiceMaxNo,
                        'DPRODTSER_DETAILNO' => $maxnoProset,
                        'DPRODTSER_PRODUCTID' => $row->PROSETDETAIL_PRODUCT,
                        'DPRODTSER_AMOUNT' => $amountdetailproset,
                        'DPRODTSER_STATUS' => '0',
                    );
                    $this->crud_model->insert('servicedetailprosetdetail', $dataServiceProsetDetail);
                    $maxnoProset++;
                }
            }
            $ServiceMaxNo++;
        }
        $data['url'] = site_url("admin/service/serviceDetail?detailServiceID=$serviceID");
        echo json_encode($data);
    }

    public function checkOrderForCancel()
    {
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $checkOrderStatus = $this->service_model->checkOrderForCancel($serviceID, $serviceNO);
        if ($checkOrderStatus != 0) {
            $data['status'] = false;
        } else {
            $data['status'] = true;
            $this->crud_model->delete2Where('servicedetail', 'DTSER_ID', $serviceID, 'DTSER_NO', $serviceNO);
        }
        echo json_encode($data);
    }

    public function test()
    {
        $price = 50000000.55;
        $sellPrice = substr($price,0,strlen($price)-3);
        $decimalPrice = substr($price,-2);
        if($decimalPrice < 50){
            $decimalPrice = '.00';
        }
        else{
            $sellPrice += 1;
            $decimalPrice = '.00';
        }
        $price =  $sellPrice.''.$decimalPrice;
        echo number_format($price,2,'.','');
      
    }
}
