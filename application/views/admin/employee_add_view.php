<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มพนักงาน</h3>

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
                    <form action="<?= site_url('admin/employee/insertEmp') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสบัตรประจำตัวประชาชน13หลัก <i style="color: red;">*</i> </label>
                                <input type="text" name="idcard" class="form-control" minlength="13" maxlength="13" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>คำนำหน้า <span style="color: red;">*</span> </label>
                                <select name="title" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกคำนำหน้า</option>
                                    <option value="1">นาย</option>
                                    <option value="2">นาง</option>
                                    <option value="3">นางสาว</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อ <span style="color: red;">*</span> </label>
                                <input type="text" name="firstname" id="fname" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>นามสกุล <span style="color: red;">*</span> </label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>เพศ <span style="color: red;">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกเพศ</option>
                                    <option value="M">ชาย</option>
                                    <option value="F">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>อีเมล </label>
                                <input type="email" class="form-control" name="email" placeholder="mut@example.com">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <table style="width:100%" id="tablephone">
                                    <tbody>
                                        <tr>
                                            <td>เบอร์โทร</td>
                                        </tr>
                                        <tr id="row1">
                                            <td><input type="tel" class="form-control" name="tel[]" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'></td>
                                            <td>
                                                <button type="button" id="addphone" class="btn btn-info float-right"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>วันเกิด <span style="color: red;">*</span> </label>
                                <input type="date" id="bdate" name="bdate" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ที่อยู่ <span style="color: red;">*</span></label>
                                <textarea name="address" id="address" cols="10" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จังหวัด <span style="color: red;">*</span></label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                    <?php foreach ($province as $row) : ?>
                                        <option value="<?= $row->PROVINCE_ID ?>"><?= $row->PROVINCE_NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เขต <span style="color: red;">*</span></label>
                                <select name="amphur" id="amphur" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกเขต</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แขวง <span style="color: red;">*</span></label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสไปรษณีย์ <span style="color: red;">*</span></label>
                                <select name="postcode" id="postcode" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แผนก <span style="color: red;">*</span></label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ตำแหน่ง <span style="color: red;">*</span></label>
                                <select name="position" id="position" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกตำแหน่ง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เงินเดือน </label>
                                <input type="number" name="salary" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เลือกรูปภาพ </label>
                                <input type="file" name="imgEmp" class="form-control-file" id="imgEmp" accept="image/*">
                                <img id="imgPreview" src="#" alt="Image Preview" style="width: 200px; height: 200px;" class="img-thumbnail" />
                            </div>
                        </div>
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/employee/employee'); ?>" class="btn btn-danger  ">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success " type="submit" value="  เพิ่ม  ">
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#btn_regis').on('click', function(e) {
                if ($('input[name="idcard"]').hasClass('idFalse')) {
                    alert('กรุณากรอกบัตรประชาชนให้ถูกต้อง');
                    return false;
                }
            });

            $('input[name="idcard"]').on('focusout', function() {
                var id = $(this).val();
                $.ajax({
                    url: "<?= site_url('admin/employee/idcard'); ?>",
                    method: "POST",
                    data: {
                        idcard: id
                    },
                    success: function(data) {

                        if (data == true) {
                            $('input[name="idcard"]').css('background-color', '#83F28E');
                            $('input[name="idcard"]').css('border-color', '#000000');
                            $('input[name="idcard"]').removeClass('idFalse');
                        } else {
                            $('input[name="idcard"]').css('background-color', '#F9A8A8');
                            $('input[name="idcard"]').css('border-color', '#000000');
                            $('input[name="idcard"]').addClass('idFalse');
                        }
                    }
                })
            });

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



            var addphone_id = 1;
            $('#addphone').click(function() {
                addphone_id++;
                var txt = `<tr id="row${addphone_id}">
                            <td><input type="tel" class="form-control" name="tel[] minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'></td>
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
        });
    </script>
    <br>
</div>
<br>