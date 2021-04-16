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
                    <form method="POST" id="changePasswordForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>รหัสผ่านเก่า</label>
                                <input type="password" name="passwordOld" id="passwordOld" class="form-control" required maxlength="20">
                                <span id="passwordError" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสผ่านใหม่</label>
                                <input type="password" name="passwordNew" id="passwordNew" class="form-control" required minlength="8" maxlength="20">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowNewPass">
                                <label>ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="rePasswordNew" id="rePasswordNew" class="form-control" required minlength="8" maxlength="20">
                                <span id="newPasswordError" style="color:red;"></span>
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
                                            <input class="btn btn-success" type="submit" value="เปลี่ยน">
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
