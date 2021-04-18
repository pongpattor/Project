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
        $this->load->model('service_model');
        $this->load->library('pagination');
    }


    public function selectManyService()
    {
        $serviceID = $this->input->get('serviceID');
        $data['etcService'] = $this->payment_model->etcService($serviceID);
        $data['etcSeat'] = $this->payment_model->etcSeatService($serviceID);
        $data['page'] = 'paymentmanyservice_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function pay()
    {
        $data['serviceID'] = $this->input->post('selectServiceID');
        $inServiceID = '';
        for ($i = 0; $i < count($data['serviceID']); $i++) {
            $inServiceID .= '\'';
            $inServiceID .=  $data['serviceID'][$i];
            $inServiceID .=  '\'';
            if ($i < (count($data['serviceID']) - 1)) {
                $inServiceID .= ',';
            }
        }
        $data['typepayment'] = $this->crud_model->findSelectWhere('typepayment', 'TYPEPAYMENT_ID,TYPEPAYMENT_NAME', 'TYPEPAYMENT_STATUS', '1');
        $data['payment'] = $this->payment_model->paymentNormal($inServiceID);
        $data['page'] = 'payment_view';
        $this->load->view('admin/servicemain_view', $data);
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

    public function genIdReceipt()
    {
        $maxId = $this->crud_model->maxID('receipt', 'RECEIPT_ID');
        $ymd = date('ymd');
        if ($maxId == '') {
            $id = 'REC' . $ymd . '0001';
            return $id;
        } else {
            $ymdID = substr($maxId, 3, 6);
            if ($ymdID != $ymd) {
                return 'REC' . $ymd . '0001';
            } else {
                $id = substr($maxId, 9);
                $id += 1;
                while (strlen($id) < 4) {
                    $id = '0' . $id;
                }
                $id = 'REC' . $ymdID . $id;
                return $id;
            }
        }
    }


    public function insertPayment()
    {
        $memberType = $this->input->post('member');
        $receiptID = $this->genIdReceipt();
        $receiptDate = date('y-m-d');
        $receiptTime = date('H:i');
        $receiptDiscountTotal =   $this->input->post('totalDiscount');
        $receiptPriceDiscount = $this->input->post('totalPrice');
        $receiptVat = $this->input->post('totalVat');
        $receiptPriceTotal = $this->input->post('total');
        $receiptPayAll = $this->input->post('payAll');
        $receiptPayChange = $this->input->post('payChange');
        $receiptDetailTpyeOrder = $this->input->post('tpyeOrder');
        $receiptDetailPriceUnit = $this->input->post('sellPrice');
        $receiptDetailAmount = $this->input->post('Amount');
        $receiptDetailDiscount = $this->input->post('discount');
        $receiptDetailPriceAll = $this->input->post('sumPrice');
        $receiptDetailOrderID = $this->input->post('orderID');
        $receiptDetailCostFD = $this->input->post('costPrice');
        $receiptDetailCostFD = $this->input->post('costPrice');
        $receiptDetailProprice = $this->input->post('proprice');
        $receiptDetailKaraokeUseType = $this->input->post('karaokeUsetype');
        $serviceID = $this->input->post('serviceID');
        $typePaymentID = $this->input->post('typepaymentID');
        $pricePayment = $this->input->post('pricePayment');
        if ($memberType == '1') {
            $dataHeadReceipt = array(
                'RECEIPT_ID' => $receiptID,
                'RECEIPT_MEMBER' => null,
                'RECEIPT_EMPLOYEE' => $_SESSION['employeeID'],
                'RECEIPT_DATE' => $receiptDate,
                'RECEIPT_TIME' => $receiptTime,
                'RECEIPT_DISCOUNTTOTAL' => $receiptDiscountTotal,
                'RECEIPT_PRICEDISCOUNT' => $receiptPriceDiscount,
                'RECEIPT_VAT' => $receiptVat,
                'RECEIPT_PRICETOTAL' => $receiptPriceTotal,
                'RECEIPT_PAYALL' => $receiptPayAll,
                'RECEIPT_PAYCHANGE' => $receiptPayChange,
                'RECEIPT_STATUS' => '1',
            );
        } else {
            $memberID = $this->input->post('memberID');
            $dataHeadReceipt = array(
                'RECEIPT_ID' => $receiptID,
                'RECEIPT_MEMBER' => $memberID,
                'RECEIPT_EMPLOYEE' => $_SESSION['employeeID'],
                'RECEIPT_DATE' => $receiptDate,
                'RECEIPT_TIME' => $receiptTime,
                'RECEIPT_DISCOUNTTOTAL' => $receiptDiscountTotal,
                'RECEIPT_PRICEDISCOUNT' => $receiptPriceDiscount,
                'RECEIPT_VAT' => $receiptVat,
                'RECEIPT_PRICETOTAL' => $receiptPriceTotal,
                'RECEIPT_PAYALL' => $receiptPayAll,
                'RECEIPT_PAYCHANGE' => $receiptPayChange,
                'RECEIPT_STATUS' => '1',
            );
        }
        $this->crud_model->insert('receipt', $dataHeadReceipt);

        for ($i = 0; $i < count($receiptDetailTpyeOrder); $i++) {
            $dataReceiptDetail = array(
                'DTREC_ID' => $receiptID,
                'DTREC_NO' => $i + 1,
                'DTREC_TYPEORDER' => $receiptDetailTpyeOrder[$i],
                'DTREC_PRICEUNIT' => $receiptDetailPriceUnit[$i],
                'DTREC_AMOUNT' => $receiptDetailAmount[$i],
                'DTREC_DISCOUNTALL' => $receiptDetailDiscount[$i],
                'DTREC_PRICEALL' => $receiptDetailPriceAll[$i],
            );
            $this->crud_model->insert('receiptdetail', $dataReceiptDetail);

            if ($receiptDetailTpyeOrder[$i] == '1') {
                $proprice = null;
                if ($receiptDetailProprice[$i] != '' || $receiptDetailProprice[$i] != null) {
                    $proprice = $receiptDetailProprice[$i];
                }
                $dataReceiptDetailFD = array(
                    'FDDTREC_ID' => $receiptID,
                    'FDDTREC_NO' => $i + 1,
                    'FDDTREC_PRODUCTID' => $receiptDetailOrderID[$i],
                    'FDDTREC_COSTPRICE' => $receiptDetailCostFD[$i],
                    'FDDTREC_PROPRICEID' => $proprice,
                );
                $this->crud_model->insert('receiptdetailfd', $dataReceiptDetailFD);
            } else if ($receiptDetailTpyeOrder[$i] == '2') {
                $dataReceiptDetailProset = array(
                    'PROSDTREC_ID' => $receiptID,
                    'PROSDTREC_NO' => $i + 1,
                    'PROSDTREC_PROSET' => $receiptDetailOrderID[$i],
                );
                $this->crud_model->insert('receiptdetailproset', $dataReceiptDetailProset);
                $DetailProset = $this->payment_model->detailProset($receiptDetailOrderID[$i]);
                foreach ($DetailProset as $rowDetailSet) {
                    $dataDetailProset = array(
                        'DPRODTREC_ID' => $receiptID,
                        'DPRODTREC_NO' => $i + 1,
                        'DPRODTREC_DETAILNO' => $rowDetailSet->PROSETDETAIL_NO,
                        'DPRODTREC_COSTPRICE' => $rowDetailSet->PRODUCT_COSTPRICE,
                        'DPRODTREC_SELLPRICE' => $rowDetailSet->PRODUCT_SELLPRICE,
                        'DPRODTREC_AMOUNT' => ($rowDetailSet->PROSETDETAIL_AMOUNT * $receiptDetailAmount[$i]),
                        'DPRODTREC_PRODUCT' => $rowDetailSet->PRODUCT_ID,
                    );
                    $this->crud_model->insert('receiptdetailprosetdetail', $dataDetailProset);
                };
            } else if ($receiptDetailTpyeOrder[$i] == '3') {
                $dataReceiptDetailKaraoke = array(
                    'KARADTREC_ID' => $receiptID,
                    'KARADTREC_NO' => $i + 1,
                    'KARADTREC_KARAOKEID' => $receiptDetailOrderID[$i],
                    'KARADTREC_USETYPE' => $receiptDetailKaraokeUseType[$i],
                );
                $this->crud_model->insert('receiptdetailkaraoke', $dataReceiptDetailKaraoke);
            }
        }
        for ($i = 0; $i < count($typePaymentID); $i++) {
            $dataSplitPayment = array(
                'SPLITPAY_RECEIPTID' => $receiptID,
                'SPLITPAY_TYPEPAYMENTID' => $typePaymentID[$i],
                'SPLITPAY_AMOUNT' => $pricePayment[$i],
            );
            $this->crud_model->insert('splitpay', $dataSplitPayment);
        }
        for ($k = 0; $k < count($serviceID); $k++) {
            $dataServiceReceipt = array(
                'SERREC_RECID' => $receiptID,
                'SERREC_SERID' => $serviceID[$k],
            );
            $this->crud_model->insert('receiptofservice', $dataServiceReceipt);
            $dataHeadService = array(
                'SERVICE_STATUS' => '2'
            );
            $this->crud_model->update('service', $dataHeadService, 'SERVICE_ID', $serviceID[$k]);
            $dataServiceClear = array(
                'DTSER_REMAINDER' => '0'
            );
            $this->crud_model->update('servicedetail', $dataServiceClear, 'DTSER_ID', $serviceID[$k]);
            $seatID = $this->crud_model->findSelectWhere('serviceseat', 'SERSEAT_SEATID,SERSEAT_SEATSPLIT', 'SERSEAT_SERVICEID', $serviceID[$k]);
            foreach ($seatID as $rowSeat) {
                if ($rowSeat->SERSEAT_SEATSPLIT == null || $rowSeat->SERSEAT_SEATSPLIT == '') {
                    $dataSeatActive = array(
                        'SEAT_ACTIVE' => '0'
                    );
                    $this->crud_model->update('seat', $dataSeatActive, 'SEAT_ID', $rowSeat->SERSEAT_SEATID);
                } else {
                    $cntSeatSplit =  $this->service_model->checkCancelServiceSplit($rowSeat->SERSEAT_SEATID);
                    if ($cntSeatSplit == 0) {
                        $statusSeat = array(
                            'SEAT_ACTIVE' => '0'
                        );
                        $this->crud_model->update('seat', $statusSeat, 'SEAT_ID', $rowSeat->SERSEAT_SEATID);
                    }
                }
            }
        }
        $data['url'] = site_url('admin/service/instore');
        echo json_encode($data);
    }

    public function selectSplitOrder()
    {
        $this->load->model('service_model');
        $serviceID = $this->input->get('serviceID');
        $data['orderDetail'] = $this->payment_model->serviceSplitDetail($serviceID);
        $data['page'] = 'paymentselectorder_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function paySplit()
    {
        // $data['test'] = $_POST;
        $data['serviceID'] = $this->input->post('serviceID');
        $data['serviceNo'] = $this->input->post('OrderNo');
        $data['splitOrderID'] = $this->input->post('orderID');
        $data['splitOrderAmount'] = $this->input->post('orderAmount');
        $serviceNo = '';
        for ($i = 0; $i < count($data['serviceNo']); $i++) {
            $serviceNo .= $data['serviceNo'][$i];
            if ($i < (count($data['serviceNo']) - 1)) {
                $serviceNo .= ',';
            }
        }
        $data['typepayment'] = $this->crud_model->findSelectWhere('typepayment', 'TYPEPAYMENT_ID,TYPEPAYMENT_NAME', 'TYPEPAYMENT_STATUS', '1');
        $data['payment'] = $this->payment_model->paySplit($data['serviceID'], $serviceNo);
        $data['page'] = 'paymentsplit_view';
        $this->load->view('admin/servicemain_view', $data);
    }

    public function insertSplitPayment()
    {
        $memberType = $this->input->post('member');
        $receiptID = $this->genIdReceipt();
        $receiptDate = date('y-m-d');
        $receiptTime = date('H:i');
        $receiptDiscountTotal =   $this->input->post('totalDiscount');
        $receiptPriceDiscount = $this->input->post('totalPrice');
        $receiptVat = $this->input->post('totalVat');
        $receiptPriceTotal = $this->input->post('total');
        $receiptPayAll = $this->input->post('payAll');
        $receiptPayChange = $this->input->post('payChange');
        $receiptDetailTpyeOrder = $this->input->post('tpyeOrder');
        $receiptDetailPriceUnit = $this->input->post('sellPrice');
        $receiptDetailAmount = $this->input->post('Amount');
        $receiptDetailDiscount = $this->input->post('discount');
        $receiptDetailPriceAll = $this->input->post('sumPrice');
        $receiptDetailOrderID = $this->input->post('orderID');
        $receiptDetailCostFD = $this->input->post('costPrice');
        $receiptDetailCostFD = $this->input->post('costPrice');
        $receiptDetailProprice = $this->input->post('proprice');
        $receiptDetailKaraokeUseType = $this->input->post('karaokeUsetype');
        $typePaymentID = $this->input->post('typepaymentID');
        $pricePayment = $this->input->post('pricePayment');
        $serviceID = $this->input->post('serviceID');
        $serviceNO = $this->input->post('serviceNO');
        $splitOrderAmount = $this->input->post('splitOrderAmount');
        if ($memberType == '1') {
            $dataHeadReceipt = array(
                'RECEIPT_ID' => $receiptID,
                'RECEIPT_MEMBER' => null,
                'RECEIPT_EMPLOYEE' => $_SESSION['employeeID'],
                'RECEIPT_DATE' => $receiptDate,
                'RECEIPT_TIME' => $receiptTime,
                'RECEIPT_DISCOUNTTOTAL' => $receiptDiscountTotal,
                'RECEIPT_PRICEDISCOUNT' => $receiptPriceDiscount,
                'RECEIPT_VAT' => $receiptVat,
                'RECEIPT_PRICETOTAL' => $receiptPriceTotal,
                'RECEIPT_PAYALL' => $receiptPayAll,
                'RECEIPT_PAYCHANGE' => $receiptPayChange,
                'RECEIPT_STATUS' => '1',
            );
        } else {
            $memberID = $this->input->post('memberID');
            $dataHeadReceipt = array(
                'RECEIPT_ID' => $receiptID,
                'RECEIPT_MEMBER' => $memberID,
                'RECEIPT_EMPLOYEE' => $_SESSION['employeeID'],
                'RECEIPT_DATE' => $receiptDate,
                'RECEIPT_TIME' => $receiptTime,
                'RECEIPT_DISCOUNTTOTAL' => $receiptDiscountTotal,
                'RECEIPT_PRICEDISCOUNT' => $receiptPriceDiscount,
                'RECEIPT_VAT' => $receiptVat,
                'RECEIPT_PRICETOTAL' => $receiptPriceTotal,
                'RECEIPT_PAYALL' => $receiptPayAll,
                'RECEIPT_PAYCHANGE' => $receiptPayChange,
                'RECEIPT_STATUS' => '1',
            );
        }
        $this->crud_model->insert('receipt', $dataHeadReceipt);

        for ($i = 0; $i < count($receiptDetailTpyeOrder); $i++) {
            $dataReceiptDetail = array(
                'DTREC_ID' => $receiptID,
                'DTREC_NO' => $i + 1,
                'DTREC_TYPEORDER' => $receiptDetailTpyeOrder[$i],
                'DTREC_PRICEUNIT' => $receiptDetailPriceUnit[$i],
                'DTREC_AMOUNT' => $receiptDetailAmount[$i],
                'DTREC_DISCOUNTALL' => $receiptDetailDiscount[$i],
                'DTREC_PRICEALL' => $receiptDetailPriceAll[$i],
            );
            $this->crud_model->insert('receiptdetail', $dataReceiptDetail);

            if ($receiptDetailTpyeOrder[$i] == '1') {
                $proprice = null;
                if ($receiptDetailProprice[$i] != '' || $receiptDetailProprice[$i] != null) {
                    $proprice = $receiptDetailProprice[$i];
                }
                $dataReceiptDetailFD = array(
                    'FDDTREC_ID' => $receiptID,
                    'FDDTREC_NO' => $i + 1,
                    'FDDTREC_PRODUCTID' => $receiptDetailOrderID[$i],
                    'FDDTREC_COSTPRICE' => $receiptDetailCostFD[$i],
                    'FDDTREC_PROPRICEID' => $proprice,
                );
                $this->crud_model->insert('receiptdetailfd', $dataReceiptDetailFD);
            } else if ($receiptDetailTpyeOrder[$i] == '2') {
                $dataReceiptDetailProset = array(
                    'PROSDTREC_ID' => $receiptID,
                    'PROSDTREC_NO' => $i + 1,
                    'PROSDTREC_PROSET' => $receiptDetailOrderID[$i],
                );
                $this->crud_model->insert('receiptdetailproset', $dataReceiptDetailProset);
                $DetailProset = $this->payment_model->detailProset($receiptDetailOrderID[$i]);
                foreach ($DetailProset as $rowDetailSet) {
                    $dataDetailProset = array(
                        'DPRODTREC_ID' => $receiptID,
                        'DPRODTREC_NO' => $i + 1,
                        'DPRODTREC_DETAILNO' => $rowDetailSet->PROSETDETAIL_NO,
                        'DPRODTREC_COSTPRICE' => $rowDetailSet->PRODUCT_COSTPRICE,
                        'DPRODTREC_SELLPRICE' => $rowDetailSet->PRODUCT_SELLPRICE,
                        'DPRODTREC_AMOUNT' => ($rowDetailSet->PROSETDETAIL_AMOUNT * $receiptDetailAmount[$i]),
                        'DPRODTREC_PRODUCT' => $rowDetailSet->PRODUCT_ID,
                    );
                    $this->crud_model->insert('receiptdetailprosetdetail', $dataDetailProset);
                };
            } else if ($receiptDetailTpyeOrder[$i] == '3') {
                $dataReceiptDetailKaraoke = array(
                    'KARADTREC_ID' => $receiptID,
                    'KARADTREC_NO' => $i + 1,
                    'KARADTREC_KARAOKEID' => $receiptDetailOrderID[$i],
                    'KARADTREC_USETYPE' => $receiptDetailKaraokeUseType[$i],
                );
                $this->crud_model->insert('receiptdetailkaraoke', $dataReceiptDetailKaraoke);
            }
        }
        for ($i = 0; $i < count($typePaymentID); $i++) {
            $dataSplitPayment = array(
                'SPLITPAY_RECEIPTID' => $receiptID,
                'SPLITPAY_TYPEPAYMENTID' => $typePaymentID[$i],
                'SPLITPAY_AMOUNT' => $pricePayment[$i],
            );
            $this->crud_model->insert('splitpay', $dataSplitPayment);
        }
        for ($k = 0; $k < count($serviceID); $k++) {
            $dataServiceReceipt = array(
                'SERREC_RECID' => $receiptID,
                'SERREC_SERID' => $serviceID[$k],
            );
            $this->crud_model->insert('receiptofservice', $dataServiceReceipt);
            for ($s = 0; $s < count($serviceNO); $s++) {
                $remainder = $splitOrderAmount[$s];
                $this->payment_model->updateSplitRemainder($serviceID[$k], $serviceNO[$s], $remainder);
            }
            $CheckRemainder = $this->payment_model->checkServiceRemainder($serviceID[$k]);
            foreach ($CheckRemainder as $rowk) {
                if ($rowk->Allcnt == $rowk->cnt) {
                    $dataHeadService = array(
                        'SERVICE_STATUS' => '2'
                    );
                    $this->crud_model->update('service', $dataHeadService, 'SERVICE_ID', $serviceID[$k]);
                    $seatID = $this->crud_model->findSelectWhere('serviceseat', 'SERSEAT_SEATID,SERSEAT_SEATSPLIT', 'SERSEAT_SERVICEID', $serviceID[$k]);
                    foreach ($seatID as $rowSeat) {
                        if ($rowSeat->SERSEAT_SEATSPLIT == null || $rowSeat->SERSEAT_SEATSPLIT == '') {
                            $dataSeatActive = array(
                                'SEAT_ACTIVE' => '0'
                            );
                            $this->crud_model->update('seat', $dataSeatActive, 'SEAT_ID', $rowSeat->SERSEAT_SEATID);
                        } else {
                            $cntSeatSplit =  $this->service_model->checkCancelServiceSplit($rowSeat->SERSEAT_SEATID);
                            if ($cntSeatSplit == 0) {
                                $statusSeat = array(
                                    'SEAT_ACTIVE' => '0'
                                );
                                $this->crud_model->update('seat', $statusSeat, 'SEAT_ID', $rowSeat->SERSEAT_SEATID);
                            }
                        }
                    }
                }
            }
        }

        $data['url'] = site_url('admin/service/instore');
        echo json_encode($data);
    }


    public function historyPayment()
    {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('admin/payment/historyPayment');
        $config['total_rows'] = $this->payment_model->countAllHistoryPayment($search);
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
        $data['historyPayment'] = $this->payment_model->historyPayment($search, $limit, $offset);
        $data['links'] = $this->pagination->create_links();
        $data['page'] = 'paymenthistory_view';
        $this->load->view('admin/servicemain_view', $data);
    }


    public function bill()
    {
        $data['HeadReceipt'] = $this->payment_model->paymentBillHead('REC2104180007');
        $data['BodyReceipt'] = $this->payment_model->paymentBillBody('REC2104180007');

        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('admin/paymentbill_view',$data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function paymentBill($receipID)
    {
        // echo "
        // <script language=\"JavaScript\">
        // var url = 'http://localhost/food/index.php/admin/payment/historyPayment';
        // function openWindow( url )
        // {
        // window.open(url, '_blank');
        // window.focus();
        // }
        // openWindow(url);
        // </script>";
        $this->load->view('admin/paymentbill_view');
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
                return 'TP' . $y . '001';
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
