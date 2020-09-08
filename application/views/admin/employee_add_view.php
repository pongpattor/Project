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
                    <form action="<?= site_url('admin/admin/insertEmp') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสบัตรประจำตัวประชาชน13หลัก </label>
                                <input type="text" name="idcard" class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>คำนำหน้า</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input  " type="radio" name="title" id="title1" value="นาย">
                                    <label class="form-check-label" for="title1">นาย</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="title" id="title2" value="นาง">
                                    <label class="form-check-label" for="title2">นาง</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="title3" value="นางสาว">
                                    <label class="form-check-label" for="title3">นางสาว</label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อ </label>
                                <input type="text" name="firstname" class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>นามสกุล </label>
                                <input type="text" name="lastname" class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label for="">เพศ</label>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderM" value="M">
                                    <label class="form-check-label" for="genderM">ชาย</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderF" value="F">
                                    <label class="form-check-label" for="genderF">หญิง</label>
                                </div>
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
                                            <td><input type="tel" class="form-control" name="tel[]" maxlength="10" required></td>
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
                                <label>วันเกิด </label>
                                <input type="date" id="bdate" name="bdate" class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ที่อยู่ </label>
                                <textarea name="address" id="address" cols="10" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จังหวัด </label>
                                <select name="province" id="province" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                    <?php foreach ($province as $row) : ?>
                                        <option value="<?= $row->PROVINCE_ID ?>"><?= $row->PROVINCE_NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เขต </label>
                                <select name="amphur" id="amphur" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกเขต</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แขวง </label>
                                <select name="district" id="district" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสไปรษณีย์ </label>
                                <select name="postcode" id="postcode" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แผนก </label>
                                <select name="department" id="department" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ตำแหน่ง </label>
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
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/admin/employee'); ?>" class="btn btn-danger  ">ยกเลิก</a>
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



            $('#province').change(function() {
                var PROVINCE_ID = $('#province').val();
                if (PROVINCE_ID != "") {
                    $.ajax({
                        url: "<?= site_url('user/amphur'); ?>",
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
                        url: "<?= site_url('user/district'); ?>",
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
                        url: "<?= site_url('user/postcode'); ?>",
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
                        url: "<?= site_url('user/department'); ?>",
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
                            <td><input type="tel" class="form-control" name="tel[]"></td>
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