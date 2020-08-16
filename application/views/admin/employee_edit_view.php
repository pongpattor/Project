<h1 class="mt-4">แก้ไขข้อมูลพนักงาน</h1>
<br>
<div>
    <form action="<?= site_url('admin/admin/updateEmp') ?>" method="POST" enctype="multipart/form-data">
        <?php foreach ($employee as $row) : ?>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>รหัสประจำตัวพนักงาน </label>
                    <input type="text" class="form-control" disabled value="<?= $row->ID ?>">
                    <input type="hidden" name="idEmp" value="<?= $row->ID ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>รหัสบัตรประจำตัวประชาชน13หลัก </label>
                    <input type="text" name="idcard" class="form-control" value="<?= $row->IDCARD ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>คำนำหน้า</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input  " type="radio" name="title" id="title1" value="นาย" <?php if ($row->TITLENAME == 'นาย') echo 'checked'; ?>>
                        <label class="form-check-label" for="title1">นาย</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="title" id="title2" value="นาง" <?php if ($row->TITLENAME == 'นาง') echo 'checked'; ?>>
                        <label class="form-check-label" for="title2">นาง</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="title" id="title3" value="นางสาว" <?php if ($row->TITLENAME == 'นางสาว') echo 'checked'; ?>>
                        <label class="form-check-label" for="title3">นางสาว</label>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>ชื่อ </label>
                    <input type="text" name="firstname" class="form-control" value="<?= $row->FIRSTNAME ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>นามสกุล </label>
                    <input type="text" name="lastname" class="form-control" value="<?= $row->LASTNAME ?>">
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
                        <input class="form-check-input" type="radio" name="gender" id="genderM" value="M" <?php if ($row->GENDER == 'M') echo 'checked'; ?>>
                        <label class="form-check-label" for="genderM">ชาย</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderF" value="F" <?php if ($row->GENDER == 'F') echo 'checked'; ?>>
                        <label class="form-check-label" for="genderF">หญิง</label>
                    </div>
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
                    <label>เบอร์โทร </label>
                    <input type="tel" class="form-control" name="tel" value="<?= $row->TEL ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>วันเกิด </label>
                    <input type="date" id="bdate" name="bdate" class="form-control" value="<?= $row->BDATE ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>ที่อยู่ </label>
                    <textarea name="address" id="address" cols="10" rows="5" class="form-control"><?= $row->ADDRESS ?></textarea>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>จังหวัด </label>
                    <select name="province" id="province" class="form-control">
                        <option value="" disabled>กรุณาเลือกจังหวัด</option>
                        <?php foreach ($province as $row2) : ?>
                            <option value="<?= $row2->PROVINCE_ID ?>" <?php if ($row2->PROVINCE_ID == $row->PROVINCE) echo 'selected'; ?>><?= $row2->PROVINCE_NAME ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>เขต </label>
                    <select name="amphur" id="amphur" class="form-control">
                        <option value="" selected disabled>กรุณาเลือกเขต</option>
                        <?php foreach ($amphur as $row3) : ?>
                            <option value="<?= $row3->AMPHUR_ID ?>" <?php if ($row3->AMPHUR_ID == $row->AMPHUR) echo 'selected'; ?>><?= $row3->AMPHUR_NAME ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>แขวง </label>
                    <select name="district" id="district" class="form-control">
                        <option value="" selected disabled>กรุณาเลือกแขวง</option>
                        <?php foreach ($district as $row4) : ?>
                            <option value="<?= $row4->DISTRICT_ID ?>" <?php if ($row4->DISTRICT_ID == $row->DISTRICT) echo 'selected'; ?>><?= $row4->DISTRICT_NAME ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>รหัสไปรษณีย์ </label>
                    <select name="postcode" id="postcode" class="form-control">
                        <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                        <?php foreach ($district as $row5) : ?>
                            <option value="<?= $row5->POSTCODE ?>" <?php if ($row5->POSTCODE == $row->POSTCODE) echo 'selected'; ?>><?= $row5->POSTCODE ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6">
                    <label>แผนก </label>
                    <select name="department" id="department" class="form-control">
                        <option value="" selected disabled>กรุณาเลือกแผนก</option>
                        <?php foreach ($department as $row6) : ?>
                            <option value="<?= $row6->DEPARTMENT_ID; ?>" <?php if ($row6->DEPARTMENT_ID == $row->DEPARTMENT) echo 'selected'; ?>><?= $row6->DEPARTMENT_NAME; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <label>ตำแหน่ง </label>
                    <select name="position" id="position" class="form-control">
                        <option value="" selected disabled>กรุณาเลือกตำแหน่ง</option>
                        <?php foreach ($position as $row7) : ?>
                            <option value="<?= $row7->POSITION_ID; ?>" <?php if ($row7->POSITION_ID == $row->POSITION) echo 'selected'; ?>><?= $row7->POSITION_NAME; ?></option>
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
            <br>
            <div class="row justify-content-center">
                <div class="col-sm col-md col-xl-6 ">
                    <center>
                        <div class="input-group">
                            <div class="col">
                                <a href="<?= site_url('admin/admin/employee'); ?>" class="btn btn-danger">ยกเลิก</a>
                            </div>

                            <div class="col">
                                <input id="btn_regis" class="btn btn-success" type="submit" value="บันทึก">
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        <?php endforeach; ?>
    </form>

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


        });
    </script>
    <br>
</div>
<br>