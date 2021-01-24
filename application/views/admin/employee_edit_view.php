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
                    <form method="POST" enctype="multipart/form-data" id="editEmployeeForm">
                        <?php foreach ($employee as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="row">
                                        <div class="col">
                                            <label>เลือกรูปภาพ</label>
                                            <input type="file" name="employeeImage" class="form-control-file" id="Image" accept="image/png,image/jpeg">
                                            <span id="imageError" style="color:red"></span>
                                        </div>
                                        <div class="col">
                                            <img id="imgPreview" src="<?= base_url('assets/image/employee/' . $row->EMPLOYEE_IMAGE) ?>" width="150px" height="150px" class="float-right img" style="border-style:inset;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>รหัสบัตรประจำตัวประชาชน13หลัก</label>
                                    <input type="text" name="employeeIdCard" id="idCard" class="form-control" value="<?= $row->EMPLOYEE_IDCARD ?>" minlength="13" maxlength="13" required>
                                    <input type="hidden" name="employeeIdCardOld"  value="<?= $row->EMPLOYEE_IDCARD ?>">
                                    <input type="hidden" name="employeeID"  value="<?= $row->EMPLOYEE_ID ?>">
                                    <input type="hidden" name="employeeImageOld"  value="<?= $row->EMPLOYEE_IMAGE; ?>">

                                    <span id="employeeIdCardError" style="color:red"></span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อ</label>
                                    <input type="text" name="employeeFirstName" class="form-control" value="<?= $row->EMPLOYEE_FIRSTNAME ?>" required maxlength="30">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>นามสกุล </label>
                                    <input type="text" name="employeeLastName" class="form-control" value="<?= $row->EMPLOYEE_LASTNAME ?>" required maxlength="30">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>เพศ</label>
                                    <select name="employeeGender" class="form-control" required id="gender">
                                        <option value="" selected disabled>กรุณาเลือกเพศ</option>
                                        <option value="M" <?php if ($row->EMPLOYEE_GENDER == 'M') {
                                                                echo 'selected';
                                                            } ?>>ชาย</option>
                                        <option value="F" <?php if ($row->EMPLOYEE_GENDER == 'F') {
                                                                echo 'selected';
                                                            } ?>>หญิง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>อีเมล </label>
                                    <input type="email" class="form-control" name="employeeEmail" value="<?= $row->EMPLOYEE_EMAIL ?>" placeholder="mut@example.com" maxlength="50">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <table style="width:100%" id="tablephone">
                                        <tbody id="bodyTel">
                                            <tr>
                                                <td>เบอร์โทร</span></td>
                                            </tr>
                                            <?php
                                            $rowid = 1;
                                            foreach ($employeeTel as $rowTel) { ?>
                                                <tr id="row<?= $rowid; ?>">
                                                    <td><input type="tel" class="form-control employeeTel" name="employeeTel[]" value="<?= $rowTel->EMPLOYEETEL_TEL; ?>" maxlength="10" minlength="10" required></td>
                                                    <td>
                                                        <?php if ($rowid == 1) { ?>
                                                            <button type="button" id="addTel" class="btn btn-success float-right"><i class="fa fa-plus"></i></button>
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
                                    <span id="employeeTelError" style="color:red"></span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>วันเกิด </label>
                                    <input type="date" id="employeeBdate" name="employeeBdate" class="form-control" value="<?= $row->EMPLOYEE_BDATE; ?>" required max="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ที่อยู่ </span></label>
                                    <textarea name="employeeAddress" id="employeeAddress" cols="10" rows="5" class="form-control" required maxlength="50"><?= $row->EMPLOYEE_ADDRESS ?></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>จังหวัด </label>
                                    <select name="province" id="province" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                        <?php foreach ($province as $row2) : ?>
                                            <option value="<?= $row2->PROVINCE_ID ?>" <?php if($row->D_PROVINCE_ID ==  $row2->PROVINCE_ID) echo 'selected'; ?>><?= $row2->PROVINCE_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เขต</label>
                                    <select name="amphur" id="amphur" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกเขต</option>
                                        <?php foreach ($amphur as $row2) : ?>
                                            <option value="<?= $row2->AMPHUR_ID ?>" <?php if($row->D_AMPHUR_ID == $row2->AMPHUR_ID) echo 'selected'; ?>><?= $row2->AMPHUR_NAME?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>แขวง</label>
                                    <select name="district" id="district" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                        <?php foreach ($district as $row2) : ?>
                                            <option value="<?= $row2->DISTRICT_ID ?>" <?php if($row->DISTRICT_ID == $row2->DISTRICT_ID) echo 'selected'; ?>><?= $row2->DISTRICT_NAME?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>รหัสไปรษณีย์</label>
                                    <select name="postcode" id="postcode" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                        <?php foreach ($postcode as $row2) : ?>
                                            <option value="<?= $row2->POSTCODE ?>" <?php if($row->POSTCODE == $row2->POSTCODE) echo 'selected'; ?>><?= $row2->POSTCODE?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>แผนก</label>
                                    <select name="employeeDepartment" id="employeeDepartment" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                        <?php foreach ($department as $row2) : ?>
                                            <option value="<?= $row2->DEPARTMENT_ID; ?>"<?php if($row->POSITION_DEPARTMENT == $row2->DEPARTMENT_ID) echo 'selected'; ?>><?= $row2->DEPARTMENT_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ตำแหน่ง</label>
                                    <select name="employeePosition" id="employeePosition" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกตำแหน่ง</option>
                                        <?php foreach ($position as $row2) : ?>
                                            <option value="<?= $row2->POSITION_ID; ?>"<?php if($row->POSITION_ID == $row2->POSITION_ID) echo 'selected'; ?>><?= $row2->POSITION_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>เงินเดือน</label>
                                    <input type="number" name="employeeSalary" class="form-control" min="0" max="9999999" required value="<?=$row->EMPLOYEE_SALARY?>" step="0.01">
                                </div>
                            </div>
                            <br>
                            <br><br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/employee/'); ?>" class="btn btn-danger">ยกเลิก</a>
                                            </div>

                                            <div class="col">
                                                <input  class="btn btn-success" type="submit" value="แก้ไข">
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
        var idTrTel = $('tbody tr:last-child').attr('id');
        idTrTel = idTrTel.substr(3);
        var addphone_id = parseInt(idTrTel);
        $('#addTel').on('click', function() {
            addphone_id++;
            var txt = `<tr id="row${addphone_id}">
                        <td><input type="tel" class="form-control employeeTel" name="employeeTel[]" maxlength="10" minlength="10" required></td>
                        <td><button type="button" id="${addphone_id}" class="btn btn-danger btn-remove float-right">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tr>`;
            $('#bodyTel').append(txt);

            $('.btn-remove').on('click', function() {
                var btn_del = $(this).attr("id");
                $('#row' + btn_del).remove();
            });
            $('.employeeTel').on('keypress', function(e) {
                if (e.charCode >= 48 && e.charCode <= 57) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    });
</script>