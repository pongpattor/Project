<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เปลี่ยนรหัสผ่าน</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container" id="bodyCard">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?=site_url('admin/admin/repass')?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowOldPass">
                                <label>รหัสผ่านเก่า</label>
                                <input type="password" name="oldPass" id="oldPass" class="form-control" required maxlength="20">
                                <input type="hidden" name="empID" id="empID" value="<?= $_SESSION["EmpID"]; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสผ่านใหม่</label>
                                <input type="password" name="newPass" id="newPass" class="form-control" required minlength="8" maxlength="20">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowNewPass">
                                <label>ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="reNewPass" id="reNewPass" class="form-control" required minlength="8" maxlength="20">
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/admin/home/'); ?>" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success" type="submit" value="เปลี่ยน">
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
</div>
<br>
<script>
    $(document).ready(function() {

        function checkOldPass() {
            var oldpass = $('#oldPass').val();
            var empID = $('#empID').val();

            $.ajax({
                url: "<?= site_url('admin/admin/checkOldPass') ?>",
                method: "POST",
                data: {
                    empID: empID
                },
                async: false,
                success: function(data) {
                    if (oldpass == data) {
                        $('#btn_regis').removeClass('oldPassFalse');
                        $('#alertOldPass').remove();
                    } else {
                        $('#btn_regis').addClass('oldPassFalse');
                        $('#alertOldPass').remove();
                        // $('#rowidcard').append(' <div class="alert alert-danger" role="alert" id="alertidcard">บัตรประชาชนนี้ถูกใช้ไปแล้ว</div>');
                        $('#rowOldPass').append('<p style="color:red" id="alertOldPass">กรุณากรอกรหัสผ่านเก่าให้ถูกต้อง</p>');
                    }
                }

            });
        }

        function checkNewPass() {
            var newPass = $('#newPass').val();
            var reNewPass = $('#reNewPass').val();
            if (newPass != reNewPass) {
                $('#btn_regis').addClass('newPassFalse');
                $('#alertNewPass').remove();
                // $('#rowidcard').append(' <div class="alert alert-danger" role="alert" id="alertidcard">บัตรประชาชนนี้ถูกใช้ไปแล้ว</div>');
                $('#rowNewPass').append('<p style="color:red" id="alertNewPass">กรุณากรอกรหัสผ่านให้ตรงกัน</p>');
            } else {
                $('#btn_regis').removeClass('newPassFalse');
                $('#alertNewPass').remove();
            }
          
        }

        $('#btn_regis').on('click', function() {
            var newPass = $('#newPass').val();
            var reNewPass = $('#reNewPass').val();
            checkOldPass();
            checkNewPass();
            if ($('#btn_regis').hasClass('oldPassFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
                return false;
            } else if ($('#btn_regis').hasClass('newPassFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง')
                return false;
            }
            // else if($('#btn_regis').hasClass('RenewPassFalse')) {
            //     alert('กรุณากรอกข้อมูลให้ถูกต้อง')
            //     return false;
            // }
            else {
                if (newPass.length > 7 && reNewPass.length > 7) {
                    alert('แก้ไขรหัสผ่านเสร็จสิ้น')
                }
            }
        });
    });
</script>