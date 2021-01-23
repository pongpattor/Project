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
                    <form method="POST" enctype="multipart/form-data" id="addEmployeeForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <div class="row">
                                    <div class="col">
                                        <label>เลือกรูปภาพ</label>
                                        <input type="file" name="employeeImage" class="form-control-file" id="Image" 
                                        accept="image/png,image/jpeg" required>
                                        <span id="imageError" style="color:red"></span>
                                    </div>
                                    <div class="col">
                                        <img id="imgPreview" src="#" width="150px" height="150px" class="float-right img" 
                                        style="border-style:inset;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสบัตรประจำตัวประชาชน13หลัก</label>
                                <input type="text" name="employeeIdCard" id="idCard" class="form-control" minlength="13" maxlength="13" required>
                                <span id="employeeIdCardError" style="color:red"></span>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อ</label>
                                <input type="text" name="employeeFirstName" class="form-control" required maxlength="30">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>นามสกุล  </label>
                                <input type="text" name="employeeLastName" class="form-control" required maxlength="30">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>เพศ</label>
                                <select name="employeeGender" class="form-control" required id="gender">
                                    <option value="" selected disabled>กรุณาเลือกเพศ</option>
                                    <option value="M" >ชาย</option>
                                    <option value="F" >หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>อีเมล </label>
                                <input type="email" class="form-control" name="employeeEmail" placeholder="mut@example.com" maxlength="50">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <table style="width:100%" id="tablephone">
                                    <tbody id="bodyTel">
                                        <tr>
                                            <td>เบอร์โทร</span></td>
                                        </tr>
                                        <tr id="row1">
                                            <td><input type="tel" class="form-control employeeTel" name="employeeTel[]" minlength="10" maxlength="10" required></td>
                                            <td>
                                                <button type="button" id="addEmployeeTel" class="btn btn-info float-right"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span id="employeeTelError" style="color:red"></span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>วันเกิด </label>
                                <input type="date" id="employeeBdate" name="employeeBdate" class="form-control" required max="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ที่อยู่ </span></label>
                                <textarea name="employeeAddress" id="employeeAddress" cols="10" rows="5" class="form-control" required maxlength="50"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จังหวัด </label>
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
                                <label>เขต</label>
                                <select name="amphur" id="amphur" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกเขต</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แขวง</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสไปรษณีย์</label>
                                <select name="postcode" id="postcode" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แผนก</label>
                                <select name="employeeDepartment" id="employeeDepartment" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ตำแหน่ง</label>
                                <select name="employeePosition" id="employeePosition" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกตำแหน่ง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เงินเดือน</label>
                                <input type="number" name="employeeSalary" class="form-control" min="0" max="9999999" required>
                            </div>
                        </div>
                        <br>
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/employee/'); ?>" class="btn btn-danger btn-xs">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input  class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
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
