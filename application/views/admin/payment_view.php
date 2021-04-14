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
                                            <input type="hidden" name="serviceID" class="serviceID" value="<?= $this->input->get('serviceID') ?>">
                                            <input type="hidden" name="typePayment" class="typePayment" value="<?= $this->input->get('typePayment') ?>">
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
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SELLPRICE; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->AMOUNT; ?></td>
                                                    <?php
                                                    if ($row->DISCOUNT == '' || $row->DISCOUNT == null) {
                                                        $discount =  number_format(0.00, 2);
                                                    } else {
                                                        $discount =  number_format(intval(($row->DISCOUNT * $row->AMOUNT) + 0.50), 2);
                                                        // $discount = ($row->DISCOUNT * $row->AMOUNT)+0.50;
                                                    }
                                                    ?>
                                                    <td class="align-middle" style="text-align: center;"><span class="showDiscount"><?= $discount ?></span></td>
                                                    <?php $sumprice = number_format($row->SUMPRICE - $discount, 2); ?>
                                                    <td class="align-middle" style="text-align: center;"><span class="showSumprice"><?= $sumprice; ?></span>
                                                        <input type="hidden" name="costPrice" class="costPrice" value="<?= $row->COSTPRICE; ?>">
                                                        <input type="hidden" name="sellPrice" class="sellPrice" value="<?= $row->SELLPRICE; ?>">
                                                        <input type="hidden" name="Amount" class="Amount" value="<?= $row->AMOUNT; ?>">
                                                        <input type="hidden" name="discount" class="discount" value="<?= $discount ?>">
                                                        <input type="hidden" name="sumPrice" class="sumPrice" value="<?= $sumprice ?>">
                                                        <input type="hidden" name="proprice" class="proprice" value="<?= $row->PROMOTIONPRICE_ID ?>">
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
                                <th class="align-middle" colspan="2"><span id="nameMember"></span><input type="hidden" name="memberID" id="memberID" disabled></th>
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
                <div class="col-2">
                    ราคารวม <input type="text" id="totalPrice" class="form-control" readonly>
                </div>
                <div class="col-2">
                    ส่วนลด <input type="text" id="totalDiscount" class="form-control" readonly>
                </div>
                <div class="col-2">
                    ภาษี7% <input type="text" id="totalVat" class="form-control" readonly>
                </div>
                <div class="col-2">
                    ราคาสุทธิ <input type="text" id="total" class="form-control" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function total() {
            let totalprice = $('#totalPrice').val();
            let vat = $('#totalVat').val();
            let total = parseFloat(totalprice) + parseFloat(vat);
            total = parseInt(total).toFixed(2);
            $('#total').val(total);
            // alert(total)
        }

        function totalVat() {
            let total = $('#totalPrice').val();
            let vat = parseFloat(total) / 7;
            vat = parseInt(vat).toFixed(2);
            $('#totalVat').val(vat);
            // alert(total);

        }

        function totalDiscount() {
            let total = 0;
            $('.discount').each(function() {
                total += parseFloat($(this).val());
            });
            total = parseInt(total).toFixed(2);
            $('#totalDiscount').val(total);
        }

        function totalPrice() {
            let total = 0;
            $('.sumPrice').each(function() {
                total += parseFloat($(this).val());
            });
            total = parseInt(total).toFixed(2);
            $('#totalPrice').val(total);
        }

        totalPrice();
        totalDiscount();
        totalVat();
        total();

        function Fdiscount(discountPer) {
            $('.noPro').each(function() {
                let rowid = $(this).attr('id');
                // console.log(rowid);
                let proid = $(`#${rowid}.noPro .proprice`).val();
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
                                $('#discountMember').html('ส่วนลด ' + value.discount + '%');
                                $('#memberID').val(value.CUSTOMER_ID);
                                Fdiscount(value.discount);
                                totalPrice();
                                totalDiscount();
                                totalVat();
                                total();

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


    });
</script>