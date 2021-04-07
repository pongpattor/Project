$(document).ready(function () {

    //QUEUE START

    $('#deskTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });

    $('#karaokeTable').dataTable({
        "lengthMenu": [
            [5, 10, 25, -1],
            [5, 10, 25, "All"]
        ], "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ], "language": {
            "emptyTable": "ไม่มีข้อมูล",
            "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
        }
    });


    $('#queueDate').on('change', function () {
        var queueDate = $(this).val();
        $.ajax({
            url: "../queue/selectSeat",
            method: "POST",
            data: {
                queueDate: queueDate,
            },
            dataType: "JSON",
            success: function (data) {
                $('#SdeskBody').html('');
                $('#SkaraokeBody').html('');
                var deskTable = "";
                var rowd = 1;
                deskTable += `
                <table id="deskTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>โซน</th>
                        <th>จำนวนคน</th>
                        <th>เลือก</th> 
                    </tr>
                </thead>
                <tbody id="deskBody">
                `;
                var karaokeTable = "";
                var rowk = 1;
                karaokeTable += `
                <table id="karaokeTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>โซน</th>
                        <th>จำนวนคน</th>
                        <th>ราคาชั่วโมง</th>
                        <th>ราคาเหมา</th>
                        <th>เลือก</th> 
                    </tr>
                </thead>
                <tbody id="karaokeBody">
                `;
                $.each(data.seat, function (key, value) {
                    // console.log(value.SEAT_TYPE);
                    if (value.SEAT_TYPE == '1') {
                        deskTable += `<tr id="rowd${rowd}">`;
                        deskTable += `<td>${value.SEAT_ID}</td>`;
                        deskTable += `<td>${value.SEAT_NAME}</td>`;
                        deskTable += `<td>${value.ZONE_NAME}</td>`;
                        deskTable += `<td>${value.SEAT_AMOUNT}</td>`;
                        deskTable += `<td><button type="button" class="selectDesk btn btn-primary">เลือก</button></td>`;
                        deskTable += `</tr>`;
                        rowd++;
                    }
                    if (value.SEAT_TYPE == '2') {
                        karaokeTable += `<tr id="rowk${rowk}">`;
                        karaokeTable += `<td>${value.SEAT_ID}</td>`;
                        karaokeTable += `<td>${value.SEAT_NAME}</td>`;
                        karaokeTable += `<td>${value.ZONE_NAME}</td>`;
                        karaokeTable += `<td>${value.SEAT_AMOUNT}</td>`;
                        karaokeTable += `<td>${value.KARAOKE_PRICEPERHOUR}</td>`;
                        karaokeTable += `<td>${value.KARAOKE_FLATRATE}</td>`;
                        karaokeTable += `<td><button type="button" class="selectKaraoke btn btn-primary">เลือก</button></td>`;
                        karaokeTable += `</tr>`;
                        rowk++;
                    }
                });

                deskTable += `</tbody></table>`;
                // console.log(data.desk);
                $('#deskTableModal').html(deskTable);
                $('#deskTable').dataTable({
                    "lengthMenu": [
                        [5, 10, 25, -1],
                        [5, 10, 25, "All"]
                    ], "columnDefs": [
                        { "className": "dt-center", "targets": "_all" }
                    ], "language": {
                        "emptyTable": "ไม่มีข้อมูล",
                        "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
                    }
                });

                karaokeTable += `</tbody></table>`;
                $('#karaokeTableModal').html(karaokeTable);
                $('#karaokeTable').dataTable({
                    "lengthMenu": [
                        [5, 10, 25, -1],
                        [5, 10, 25, "All"]
                    ], "columnDefs": [
                        { "className": "dt-center", "targets": "_all" }
                    ], "language": {
                        "emptyTable": "ไม่มีข้อมูล",
                        "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
                    }
                });
            }
        });
    });

    $('#deskTableModal').on('click', ' #deskTable #deskBody .selectDesk', function () {
        var rowId = $(this).parents('tr').attr('id');
        var deskID = $(`#${rowId} td`).html();
        var deskName = $(`#${rowId} td:nth-child(2)`).html();
        var zoneName = $(`#${rowId} td:nth-child(3)`).html();
        var deskAmount = $(`#${rowId} td:nth-child(4)`).html();
        var idTr = $('#SdeskBody tr:last-child').attr('id');
        if (idTr == null) {
            var rowsd = 1;
        } else {
            idTr = idTr.substr(5);
            var rowsd = parseInt(idTr) + 1;
        }
        var txtDeskTable = `<tr id="rowsd${rowsd}">
                                            <td style="text-align: center;" class="align-middle">
                                            <input type="text" value="${deskName}" style="text-align: center;" class="form-control"  disabled>
                                            <input type="hidden" name="deskID[]" class="deskID" value="${deskID}">
                                            </td>
                                            <td style="text-align: center;" class="align-middle">
                                            <input type="text" value="${zoneName}" style="text-align: center;" class="form-control seatZone"  disabled>
                                            </td>
                                            <td style="text-align: center; " class="align-middle">
                                            <input type="text" value="${deskAmount}" style="text-align: center; " class="form-control seatAmount"  disabled>
                                            </td>
                                            <td style="text-align: center;" class="align-middle">
                                                <button type="button" class="btn btn-danger deleteSD" value="${rowsd}">ลบ</button>
                                            </td>
                                        </tr>`;
        $('#SdeskBody').append(txtDeskTable);

        var seatAll = 0;
        $('.seatAmount').each(function () {
            seatAll += parseInt($(this).val());
        });
        $('#seatAll').val(seatAll);
    });

    $('#karaokeTableModal').on('click', ' #karaokeTable #karaokeBody .selectKaraoke', function () {
        var rowId = $(this).parents('tr').attr('id');
        var karaokeID = $(`#${rowId} td`).html();
        var karaokeName = $(`#${rowId} td:nth-child(2)`).html();
        var karaokeAmount = $(`#${rowId} td:nth-child(4)`).html();
        var zoneName = $(`#${rowId} td:nth-child(3)`).html();
        var idTr = $('#SkaraokeBody tr:last-child').attr('id');
        if (idTr == null) {
            var rowsk = 1;
        } else {
            idTr = idTr.substr(5);
            var rowsk = parseInt(idTr) + 1;
        }
        var txtKaraokeTable = `
            <tr id="rowsk${rowsk}">
                <td style="text-align: center;" class="align-middle">
                    <input type="text" value="${karaokeName}" style="text-align: center;" class="form-control"  disabled>
                    <input type="hidden" name="karaokeID[]" class="karaokeID" value="${karaokeID}">
                </td>
                <td style="text-align: center;" class="align-middle">
                    <input type="text" value="${karaokeAmount}" style="text-align: center;" class="form-control seatAmount"  disabled>
                </td>
                <td style="text-align: center;" class="align-middle">
                <input type="text" value="${zoneName}" style="text-align: center;" class="form-control seatZone"  disabled>
            </td>
                <td >
                    <select name="karaokeUseType[]" class="form-control karaokeUseType" required>
                        <option value="" selected disabled>กรุณาเลือก</option>
                        <option value="1">เหมาห้อง</option>
                        <option value="2">รายชั่วโมง</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="karaokeUseAmount[]" class="form-control karaokeUseAmount" min="1" max="24" value="1" required>
                </td>
                <td style="text-align: center;" class="align-middle">
                   <button type="button" class="btn btn-danger deleteSK" value="${rowsk}">ลบ</button>
                </td>
            </tr>`;
        $('#SkaraokeBody').append(txtKaraokeTable);
        var seatAll = 0;
        $('.seatAmount').each(function () {
            seatAll += parseInt($(this).val());
        });
        $('#seatAll').val(seatAll);
    });


    $('#SdeskBody').on('click', '.deleteSD', function () {
        var id = $(this).val();
        $(`#rowsd${id}`).remove();
        var seatAll = 0;
        $('.seatAmount').each(function () {
            seatAll += parseInt($(this).val());
        });
        $('#seatAll').val(seatAll);
    });

    $('#SkaraokeBody').on('click', '.deleteSK', function () {
        var id = $(this).val();
        $(`#rowsk${id}`).remove();
        var seatAll = 0;
        $('.seatAmount').each(function () {
            seatAll += parseInt($(this).val());
        });
        $('#seatAll').val(seatAll);
    });

    $('#SkaraokeTable #SkaraokeBody').on('change', '.karaokeUseType', function () {
        var rowsk = $(this).parents('tr').attr('id');
        var type = $(`#${rowsk} td:nth-child(3) .karaokeUseType`).val();
        if (type == 1) {
            var s = $(`#${rowsk} td:nth-child(4) .karaokeUseAmount`);
            s.val(1);
            s.attr({
                'max': 1,
            });
        }
        else {
            var s = $(`#${rowsk} td:nth-child(4) .karaokeUseAmount`);
            s.attr({
                'max': 24,
            });
        }
    });

    function validationQueueForm() {
        $('#cusTelError').html('');
        $('#seatAllError').html('');
        $('#deskError').html('')
        $('#karaokeError').html('')
        var Errors = 0;
        var deskList = [];
        var karaokeList = [];
        var breakDesk = 0;
        var breakKaraoke = 0;
        var d = 0;
        var k = 0;
        var seatAll = parseInt($('#seatAll').val());
        var customerAmount = parseInt($('#customerAmount').val());

        if (seatAll == 0) {
            $('#seatAllError').html('***กรุณาเลือกที่นั่ง');
            Errors = 1;
        }
        else {
            if (seatAll >= customerAmount) {
                $('#customerAmountError').html('');
                $('.deskID').each(function () {
                    deskList.push($(this).val());
                    d++;
                });
                for (var i = 0; i < deskList.length; i++) {
                    for (var j = 0; j < deskList.length; j++) {
                        if (i == j) {
                            continue;
                        }
                        else if (deskList[i] == deskList[j]) {
                            $('#deskError').html('***กรุณาอย่าเลือกโต๊ะซ้ำ')
                            Errors = 1;
                            breakDesk = 1;
                            break;
                        }
                    }
                    if (breakDesk == 1) {
                        break;
                    }
                    else {
                        $('#deskError').html('')
                    }
                }


                $('.karaokeID').each(function () {
                    karaokeList.push($(this).val());
                    k++;
                });
                for (var i = 0; i < karaokeList.length; i++) {
                    for (var j = 0; j < karaokeList.length; j++) {
                        if (i == j) {
                            continue;
                        }
                        else if (karaokeList[i] == karaokeList[j]) {
                            $('#karaokeError').html('***กรุณาอย่าเลือกห้องคาราโอเกะซ้ำ')
                            Errors = 1;
                            breakKaraoke = 1;
                            break;
                        }
                    }
                    if (breakKaraoke == 1) {
                        break;
                    }
                    else {
                        $('#karaokeError').html('')
                    }
                }


                if (breakKaraoke == 0 && breakDesk == 0) {
                    let zoneList = [];
                    let zonebreak = 0;
                    $('.seatZone').each(function () {
                        zoneList.push($(this).val());
                    });
                    for (var i = 0; i < zoneList.length; i++) {
                        for (var j = 0; j < zoneList.length; j++) {
                            if (i == j) {
                                continue;
                            }
                            else if (zoneList[i] != zoneList[j]) {
                                $('#seatAllError').html('***กรุณาเลือกโซนเดียวกัน')
                                Errors = 1;
                                zonebreak = 1;
                                break;
                            }
                        }
                        if (zonebreak == 1) {
                            break;
                        }
                    }
                    if (zonebreak == 0) {
                        if (d > 0 && k > 0) {
                            $('#seatAllError').html('***กรุณาเลือกแค่โต๊ะหรือแค่ห้องคาราโอเกะ');
                            Errors = 1;
                        }
                        else if (k > 1) {
                            $('#seatAllError').html('***กรุณาเลือกห้องคาราโอเกะเพียงห้องเดียว');
                            Errors = 1;
                        }
                        else {
                            $('#seatAllError').html('');
                        }
                    }
                }
            }
            else {
                $('#customerAmountError').html('***จำนวนคนมากกว่าจำนวนที่นั่ง');
                Errors = 1;
            }
        }
        return Errors;
    }

    function checkCallQueue() {
        var customerTel = $('#customerTel').val();
        var queueDate = $('#queueDate').val();
        var result;
        $.ajax({
            url: "../queue/checkCallQueue",
            method: "POST",
            async: false,
            data: {
                customerTel: customerTel,
                queueDate: queueDate
            },
            dataType: "JSON",
            success: function (data) {
                result = data.checkCallQueue;
            }
        });

        return result;
    }

    $('#addQueueForm').on('submit', function (e) {
        e.preventDefault();
        var checkCall = checkCallQueue();
        if (checkCall != 0) {
            var cf = confirm('เบอร์นี้มีการลงคิวสำหรับวันนี้แล้ว\nต้องการเพิ่มคิวหรือไม่')
            if (cf == true) {
                var Errors = validationQueueForm();
                if (Errors == 0) {
                    $.ajax({
                        url: "../queue/insertQueue",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            alert('เพิ่มข้อมูลจองคิวเสร็จสิ้น');
                            location.replace(data.url);

                        }
                    });
                } else {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง')
                }
            }
        }
        else if (checkCall == 0) {
            var Errors = validationQueueForm();
            if (Errors == 0) {
                $.ajax({
                    url: "../queue/insertQueue",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        alert('เพิ่มข้อมูลจองคิวเสร็จสิ้น');
                        location.replace(data.url);

                    }
                });
            } else {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            }
        }
    });


    $('#editQueueForm').on('submit', function (e) {
        e.preventDefault();
        var queueActive = $('#queueActive').val();
        if (queueActive == 1) {
            var cf = confirm('กรุณายืนยันการแก้ไข');
            if (cf == true) {
                var Errors = validationQueueForm();
                if (Errors == 0) {
                    $.ajax({
                        url: "../queue/updateQueue",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            // console.log(data);
                            alert('แก้ไขข้อมูลจองคิวเสร็จสิ้น');
                            location.replace(data.url);

                        }
                    });
                } else {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง')
                }
            }
        }
        else {
            alert('ไม่สามารถแก้ไขข้อมูลคิวได้');
        }
    });


    function checkCallQueueWalkin() {
        var customerTel = $('#customerTel').val();
        var result;
        $.ajax({
            url: "../queuewalkin/checkCallQueueWalkin",
            method: "POST",
            async: false,
            data: {
                customerTel: customerTel,
            },
            dataType: "JSON",
            success: function (data) {
                result = data.checkCallQueue;
            }
        });

        return result;
    }

    $('#addQueueWalkinForm').on('submit', function (e) {
        e.preventDefault();
        var chkcallQueue = checkCallQueueWalkin();
        if (chkcallQueue == 0) {
            $.ajax({
                url: "../queuewalkin/insertQueueWalkin",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (data) {
                    alert('เพิ่มข้อมูลจองคิวเสร็จสิ้น');
                    location.replace(data.url);
                }
            });
        }
        else {
            var cf = confirm('เบอร์โทรนี้มีอยู่ในคิวแล้วต้องการเพิ่มหรือไม่');
            if (cf == true) {
                $.ajax({
                    url: "../queuewalkin/insertQueueWalkin",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        alert('เพิ่มข้อมูลจองคิวเสร็จสิ้น');
                        location.replace(data.url);
                    }
                });
            }
        }



    });


    //QUEUE END


    $('input[type=tel]').on('keypress', function (e) {
        if (e.charCode >= 48 && e.charCode <= 57) {
            return true;
        } else {
            return false;
        }
    });

    var pathhh = window.location.href; // because the 'href' property of the DOM element is the absolute path

    $(".navbar .navbar-collapse .navbar-nav .nav-item a.nav-link").each(function () {
        if (this.href === pathhh) {
            $(this).addClass("active");
        }
    });

    $('.bgtable').mouseover(function () {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "#C6FFF8");
    });
    $('.bgtable').mouseout(function () {
        var ID = $(this).attr("ID");
        $('#' + ID).css("background-color", "");
    });
});