ฺ<br>
<div class="row">
    <div class="col">
        <div class="card boder-0  text-center">
            <div class="card-header shadow-lg bg-white">
                <h3 class="d-inline">เข้าใช้บริการ </h3>
            </div>
        </div>
    </div>
</div>
<br>
<form id="enterServiceForm">
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
                        <div class="col-6">
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
                                            <button type="button" class="btn btn-warning float-right" id="viewKaraoke" data-toggle="modal" data-target="#viewKaraokeModal">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <div class="modal fade" id="viewKaraokeModal" tabindex="-1" role="dialog" aria-labelledby="viewKaraokeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewKaraokeModalLabel">ตารางการใช้งานห้องคาราโอเกะ</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive ViewKaraokeMD" id="modal">
                                                                <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="viewKaraokeTable">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th style="text-align: center;">ห้องคาราโอเกะ</th>
                                                                            <th style="text-align: center;">โซน</th>
                                                                            <th style="text-align: center;">เวลาหมด</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="ViewKaraokeBody">
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
                                                                    <td class="col-3">
                                                                        <input class="form-check-input useKaraokeEmpty" type="checkbox" name="karaokeEmpty[]" id="karaokeEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                        <label class="form-check-label" for="karaokeEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME . '  (<span class="seatAmount">' . $row2->SEAT_AMOUNT . '</span> ที่นั่ง )'; ?></label>
                                                                        <input type="hidden" name="KaraokeZoneE[]" class="KaraokeZoneE" value="<?= $row2->SEAT_ZONE ?>" disabled>
                                                                    </td>
                                                                    <td class="col-2"><?= 'เหมา ' . $row2->KARAOKE_FLATRATE . ' &#3647' ?> </td>
                                                                    <td class="col-2"><?= 'ชม. ' . $row2->KARAOKE_PRICEPERHOUR . ' &#3647' ?></td>

                                                                    <td class="col"> <select name="karaokeUsetype" class="form-control karaokeUseTypeE" class="form-control" required disabled>
                                                                            <option value="" disabled selected>เลือกการใช้งาน</option>
                                                                            <option value="1">เหมาห้อง </option>
                                                                            <option value="2">รายชั่วโมง</option>

                                                                        </select></td>
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
                        <div class="col-3">
                            <div class="card boder-0 shadow-lg ">
                                <div class="card-header bg-dark text-white  ">
                                    <h4 class="d-inline">รายละเอียด </h4>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="row form-check form-check-inline">
                                        <div class="col-5">
                                            <input class="form-check-input enterServiceType" type="radio" name="enterServiceType" id="inlineRadio1" value="1" checked>
                                            <label class="form-check-label" for="inlineRadio1">ปกติ</label>
                                        </div>
                                        <div class="col-6">
                                            <input class="form-check-input enterServiceType" type="radio" name="enterServiceType" id="inlineRadio2" value="2">
                                            <label class="form-check-label" for="inlineRadio2">แยกโต๊ะ</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col" id="enterServiceDetail">
                                            <label for="AmountCustomer">จำนวนผู้เข้าใช้</label>
                                            <input type="number" class="form-control" id="AmountCustomerE" name="AmountCustomerE" required min="1" <?php if ($this->input->get('amount')) {
                                                                                                                                                        echo 'value=';
                                                                                                                                                        echo '"';
                                                                                                                                                        echo $this->input->get('amount');
                                                                                                                                                        echo '"';
                                                                                                                                                    } ?>>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="seatAmountAllE">ที่นั่งทั้งหมด</label>
                                            <input type="text" class="form-control" id="seatAmountAllE" name="seatAmountAllE" disabled value="0">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mt-auto">
                                        <button type="submit" id="enterService" class="btn btn-success form-control ">เข้าใช้งาน</button>
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



        $(document).on('click', '#viewKaraoke', function() {
            $.ajax({
                url: "<?= site_url('admin/service/viewKaraokeUse') ?>",
                dataType: "JSON",
                success: function(data) {
                    var time;
                    let table = `<table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="viewKaraokeTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="align-middle" style="text-align: center;">ห้องคาราโอเกะ</th>
                                            <th class="align-middle" style="text-align: center;">โซน</th>
                                            <th class="align-middle" style="text-align: center;">เวลาหมด</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ViewKaraokeBody">`;
                    $(data.ViewKaraoke).each(function(key, value) {
                        time = value.TIMEEND;
                        time = time.substr(0, 5);
                        time = time.replace(':', '.');
                        time += ' น.';
                        table += `
                                <tr>
                                <td class="align-middle" style="text-align: center;">${value.SEAT_NAME}</td>
                                <td class="align-middle" style="text-align: center;">${value.ZONE_NAME}</td>
                                <td class="align-middle" style="text-align: center;">${time}</td>
                                </tr>
                                `;
                    });
                    table += `      </tbody>
                                </table>`;
                    $('.ViewKaraokeMD').html(table);
                    $('#viewKaraokeTable').dataTable({
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
                }
            });
        });

        $('.useKaraokeEmpty').on('change', function() {
            seatAmountAllE();
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

        $('.enterServiceType').on('change', function() {
            var e = $(this).val();
            var text = '';
            if (e == '1') {
                text += `
                        <label for="AmountCustomer">จำนวนผู้เข้าใช้</label>
                        <input type="text" class="form-control" id="AmountCustomerE" name="AmountCustomerE" required>
                        `;
                $('#enterServiceDetail').html(text);
            } else {
                text += `
                <div class="table-responsive">
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>จำนวนคน</th>
                            <th><button type="button" class="btn btn-info addAmountCustomerE">+</button></th>
                        </tr>
                        </thead>
                        <tbody id="enterServiceBody">
                            <tr id="rowAC1" >
                            <td><input type="number" name="AmountCustomerE[]" class="AmountCustomerE form-control" min="1" value="1"></td>
                            <td></td>
                            </tr>
                            <tr id="rowAC2">
                            <td><input type="number" name="AmountCustomerE[]" class="AmountCustomerE form-control" min="1" value="1"></td>
                            <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                `
                $('#enterServiceDetail').html(text)
            }
        })

        $(document).on('click', '.addAmountCustomerE', function() {
            var rowACID = $('#enterServiceBody tr:last-child').attr('id');
            rowACID = rowACID.substr(5);
            rowACID = parseInt(rowACID) + 1;
            var text = `  <tr id="rowAC${rowACID}">
                            <td><input type="number" name="AmountCustomerE[]" class="AmountCustomerE form-control" min="1" value="1"></td>
                            <td><button type="button" class="btn btn-danger delAmountCustomerE">-</button></td>
                            </tr>
                            `
            $('#enterServiceBody').append(text);
        });

        $(document).on('click', '.delAmountCustomerE', function() {
            var rowACID = $(this).parents('tr').attr('id');
            $(`#${rowACID}`).remove();

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

        function validateEnterService() {
            var seatAmount = parseInt($('#seatAmountAllE').val());
            if (seatAmount == 0) {
                text = `<div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกที่นั่ง
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
                if (serviceType == '1') {

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
                } else {
                    if (d == 1 && k == 0) {
                        let cusamount = 0;
                        let seatAmount = parseInt($('#seatAmountAllE').val());
                        $('.AmountCustomerE').each(function() {
                            cusamount += parseInt($(this).val());
                        });
                        if (cusamount <= seatAmount) {
                            $('#textWarning').html('');
                            return true;
                        } else {
                            text = ` <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> จำนวนคนมากกว่าจำนวนที่นั่ง
                                 </div>`
                            $('#textWarning').html(text);
                            return false;
                        }
                    } else if (k == 1) {
                        text = ` <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> ไม่สามารถแยกห้องคาราโอเกะได้
                                 </div>`
                        $('#textWarning').html(text);
                        return false;
                    } else {
                        text = ` <div class="alert alert-danger" role="alert">
                                    <strong>คำเตือน!</strong> กรุณาเลือกเพียงโต๊ะเดียว
                                 </div>`
                        $('#textWarning').html(text);
                        return false;
                    }
                }
            }
        }

        $(document).on('change', '.useDeskEmpty', function() {
            seatAmountAllE();
            var rowid = $(this).parents('tr').attr('id');
            if ($(this).prop('checked') == true) {
                $(`#${rowid} .deskZoneE`).prop('disabled', false)
            } else {
                $(`#${rowid} .deskZoneE`).prop('disabled', true)
            }
        });


        $('#enterServiceForm').on('submit', function(e) {
            e.preventDefault();
            var res = validateEnterService();
            if (res == true) {
                $.ajax({
                    url: "<?= site_url('admin/service/insertEnterService') ?>",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function() {
                        alert('เข้าใช้งานเสร็จสิ้น');
                        location.reload();
                    }
                });
            }

        });




    });
</script>