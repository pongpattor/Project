<br>
<div class="container" style="background-color: ghostwhite;">
    <h3>สมัครสมาชิก</h3>
    <?php echo validation_errors('<div>Hello</div>'); ?>
    <form action="<?= site_url('user/register'); ?>" method="POST">
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>รหัสผู้ใช้งาน</label>
                <div class=" input-group">
                    <input type="text" class="form-control" name="username">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>ยืนยันรหัสผ่าน </label>
                <input type="password" class="form-control" name="verifypassword" id="verifypassword">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <label for="">เพศ</label>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="M">
                    <label class="form-check-label" for="inlineRadio1">ชาย</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="F">
                    <label class="form-check-label" for="inlineRadio2">หญิง</label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>ชื่อ </label>
                <input type="text" name="firstname" class="form-control">
                
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>นามสกุล </label>
                <input type="text" name="lastname" class="form-control">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>อีเมล </label>
                <input type="email" class="form-control" name="email" placeholder="mut@example.com">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>เบอร์โทร </label>
                <input type="tel" class="form-control" name="tel">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>วันเกิด </label>
                <input type="date" id="date" name="date" class="form-control">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
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
            <div class="col-5 ">
                <label>เขต </label>
                <select name="amphur" id="amphur" class="form-control">
                    <option value="" selected disabled>กรุณาเลือกเขต</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>แขวง </label>
                <select name="district" id="district" class="form-control">
                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>รหัสไปรษณีย์ </label>
                <select name="postcode" id="postcode" class="form-control">
                    <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <center>
                    <div class="input-group">
                        <div class="col">
                            <a href="" class="btn btn-danger">ยกเลิก</a>
                        </div>
                        <div class="col">
                            <input id="btn_regis" class="btn btn-success" type="submit" value="สมัครสมาชิก">
                        </div>
                    </div>
                </center>
            </div>
        </div>
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
        });
    </script>
    <br>
</div>
<br>