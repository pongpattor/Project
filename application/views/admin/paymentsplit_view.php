<br>
<div class="row">
    <div class="col-12">
        <div class="card  boder-0 shadow-lg">
            <div class="card-header bg-light text-center">
                <h3 class="d-inline">ชำระเงิน</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<form action="#" id="paymentForm">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="sellTable">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="text-align: center;">#</th>
                                                    <th style="text-align: center;">รายการ</th>
                                                    <th style="text-align: center;">ราคา/หน่วย</th>
                                                    <th style="text-align: center;">จำนวน</th>
                                                    <th style="text-align: center;">ส่วนลด</th>
                                                    <th style="text-align: center;">ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="serviceID[]" class="serviceID" value="<?= $serviceID ?>">
                                                <?php foreach ($serviceNo as $rowNo) : ?>
                                                    <input type="hidden" name="serviceNO[]" value="<?= $rowNo ?>">
                                                <?php endforeach; ?>
                                                <?php foreach ($splitOrderAmount as $rowAmount) : ?>
                                                    <input type="hidden" name="splitOrderAmount[]" value="<?= $rowAmount ?>">
                                                <?php endforeach; ?>

                                                <?php $rowi = 1;
                                                foreach ($payment as $row) : ?>
                                                    <?php
                                                    if (($row->PROMOTIONPRICE_ID == '' || $row->PROMOTIONPRICE_ID == null) && $row->DTSER_TYPEORDER != '2') {
                                                        $class = 'noPro';
                                                    } else {
                                                        $class = 'havePro';
                                                    }
                                                    ?>
                                                    <tr id="row<?= $rowi; ?>" class="bgtable <?= $class ?> trrow">
                                                        <td class="align-middle" style="text-align: center;"><?= $rowi; ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $row->ORDERNAME; ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->SELLPRICE, 2); ?></td>

                                                        <?php $amount = 0;
                                                        $rows = 0;
                                                        foreach ($splitOrderID as $rowsplit) {
                                                            if ($rowsplit == $row->ORDERID) {
                                                                $amount += $splitOrderAmount[$rows];
                                                            }
                                                            $rows++;
                                                        } ?>
                                                        <td class="align-middle" style="text-align: center;"><?= $amount; ?></td>
                                                        <?php
                                                        if ($row->DISCOUNT == '' || $row->DISCOUNT == null) {
                                                            $discount =  number_format(0, 2);
                                                        } else {
                                                            $discount =  number_format(intval(($row->DISCOUNT * $amount) + 0.50), 2);
                                                        }
                                                        $sumprice = ($row->SELLPRICE*$amount)-$discount;
                                                        ?>
                                                        <td class="align-middle" style="text-align: center;"><span class="showDiscount"><?= $discount ?></span></td>
                                                        <?php $sumprice = number_format($sumprice, 2); ?>
                                                        <td class="align-middle" style="text-align: center;"><span class="showSumprice"><?= $sumprice; ?></span>
                                                            <input type="hidden" name="orderID[]" class="orderID" value="<?= $row->ORDERID; ?>">
                                                            <input type="hidden" name="tpyeOrder[]" class="tpyeOrder" value="<?= $row->DTSER_TYPEORDER; ?>">
                                                            <input type="hidden" name="karaokeUsetype[]" class="karaokeUsetype" value="<?= $row->KARADTSER_USETYPE; ?>">
                                                            <input type="hidden" name="costPrice[]" class="costPrice" value="<?= $row->COSTPRICE; ?>">
                                                            <input type="hidden" name="sellPrice[]" class="sellPrice" value="<?= $row->SELLPRICE; ?>">
                                                            <input type="hidden" name="Amount[]" class="Amount" value="<?= $amount; ?>">
                                                            <input type="hidden" name="discount[]" class="discount" value="<?= $discount ?>">
                                                            <input type="hidden" name="sumPrice[]" class="sumPrice" value="<?= $sumprice ?>">
                                                            <input type="hidden" name="proprice[]" class="proprice" value="<?= $row->PROMOTIONPRICE_ID ?>">
                                                        </td>
                                                    </tr>
                                                <?php $rowi++;
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-4">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="3" class="align-middle">
                                        <div class="form-check">
                                            <input class="form-check-input typeMember" type="radio" name="member" id="member1" value="1" checked>
                                            <label class="form-check-label" for="member1">
                                                ไม่มีสมาชิก
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="align-middle" colspan="2">
                                        <div class="form-check">
                                            <input class="form-check-input typeMember" type="radio" name="member" id="member2" value="2">
                                            <label class="form-check-label" for="member2">
                                                สมาชิก
                                            </label>
                                        </div>
                                    </th>
                                    <th class="align-middle">
                                        <div class="input-group">
                                            <input type="tel" class="form-control searchTel" name="tel" id="tel" placeholder="กรอกเบอร์โทร" maxlength="10" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="input-group-text searchTel btnsearchTel" disabled><i class="fa fa-search searchTel"></i></button>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="align-middle" colspan="2">
                                        <span id="nameMember"></span>
                                        <input type="hidden" name="memberID" id="memberID" disabled>
                                    </th>
                                    <th class="align-middle"><span id="discountMember"></span></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                        <div class="table-responsive">
                                <table class="table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="align-middle">
                                                ราคาทั้งหมด
                                            </th>
                                            <th class="align-middle text-right">
                                                <span id="freePriceShow"></span>
                                                <input type="hidden" id="freePrice" name="freePrice" class="form-control" readonly>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="align-middle">
                                                ส่วนลด
                                            </th>
                                            <th class="align-middle text-right">
                                                <span id="totalDiscountShow"></span>
                                                <input type="hidden" id="totalDiscount" name="totalDiscount" class="form-control" readonly>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="align-middle">
                                                ราคารวม
                                            </th>
                                            <th class="align-middle text-right">
                                                <span id="totalPriceShow"></span>
                                                <input type="hidden" id="totalPrice" name="totalPrice" class="form-control" readonly>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="align-middle ">
                                                ภาษี7%
                                            </th>
                                            <th class="align-middle text-right">
                                                <span id="totalVatShow"></span>
                                                <input type="hidden" name="totalVat" id="totalVat" class="form-control" readonly>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="align-middle">
                                                ราคาสุทธิ
                                            </th>
                                            <th class="align-middle text-right">
                                                <span id="totalShow" ></span>
                                                <input type="hidden" name="total" id="total" class="form-control" readonly>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col ">
                            <div class="row ">
                                <div class="col">
                                    <table class="table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">ประเภทชำระเงิน</th>
                                                <th class="align-middle">จำนวนเงิน</th>
                                                <th class="align-middle">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#typePaymentModal">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    <div class="modal fade" id="typePaymentModal" tabindex="-1" role="dialog" aria-labelledby="typePaymentModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="typePaymentModalLabel">ประเภทการชำระเงิน</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="typepaymentTable">
                                                                            <thead class="thead-dark">
                                                                                <tr>
                                                                                    <th style="text-align: center;">รหัส</th>
                                                                                    <th style="text-align: center;">ชื่อประเภท</th>
                                                                                    <th style="text-align: center;">เลือก</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="bodySelectTypePayment">
                                                                                <?php $j = 1;
                                                                                foreach ($typepayment as $row2) : ?>
                                                                                    <tr id="<?= $j ?>">
                                                                                        <td class="align-middle" style="text-align: center;"><?= $row2->TYPEPAYMENT_ID; ?></td>
                                                                                        <td class="align-middle" style="text-align: center;"><?= $row2->TYPEPAYMENT_NAME; ?></td>
                                                                                        <td class="align-middle" style="text-align: center;"><button type="button" class="btn btn-info selectTypepayment">เลือก</button></td>
                                                                                    </tr>
                                                                                <?php $j++;
                                                                                endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="paymentBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col"><label for="payAll">จ่ายเงินทั้งหมด</label><input type="text" name="payAll" id="payAll" value="0" class="form-control" readonly></div>
                            </div>
                            <div class="row">
                                <div class="col"><label for="payChange">เงินทอน</label><input type="text" name="payChange" id="payChange" value="0" class="form-control" readonly></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col"><button class="btn btn-success form-control">ชำระเงิน</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('#typepaymentTable').dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "language": {
                "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
                "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
            }
        });


        function checkAllTypepayment(typepaymentID) {
            var checkType = true;
            var rowid;

            $('.typepaymentID').each(function() {
                rowid = $(this).parents('tr').attr('id');
                rowTypePayment = $(`#${rowid} .typepaymentID`).val();
                // console.log(rowTypePayment);
                if (rowTypePayment == typepaymentID) {
                    checkType = false;
                    return false;
                }
            });
            return checkType;
        }

        $(document).on('click', '.selectTypepayment', function() {
            var rowid = $(this).parents('tr').attr('id');
            var typepaymentID = $(`#${rowid} td:nth-child(1)`).html();
            var typepaymentName = $(`#${rowid} td:nth-child(2)`).html();
            var chk = checkAllTypepayment(typepaymentID);
            var lastid = $('#paymentBody tr:last-child').attr('id');
            if (lastid == null || lastid == '') {
                lastid = 1;
            } else {
                lastid = lastid.substr(14);
                lastid = parseInt(lastid);
                lastid += 1;
            }
            if (chk == true) {
                var table = `<tr id="rowTypePayment${lastid}" class="rowpayment">
                            <td class="align-middle" style="text-align: center; width:40%">${typepaymentName}
                            <input type="hidden" name="typepaymentID[]" class="typepaymentID" value="${typepaymentID}">
                            </td>
                            <td class="align-middle" style="text-align: center;"> 
                            <input type="number" name="pricePayment[]" class="pricePayment form-control"  min="1" value="0" required>
                            </td>
                            <td class="align-middle" style="text-align: center;"> 
                            <button type="button" class="btn btn-danger deletePayment"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        `
                $('#paymentBody').append(table);
                $(`#typePaymentModal`).modal('hide');
                payChange();
            } else {
                alert('กรุณาอย่าเลือกรายการซ้ำ')
            }
        });

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        function freeprice() {
            let freeprice = 0;
            $('.trrow').each(function() {
                let rowid = $(this).attr('id');
                let sellprice = parseInt($(`#${rowid} .sellPrice`).val());
                let amount = parseInt($(`#${rowid} .Amount`).val());
                freeprice += sellprice * amount;
            });
            freeprice = freeprice.toFixed(2);
            let show = formatNumber(freeprice);
            $('#freePrice').val(freeprice);
            $('#freePriceShow').html(show);
        }

        function total() {
            let totalprice = $('#totalPrice').val();
            let vat = $('#totalVat').val();
            let total = parseFloat(totalprice) + parseFloat(vat);
            total = parseInt(total).toFixed(2);
            $('#total').val(total);
            let show = formatNumber(total);
            $('#totalShow').html(show);
            // alert(total)
        }

        function totalVat() {
            let total = $('#totalPrice').val();
            let vat = parseFloat(total) / 7;
            vat = parseInt(vat).toFixed(2);
            $('#totalVat').val(vat);
            let show = formatNumber(vat);
            $('#totalVatShow').html(show);
            // alert(total);

        }

        function totalDiscount() {
            let totalDiscount = 0;
            $('.discount').each(function() {
                totalDiscount += parseFloat($(this).val());
            });
            totalDiscount = parseInt(totalDiscount).toFixed(2);
            $('#totalDiscount').val(totalDiscount);
            let show = formatNumber(totalDiscount);
            $('#totalDiscountShow').html(show);
        }

        function totalPrice() {
            let totalPrice = 0;
            $('.sumPrice').each(function() {
                totalPrice += parseFloat($(this).val());
            });
            totalPrice = parseInt(totalPrice).toFixed(2);
            $('#totalPrice').val(totalPrice);
            let show = formatNumber(totalPrice);
            $('#totalPriceShow').html(show);
        }
        freeprice();
        totalPrice();
        totalDiscount();
        totalVat();
        total();
        payChange();

        function Fdiscount(discountPer) {
            $('.noPro').each(function() {
                let rowid = $(this).attr('id');
                // console.log(rowid);
                let proid = $(`#${rowid}.noPro .proprice`).val();
                let discountMember = 0;
                // console.log(proid);
                if (proid == null || proid == '') {
                    let sellPrice = $(`#${rowid}.noPro .sellPrice`).val();
                    let amount = $(`#${rowid}.noPro .Amount`).val();
                    let sumprice = parseFloat(sellPrice) * parseFloat(amount);
                    let sumpriceNew = 0;
                    let discount = 0;
                    discount = ((parseFloat(sellPrice) * parseFloat(amount)) / 100) * parseFloat(discountPer);
                    sumpriceNew = (sumprice - discount) + 0.50;
                    discount = parseInt(discount).toFixed(2);
                    sumpriceNew = parseInt(sumpriceNew).toFixed(2);
                    $(`#${rowid}.noPro .discount`).val(discount);
                    $(`#${rowid}.noPro .sumPrice`).val(sumpriceNew);
                    $(`#${rowid}.noPro .showSumprice`).html(sumpriceNew);
                    $(`#${rowid}.noPro .showDiscount`).html(discount);
                }

            });
        }


        $(document).on('change', '.typeMember', function() {
            var typeMember = $(this).val();
            if (typeMember == 1) {
                $('.searchTel').prop('disabled', true);
                $('#nameMember').css("color", "");
                $('#nameMember').html('');
                $('#memberID').val('');
                $('#memberID').prop('disabled', true);
                $('#discountMember').html('');
                Fdiscount(0)
                totalPrice();
                totalDiscount();
                totalVat();
                total();
                freeprice();
                payChange();

            } else {
                $('.searchTel').prop('disabled', false);
                $('#memberID').prop('disabled', false);
            }
        });

        $(document).on('click', '.btnsearchTel', function() {
            var tel = $('#tel').val();
            if (tel.length == 10) {
                $.ajax({
                    url: "<?= site_url('admin/payment/telMemberDiscount') ?>",
                    method: "POST",
                    data: {
                        tel: tel,
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.search == true) {
                            $('#nameMember').css("color", "");
                            $(data.member).each(function(key, value) {
                                $('#nameMember').html(value.CUSTOMER_FIRSTNAME + ' ' + value.CUSTOMER_LASTNAME);
                                $('#discountMember').html('ส่วนลด ' + value.discount + '% ' + value.discountName);
                                $('#memberID').val(value.CUSTOMER_ID);
                                Fdiscount(value.discount);
                                totalPrice();
                                totalDiscount();
                                totalVat();
                                total();
                                freeprice();
                                payChange();

                            });
                        } else {
                            $('#nameMember').css("color", "red");
                            $('#nameMember').html('ไม่มีพบเบอร์สมาชิก');
                            $('#memberID').val('');
                            $('#discountMember').html('');

                        }
                    }
                });
            } else {
                $('#nameMember').html('กรุณากรอกเบอร์โทรให้ถูกต้อง');
                $('#nameMember').css("color", "red");
                $('#memberID').val('');
            }
            $('#tel').val('');
        });

        function payChange() {
            let sumpay = 0;
            let paychange = 0;
            let total = parseInt($('#total').val());
            $('.pricePayment').each(function() {
                sumpay += parseInt($(this).val());
            });
            $('#payAll').val(sumpay);
            paychange = sumpay - total;
            $('#payChange').val(paychange);
        }

        $(document).on('change', '.pricePayment', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                $(this).val(1);
            }
            payChange();
        });

        $(document).on('click', '.deletePayment', function() {
            var rowid = $(this).parents('tr').attr('id');
            $(`#${rowid}`).remove();
            $('#payAll').val(0);
            payChange();
        });

        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            let total = parseInt($('#total').val());
            if (total > 0) {
                if ($('.typeMember:checked').val() == '2') {
                    if ($('#memberID').val() == null || $('#memberID').val() == '') {
                        alert('กรุณาเลือกสมาชิก')
                    } else {
                        if (parseInt($('#payAll').val()) < parseInt($('#total').val())) {
                            alert('กรุณาจ่ายเงินให้ครบ');
                        } else {
                            $.ajax({
                                url: "<?= site_url('admin/payment/insertSplitPayment') ?>",
                                method: "POST",
                                data: $(this).serialize(),
                                dataType: "JSON",
                                success: function(data) {
                                    alert('ชำระเงินเสร็จสิ้น');
                                    location.replace(data.url);
                                }
                            });
                        }
                    }
                } else {
                    if (parseInt($('#payAll').val()) < parseInt($('#total').val())) {
                        alert('กรุณาจ่ายเงินให้ครบ');
                    } else {
                        $.ajax({
                            url: "<?= site_url('admin/payment/insertSplitPayment') ?>",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "JSON",
                            success: function(data) {
                                alert('ชำระเงินเสร็จสิ้น');
                                location.replace(data.url);
                            }
                        });
                    }
                }
            } else {
                alert('กรุณาสั่งสินค้าก่อน')
            }
        });
    });
</script>