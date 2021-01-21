<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มตำแหน่ง</h3>
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
                    <form method="POST" id="addPositionForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <label>ชื่อตำแหน่ง </label>
                                <input type="text" name="positionName" id="positionName" class="form-control" required maxlength="50">
                                <span id="positionNameError" style="color:red"></span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>แผนก </label>
                                <select name="positionDepartment" id="positionDepartment" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="">สิทธิ์การเข้าใช้งานระบบ</label>
                                <input type="hidden" name="positionPermission" id="positionPermission" value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0">
                                <div class="card boder-0 ">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck1" class="chkper">
                                            <label class="form-check-label" for="exampleCheck1">จัดการข้อมูลสมาชิก เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck2" class="chkper">
                                            <label class="form-check-label" for="exampleCheck2">จัดการข้อมูลประเภทสมาชิก เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck3" class="chkper">
                                            <label class="form-check-label" for="exampleCheck3">จัดการข้อมูลพนักงาน เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck4" class="chkper">
                                            <label class="form-check-label" for="exampleCheck4">จัดการข้อมูลตำแหน่ง เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck5" class="chkper">
                                            <label class="form-check-label" for="exampleCheck5">จัดการข้อมูลแผนก เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck6" class="chkper">
                                            <label class="form-check-label" for="exampleCheck6">จัดการข้อมูลสินค้า เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck7" class="chkper">
                                            <label class="form-check-label" for="exampleCheck7">จัดการข้อมูลประเภทสินค้า เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck8" class="chkper">
                                            <label class="form-check-label" for="exampleCheck8">จัดการข้อมูลสูตรการผลิต เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck9" class="chkper">
                                            <label class="form-check-label" for="exampleCheck9">จัดการข้อมูลวัตถุดิบ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck10" class="chkper">
                                            <label class="form-check-label" for="exampleCheck10">จัดการข้อมูลที่โต๊ะ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck11" class="chkper">
                                            <label class="form-check-label" for="exampleCheck11">จัดการข้อมูลที่ห้องคาราโอเกะ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck12" class="chkper">
                                            <label class="form-check-label" for="exampleCheck12">จัดการข้อมูลโซนที่นั่ง เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck13" class="chkper">
                                            <label class="form-check-label" for="exampleCheck13">จัดการข้อมูลรับล็อค เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck14" class="chkper">
                                            <label class="form-check-label" for="exampleCheck14">จัดการข้อมูลที่โปรโมชั่นลดราคา เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck15" class="chkper">
                                            <label class="form-check-label" for="exampleCheck15">จัดการข้อมูลที่โปรโมชั่นเซ็ต เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck16" class="chkper">
                                            <label class="form-check-label" for="exampleCheck16">ระบบออกรายงาน</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck17" class="chkper">
                                            <label class="form-check-label" for="exampleCheck17">ระบบจองคิว</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck18" class="chkper">
                                            <label class="form-check-label" for="exampleCheck18">ระบบห้องครัว</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck19" class="chkper">
                                            <label class="form-check-label" for="exampleCheck19">ระบบชำระเงิน</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/position/'); ?>" class="btn btn-danger btn-xs ">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
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

ิ<br>