<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขข้อมูลพนักงาน</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?= site_url('admin/employee/updateEmp') ?>" method="POST" enctype="multipart/form-data">
                        <?php foreach ($employee as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="row">
                                        <div class="col">
                                            <label>เลือกรูปภาพ <span style="color: red;">* </label>
                                            <input type="file" name="imgEmp" class="form-control-file" id="imgEmp" accept="image/png,image/jpeg">
                                        </div>
                                        <div class="col">
                                            <img id="imgPreview" src="<?= base_url('assets/image/employee/' . $row->IMG); ?>" width="150px" height="150px" class="float-right  img" style="border-style:inset;" />
                                            <input type="hidden" name="oldImg" value="<?= $row->IMG ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>รหัสประจำตัวพนักงาน </label>
                                    <input type="text" class="form-control" disabled value="<?= $row->ID ?>">
                                    <input type="hidden" name="idEmp" value="<?= $row->ID ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowidcard">
                                    <label>รหัสบัตรประจำตัวประชาชน13หลัก <span style="color: red;">*</span></label>
                                    <input type="text" name="idcard" class="form-control" id="idcard" value="<?= $row->IDCARD ?>" maxlength="13" minlength="13" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                                    <input type="hidden" name="oldidcard" id="oldidcard" value="<?= $row->IDCARD ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>คำนำหน้า <span style="color: red;">*</span></label>
                                    <select name="title" class="form-control" required>
                                        <option value="" disabled>กรุณาเลือกคำนำหน้า</option>
                                        <option value="1" <?php if ($row->TITLENAME == 1)
                                                                echo 'selected';
                                                            ?>>นาย</option>
                                        <option value="2" <?php if ($row->TITLENAME == 2)
                                                                echo 'selected';
                                                            ?>>นาง</option>
                                        <option value="3" <?php if ($row->TITLENAME == 3)
                                                                echo 'selected';
                                                            ?>>นางสาว</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อ <span style="color: red;">*</span></label>
                                    <input type="text" name="firstname" class="form-control" value="<?= $row->FIRSTNAME ?>" required>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>นามสกุล <span style="color: red;">*</span></label>
                                    <input type="text" name="lastname" class="form-control" value="<?= $row->LASTNAME ?>" required>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>เพศ <span style="color: red;">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="" disabled>กรุณาเลือกเพศ</option>
                                        <option value="M" <?php if ($row->TITLENAME == 'M')
                                                                echo 'selected';
                                                            ?>>ชาย</option>
                                        <option value="F" <?php if ($row->TITLENAME == 'F')
                                                                echo 'selected';
                                                            ?>>หญิง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>อีเมล </label>
                                    <input type="email" class="form-control" name="email" placeholder="mut@example.com" value="<?= $row->EMAIL ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <table style="width:100%" id="tablephone">
                                        <tbody id="bodyTel">
                                            <tr>
                                                <td>เบอร์โทร <span style="color: red;">*</span></td>
                                            </tr>
                                            <?php
                                            $rowid = 1;
                                            foreach ($phone as $rowphone) { ?>
                                                <tr id="row<?= $rowid; ?>">
                                                    <td><input type="tel" class="form-control tel" name="tel[]" value="<?= $rowphone->PHONE; ?>" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required></td>
                                                    <td>
                                                        <?php if ($rowid == 1) { ?>
                                                            <button type="button" id="addphone" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
                                                        <?php } else { ?>
                                                            <button type="button" id="<?= $rowid; ?>" class="btn btn-danger btn-remove float-right"><i class="fa fa-minus"></i></button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $rowid++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>วันเกิด <span style="color: red;">*</span></label>
                                    <input type="date" id="bdate" name="bdate" class="form-control" value="<?= $row->BDATE ?>" required>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>กรุ๊ปเลือด <span style="color: red;">*</span></label>
                                    <select name="blood" id="blood" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกกรุ๊ปเลือด</option>
                                        <option value="AB" <?php if ($row->BLOOD == "AB") echo 'selected'; ?>>AB</option>
                                        <option value="A" <?php if ($row->BLOOD == "A") echo 'selected'; ?>>A</option>
                                        <option value="B" <?php if ($row->BLOOD == "B") echo 'selected'; ?>>B</option>
                                        <option value="O" <?php if ($row->BLOOD == "O") echo 'selected'; ?>>O</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>สัญชาติ <span style="color: red;">*</span></label>
                                    <select name="nationality" id="nationality" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกสัญชาติ</option>
                                        <?php foreach ($nationality as $row2) { ?>
                                            <option value="<?= $row2->NATIONALITY_ID; ?>" <?php if ($row->NATIONALITY == $row2->NATIONALITY_ID) echo 'selected'; ?>><?= $row2->NATIONALITY_NAME; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ศาสนา <span style="color: red;">*</span></label>
                                    <select name="religion" id="religion" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกศาสนา</option>
                                        <?php foreach ($religion as $row2) { ?>
                                            <option value="<?= $row2->RELIGION_ID; ?>" <?php if ($row->RELIGION == $row2->RELIGION_ID) echo 'selected'; ?>><?= $row2->RELIGION_NAME; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ที่อยู่ <span style="color: red;">*</span></label>
                                    <textarea name="address" id="address" cols="10" rows="5" class="form-control" required><?= $row->ADDRESS ?></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>จังหวัด <span style="color: red;">*</span></label>
                                    <select name="province" id="province" class="form-control" required>
                                        <option value="" disabled>กรุณาเลือกจังหวัด</option>
                                        <?php foreach ($province as $row2) : ?>
                                            <option value="<?= $row2->PROVINCE_ID ?>" <?php if ($row2->PROVINCE_ID == $row->D_PROVINCE_ID) echo 'selected'; ?>><?= $row2->PROVINCE_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เขต <span style="color: red;">*</span></label>
                                    <select name="amphur" id="amphur" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกเขต</option>
                                        <?php foreach ($amphur as $row3) : ?>
                                            <option value="<?= $row3->AMPHUR_ID ?>" <?php if ($row3->AMPHUR_ID == $row->D_AMPHUR_ID) echo 'selected'; ?>><?= $row3->AMPHUR_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>แขวง <span style="color: red;">*</span> </label>
                                    <select name="district" id="district" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                        <?php foreach ($district as $row4) : ?>
                                            <option value="<?= $row4->DISTRICT_ID ?>" <?php if ($row4->DISTRICT_ID == $row->DISTRICT_ID) echo 'selected'; ?>><?= $row4->DISTRICT_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>รหัสไปรษณีย์ <span style="color: red;">*</span> </label>
                                    <select name="postcode" id="postcode" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                        <?php foreach ($postcode as $row5) : ?>
                                            <option value="<?= $row5->POSTCODE ?>" <?php if ($row5->POSTCODE == $row->POSTCODE) echo 'selected'; ?>><?= $row5->POSTCODE ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>แผนก <span style="color: red;">*</span></label>
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                        <?php foreach ($department as $row6) : ?>
                                            <option value="<?= $row6->DEPARTMENT_ID; ?>" <?php if ($row6->DEPARTMENT_ID == $row->DEPARTMENT_ID) echo 'selected'; ?>><?= $row6->DEPARTMENT_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ตำแหน่ง <span style="color: red;">*</span></label>
                                    <select name="position" id="position" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกตำแหน่ง</option>
                                        <?php foreach ($position as $row7) : ?>
                                            <option value="<?= $row7->POSITION_ID; ?>" <?php if ($row7->POSITION_ID == $row->POSITION_ID) echo 'selected'; ?>><?= $row7->POSITION_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เงินเดือน </label>
                                    <input type="number" name="salary" class="form-control" min="0" value="<?= $row->SALARY ?>">
                                </div>
                            </div>
                            <br><br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/employee/'); ?>" class="btn btn-danger">ยกเลิก</a>
                                            </div>

                                            <div class="col">
                                                <input id="btn_update" class="btn btn-success" type="submit" value="บันทึก">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<script>
    $(document).ready(function() {

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgEmp").change(function() {
            readURL(this);
        });

        function chkiIdCard() {
            var id = $('#idcard').val();
            var oldid = $('#oldidcard').val();

            $.ajax({
                url: "<?= site_url('admin/employee/idcard'); ?>",
                method: "POST",
                async: false,
                data: {
                    idcard: id
                },
                success: function(data) {
                    if (data == true) {
                        $.ajax({
                            url: "<?= site_url('admin/employee/checkIdCardUpdate') ?>",
                            method: "POST",
                            data: {
                                idcard: id,
                                oldidcard: oldid

                            },
                            async: false,

                            success: function(data) {
                                if (data != 0) {
                                    // alert('บัตรประชาชนได้ถูกใช้ไปแล้ว');
                                    $('input[name="idcard"]').css('background-color', '#F9A8A8');
                                    $('input[name="idcard"]').css('border-color', '#000000');
                                    $('#btn_update').addClass('idFalse');
                                    $('#alertidcard').remove();
                                    $('#rowidcard').append('<p style="color:red" id="alertidcard">บัตรประชาชนนี้ถูกใช้ไปแล้ว</p>');

                                } else {

                                    $('#btn_update').removeClass('idFalse');
                                    $('#alertidcard').remove();
                                    if (id != oldid) {
                                        $('input[name="idcard"]').css('background-color', '#83F28E');
                                        $('input[name="idcard"]').css('border-color', '#000000');
                                        $('#rowidcard').append(' <p style="color:green" id="alertidcard">บัตรประชาชนนี้สามารถใช้ได้</p>');
                                    }

                                }
                            }
                        });

                    } else {
                        //บัตรไม่ถูกต้อง
                        $('input[name="idcard"]').css('background-color', '#F9A8A8');
                        $('input[name="idcard"]').css('border-color', '#000000');
                        $('#btn_update').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowidcard').append(' <p style="color:red" id="alertidcard">กรุณากรอกบัตรประชาชนให้ถูกต้อง</p>');
                    }
                }
            });
        }

        function chktel() {
            var telList = [];
            var breaker;
            $('input[type="tel"]').each(function() {
                if ($(this).val == "") {
                    telList.push($(this).val())
                } else {
                    telList.push($(this).val())
                }
            });
            // console.log(telList);

            for (var i = 0; i < telList.length; i++) {
                for (var j = 0; j < telList.length; j++) {
                    if(i==j){
                        // console.log( i+" : "+j); 
                        continue;
                    }
                    if(telList[i] == telList[j]){
                        // console.log( telList[i]+" :if2: "+telList[j]); 
                        $('#alerttel').remove();
                        $('#tablephone').append('<p style="color:red" id="alerttel">กรุณาอย่ากรอกเบอร์ซ้ำ</p>');
                        $('#btn_update').addClass('telFalse');
                        breaker = 1;
                        // console.log('break');
                        break;
                    }
                }
                if (breaker == 1) {
                    // console.log('if break');
                    break;
                } else {
                    // console.log('else break');
                    $('#btn_update').removeClass('telFalse');
                    $('#alerttel').remove();
                }
            }

        }




        $('#btn_update').on('click', function() {
            // e.preventDefault();
            chkiIdCard();
            chktel();
            if ($('#btn_update').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            } else if ($('#btn_update').hasClass('telFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }

        });


        // $('input[name="idcard"]').on('focusout', function() {
        //     var id = $(this).val();
        //     var oldid = $('#oldidcard').val();
        //     console.log(oldid)
        //     $.ajax({
        //         url: "<?= site_url('admin/employee/idcard'); ?>",
        //         method: "POST",
        //         data: {
        //             idcard: id
        //         },
        //         success: function(data) {
        //             if (data == true) {
        //                 $.ajax({
        //                     url: "<?= site_url('admin/employee/checkIdCardUpdate') ?>",
        //                     method: "POST",
        //                     data: {
        //                         idcard: id,
        //                         oldidcard: oldid
        //                     },
        //                     success: function(data) {
        //                         if (data != 0) {
        //                             // alert('บัตรประชาชนได้ถูกใช้ไปแล้ว');
        //                             $('input[name="idcard"]').css('background-color', '#F9A8A8');
        //                             $('input[name="idcard"]').css('border-color', '#000000');
        //                             $('input[name="idcard"]').addClass('idFalse');
        //                             $('#alertidcard').remove();
        //                             // $('#rowidcard').append(' <div class="alert alert-danger" role="alert" id="alertidcard">บัตรประชาชนนี้ถูกใช้ไปแล้ว</div>');
        //                             $('#rowidcard').append(' <p style="color:red" id="alertidcard">บัตรประชาชนนี้ถูกใช้ไปแล้ว</p>');

        //                         } else {
        //                             $('input[name="idcard"]').removeClass('idFalse');
        //                             $('#alertidcard').remove();
        //                             if (id != oldid) {
        //                                 $('#rowidcard').append(' <p style="color:green" id="alertidcard">บัตรประชาชนนี้สามารถใช้ได้</p>');
        //                                 $('input[name="idcard"]').css('background-color', '#83F28E');
        //                                 $('input[name="idcard"]').css('border-color', '#000000');
        //                             } else {
        //                                 $('input[name="idcard"]').css('background-color', '');
        //                                 $('input[name="idcard"]').css('border-color', '');
        //                             }

        //                         }
        //                     }
        //                 });

        //             } else {
        //                 $('input[name="idcard"]').css('background-color', '#F9A8A8');
        //                 $('input[name="idcard"]').css('border-color', '#000000');
        //                 $('input[name="idcard"]').addClass('idFalse');
        //                 $('#alertidcard').remove();
        //                 // $('#rowidcard').append(' <div class="alert alert-danger" role="alert" id="alertidcard">กรุณากรอกบัตรประชาชนให้ถูกต้อง</div>');
        //                 $('#rowidcard').append(' <p style="color:red" id="alertidcard">กรุณากรอกบัตรประชาชนให้ถูกต้อง</p>');

        //             }
        //         }
        //     })
        // });

        var id = $('tbody tr:last-child').attr('id');
        id = id.substr(3);
        var addphone_id = parseInt(id);

        $('#addphone').on('click', function() {
            addphone_id++;
            var txt = `<tr id="row${addphone_id}">
                            <td><input type="tel" class="form-control tel" name="tel[] minlength="10" maxlength="10" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'></td>
                            <td><button type="button" id="${addphone_id}" class="btn btn-danger btn-remove float-right">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                            </tr>`;
            $('#tablephone').append(txt);

            $('.btn-remove').on('click', function() {
                var btn_del = $(this).attr("id");
                $('#row' + btn_del).remove();
            });
        });

        $('.btn-remove').on('click', function() {
            var btn_del = $(this).attr("id");
            $('#row' + btn_del).remove();
            console.log(btn_del);
        });


        $('#province').change(function() {
            var PROVINCE_ID = $('#province').val();
            if (PROVINCE_ID != "") {
                $.ajax({
                    url: "<?= site_url('admin/employee/fetchamphur'); ?>",
                    method: "POST",
                    data: {
                        PROVINCE_ID: PROVINCE_ID
                    },
                    success: function(data) {
                        $('#amphur').html(data);
                        $('#district').html('<option value="" disable selected>กรุณาเลือกแขวง</option>');
                        $('#postcode').html('<option value="" disable selected>กรุณาเลือกรหัสไปรษณีย์</option>');
                    }
                });
            }
        });

        $('#amphur').change(function() {
            var AMPHUR_ID = $('#amphur').val();
            if (AMPHUR_ID != '') {
                $.ajax({
                    url: "<?= site_url('admin/employee/fetchdistrict'); ?>",
                    method: "POST",
                    data: {
                        AMPHUR_ID: AMPHUR_ID
                    },
                    success: function(data) {
                        $('#district').html(data);
                        $('#postcode').html('<option value="" disable selected>กรุณาเลือกรหัสไปรษณีย์</option>');
                    }
                });
            }
        });

        $('#district').change(function() {
            var DISTRICT_ID = $('#district').val();
            if (DISTRICT_ID != '') {
                $.ajax({
                    url: "<?= site_url('admin/employee/fetchpostcode'); ?>",
                    method: "POST",
                    data: {
                        DISTRICT_ID: DISTRICT_ID
                    },
                    success: function(data) {
                        $('#postcode').html(data);
                    }
                });
            }
        });

        $('#department').change(function() {
            var DEPARTMENT_ID = $('#department').val();
            if (DEPARTMENT_ID != '') {
                $.ajax({
                    url: "<?= site_url('admin/employee/fetchdepartment'); ?>",
                    method: "POST",
                    data: {
                        DEPARTMENT_ID: DEPARTMENT_ID
                    },
                    success: function(data) {
                        $('#position').html(data);
                    }
                });
            }
        });

        // $('#btn_regis').on('click', function(e) {
        //     if ($('input[name="idcard"]').hasClass('idFalse')) {
        //         alert('กรุณากรอกบัตรประชาชนให้ถูกต้อง');
        //         return false;
        //     }
        // });

    });
</script>