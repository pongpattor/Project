<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">ย้ายโต๊ะ</h3>
            </div>
        </div>
    </div>
</div>
<br>
<form id="changeSeatForm">
    <div class="row">
        <div class="col">
            <div class="card boder-0  shadow-lg text-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col " id="textWarning">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="card boder-0 shadow-lg h-100">
                                <div class="card-header bg-dark text-white ">
                                    <h4 class="d-inline">โต๊ะว่าง</h4>
                                </div>
                                <div class="card-body">

                                    <?php $inputNo = 1;
                                    foreach ($zone as $row) : ?>
                                        <h4><?= $row->ZONE_NAME; ?></h4>
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table style="width: 100%;">
                                                    <tbody>
                                                        <?php foreach ($deskEmpty as $row2) : ?>
                                                            <?php if ($row->ZONE_ID == $row2->SEAT_ZONE) { ?>
                                                                <tr class="d-flex form-check form-check-inline" id="rowDe<?= $inputNo; ?>">
                                                                    <td class="col-3">
                                                                        <input class="form-check-input useDeskEmpty" type="checkbox" name="deskEmpty[]" id="deskEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                        <input type="hidden" name="deskZoneE[]" class="deskZoneE" value="<?= $row2->SEAT_ZONE ?>" disabled>
                                                                    </td>
                                                                    <td class="col-6">
                                                                        <label class="form-check-label" for="deskEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME ?></label>

                                                                    </td>
                                                                    <td class="col-3">
                                                                        <span><?= '<span class="seatAmount">' . $row2->SEAT_AMOUNT . '</span> ที่นั่ง'; ?></span>
                                                                    </td>
                                                                </tr>
                                                            <?php $inputNo++;
                                                            } ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="card boder-0 shadow-lg h-100">
                                <div class="card-header  bg-dark text-white ">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="d-inline ">
                                                ห้องคาราโอเกะว่าง
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                        </div>
                                    </div>
                                    <?php
                                    foreach ($zone as $row) : ?>
                                        <h4><?= $row->ZONE_NAME; ?></h4>
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table style="width: 100%;">
                                                    <tbody>
                                                        <?php foreach ($karaokeEmpty as $row2) : ?>
                                                            <?php if ($row->ZONE_ID == $row2->SEAT_ZONE) { ?>
                                                                <tr class="d-flex form-check form-check-inline" id="rowka<?= $inputNo; ?>">
                                                                    <td class="col-2 ">
                                                                        <input class="form-check-input useKaraokeEmpty" type="checkbox" name="karaokeEmpty[]" id="karaokeEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                        <label class="form-check-label" for="karaokeEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME . '<br>  (<span class="seatAmount">' . $row2->SEAT_AMOUNT . '</span> ที่นั่ง )'; ?></label>
                                                                        <input type="hidden" name="KaraokeZoneE[]" class="KaraokeZoneE" value="<?= $row2->SEAT_ZONE ?>" disabled>
                                                                    </td>
                                                                    <td class="col-2"><?= 'เหมา <br>' . $row2->KARAOKE_FLATRATE . ' &#3647' ?> </td>
                                                                    <td class="col-2"><?= 'ชม. <br>' . $row2->KARAOKE_PRICEPERHOUR . ' &#3647' ?></td>

                                                                    <td class="col">
                                                                        <select name="karaokeUsetype" class="form-control karaokeUseTypeE" class="form-control" required disabled>
                                                                            <option value="" disabled selected>เลือกการใช้งาน</option>
                                                                            <option value="1">เหมาห้อง </option>
                                                                            <option value="2">รายชั่วโมง</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="col-2"> <input type="number" name="karaokeUseAmount" class="form-control karaokeUseAmountE" min="1" max="1" value="1" required disabled>
                                                                    </td>
                                                                </tr>

                                                            <?php $inputNo++;
                                                            } ?>

                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card boder-0 shadow-lg ">
                                <div class="card-header bg-dark text-white  ">
                                    <h4 class="d-inline">โต๊ะปัจจุบัน </h4>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table style="width: 100%;">
                                                <tbody>
                                                <input type="hidden" name="serviceID" value="<?=$this->input->get('serviceID');?>">
                                                    <?php $rowc = 1;
                                                    $cusAmount = 0;
                                                    $seatAmount = 0;
                                                    foreach ($seatCurrent as $rowCur) : ?>
                                                        <?php

                                                        if ($rowc == 1) { ?>
                                                            <h4><?= $rowCur->ZONE_NAME; ?></h4>

                                                        <?php $cusAmount += $rowCur->SERVICE_CUSAMOUNT;
                                                        }
                                                        $seatAmount += $rowCur->SEAT_AMOUNT; ?>
                                                        <?php if ($rowCur->SEAT_TYPE == '1') { ?>
                                                            <tr class="d-flex form-check form-check-inline" id="rowDe<?= $inputNo; ?>">
                                                                <td class="col-3">
                                                                    <input class="form-check-input useDeskEmpty" type="checkbox" name="deskEmpty[]" id="deskEmpty<?= $inputNo; ?>" value="<?= $rowCur->SEAT_ID; ?>">
                                                                    <input type="hidden" name="deskZoneE[]" class="deskZoneE" value="<?= $rowCur->ZONE_ID ?>" disabled>
                                                                </td>
                                                                <td class="col-6">
                                                                    <label class="form-check-label" for="deskEmpty<?= $inputNo; ?>"><?= $rowCur->SEAT_NAME ?></label>
                                                                </td>
                                                                <td class="col-3">
                                                                    <span><?= '<span class="seatAmount">' . $rowCur->SEAT_AMOUNT . '</span> ที่นั่ง'; ?></span>
                                                                </td>
                                                            </tr>
                                                        <?php } else { ?>
                                                            <tr class="d-flex form-check form-check-inline" id="rowka<?= $inputNo; ?>">
                                                                <td class="col-3">
                                                                    <input class="form-check-input useKaraokeEmpty" type="checkbox" name="karaokeEmpty[]" id="karaokeEmpty<?= $inputNo; ?>" value="<?= $rowCur->SEAT_ID; ?>">
                                                                    <label class="form-check-label" for="karaokeEmpty<?= $inputNo; ?>"><?= $rowCur->SEAT_NAME . '  (<span class="seatAmount">' . $rowCur->SEAT_AMOUNT . '</span> ที่นั่ง )'; ?></label>
                                                                    <input type="hidden" name="KaraokeZoneE[]" class="KaraokeZoneE" value="<?= $rowCur->ZONE_ID ?>" disabled>
                                                                </td>
                                                                <td class="col-2"><?= 'เหมา <br>' . $rowCur->KARAOKE_FLATRATE . ' &#3647' ?> </td>
                                                                <td class="col-2"><?= 'ชม. <br>' . $rowCur->KARAOKE_PRICEPERHOUR . ' &#3647' ?></td>

                                                                <td style="width:25%"> <select name="karaokeUsetype" class="form-control karaokeUseTypeE" class="form-control" required disabled>
                                                                        <option value="" disabled selected>เลือกการใช้งาน</option>
                                                                        <option value="1">เหมาห้อง </option>
                                                                        <option value="2">รายชั่วโมง</option>
                                                                    </select></td>
                                                                <td class="col-2"> <input type="number" name="karaokeUseAmount" class="form-control karaokeUseAmountE" min="1" max="1" value="1" required disabled>
                                                                </td>
                                                            </tr>
                                                        <?php  } ?>
                                                    <?php $rowc++;
                                                        $inputNo++;
                                                    endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-10" id="enterServiceDetail">
                                        <label for="AmountCustomer">จำนวนผู้เข้าใช้</label>
                                        <input type="number" class="form-control text-center" id="AmountCustomerE" name="AmountCustomerE" required value="<?= $cusAmount ?>">
                                        <input type="hidden" id="cusAmountOriginal" value="<?= $cusAmount ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <label for="seatAmountAllE">ที่นั่งทั้งหมด</label>
                                        <input type="text" class="form-control text-center" id="seatAmountAllE" name="seatAmountAllE" disabled value="0">
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="mt-auto col">
                                        <button type="submit" id="enterService" class="btn btn-success form-control ">ย้าย</button>
                                    </div>
                                </div>
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
        $('#AmountCustomerE').on('change', function() {
            var AmountOri = $('#cusAmountOriginal').val();
            if ($(this).val() == null || $(this).val() == '') {
                $(this).val(AmountOri);
            }
        });

        $('.useKaraokeEmpty').on('change', function() {
            var rowid = $(this).parents('tr').attr('id');
            if ($(this).prop('checked') == true) {
                $(`#${rowid} .KaraokeZoneE`).prop('disabled', false);
                $(`#${rowid} td:nth-child(4) .karaokeUseTypeE`).prop('disabled', false);
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop('disabled', false);
            } else {
                $(`#${rowid} .KaraokeZoneE`).prop('disabled', true);
                $(`#${rowid} td:nth-child(4) .karaokeUseTypeE`).prop('disabled', true);
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop('disabled', true);
            }
            seatAmountAllE();
        });

        $('.karaokeUseTypeE').on('change', function() {
            var rowid = $(this).parents('tr').attr('id');
            var type = $(this).val();
            if (type == '1') {
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop({
                    'min': 1,
                    'max': 1,
                    'value': 1,
                });
            } else {
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop({
                    'min': 1,
                    'max': 24,
                    'value': 1,
                });
            }
        });

        function seatAmountAllE() {
            var total = 0;
            var desk = 0;
            var karaoke = 0;
            $('.useDeskEmpty:checked').each(function() {
                var rowid = $(this).parents('tr').attr('id');
                desk += parseInt($(`#${rowid} .seatAmount`).html());
            });
            $('.useKaraokeEmpty:checked').each(function() {
                var rowid = $(this).parents('tr').attr('id');
                karaoke += parseInt($(`#${rowid} .seatAmount`).html());
            });
            total = desk + karaoke;
            $('#seatAmountAllE').val(total);
            if (total == 0) {
                $('#AmountCustomerE').prop('max', '');
            } else {
                $('#AmountCustomerE').prop('max', total);

            }

        }

        function validateChangeSeat() {
            var seatAmount = parseInt($('#seatAmountAllE').val());
            var AmountCustomer = parseInt($('#AmountCustomerE').val());
            if (seatAmount == 0) {
                text = `<div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกที่นั่ง
                                 </div>`
                $('#textWarning').html(text);
                return false;
            } else if (seatAmount < AmountCustomer) {
                text = `<div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> จำนวนคนมากกว่าจำนวนที่นั่ง
                                 </div>`
                $('#textWarning').html(text);
                return false;
            } else {
                var serviceType = $('.enterServiceType:checked').val();
                var d = 0;
                var k = 0;
                $('.useDeskEmpty:checked').each(function() {
                    d++;
                });
                $('.useKaraokeEmpty:checked').each(function() {
                    k++;
                });
                let cusamount = parseInt($('#AmountCustomerE').val());
                if (cusamount > seatAmount) {
                    text = `<div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> จำนวนคนมากกว่าจำนวนที่นั่ง
                                 </div>`
                    $('#textWarning').html(text);
                    return false;
                } else {
                    if (d > 0 && k > 0) {
                        text = `<div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกเฉพาะโต๊ะหรือเฉพาะห้องคาราโอเกะ
                                 </div>`
                        $('#textWarning').html(text);
                        return false;

                    } else if (d == 0 && k == 0) {
                        text = ` <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกที่นั่ง
                                 </div>`
                        $('#textWarning').html(text);
                        return false;

                    } else if (d > 0 && k == 0) {
                        let zoneList = [];
                        let ZoneFalse = 0;
                        $(`.deskZoneE:not(:disabled)`).each(function() {
                            var zoneV = $(this).val();
                            zoneList.push(zoneV);
                        });
                        for (var i = 0; i < zoneList.length; i++) {
                            for (var j = 0; j < zoneList.length; j++) {
                                if (i == j) {
                                    continue;
                                } else if (zoneList[i] != zoneList[j]) {
                                    Errors = 1;
                                    ZoneFalse = 1;
                                    break;
                                }
                            }
                            if (ZoneFalse == 1) {
                                text = `  
                                <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกโซนเดียวกัน
                                </div>`
                                $('#textWarning').html(text);

                                break;
                            } else {
                                $('#textWarning').html('');
                                return true;
                            }
                        }
                        return false;
                    } else if (d == 0 && k > 1) {
                        text = ` <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกห้องคาราโอเกะเพียงห้องเดียว
                            </div>
                                `
                        $('#textWarning').html(text);
                        return false;
                    } else {
                        $('#textWarning').html('');
                        return true;

                    }
                }

            }
        }

        $(document).on('change', '.useDeskEmpty', function() {
            var rowid = $(this).parents('tr').attr('id');
            if ($(this).prop('checked') == true) {
                $(`#${rowid} .deskZoneE`).prop('disabled', false)
            } else {
                $(`#${rowid} .deskZoneE`).prop('disabled', true)
            }
            seatAmountAllE();
        });

        $('#changeSeatForm').on('submit', function(e) {
            e.preventDefault();
            var res = validateChangeSeat();
            if (res == true) {
                $.ajax({
                    url: "<?= site_url('admin/service/changeSeat') ?>",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        alert('ย้ายโต๊ะเสร็จสิ้น');
                        location.reload();
                        // console.log(data);
                    }
                });
            }

        });
    });
</script>