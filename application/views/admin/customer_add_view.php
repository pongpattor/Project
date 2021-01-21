<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มสมาชิก</h3>
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
                    <form method="POST" id="addCustomerForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>บัตรประจำตัวประชาชน </label>
                                <input type="text" name="customerIdCard" id="customerIdCard" class="form-control" maxlength="13" minlength="13" required>
                                <span id="customerIdCardError" style="color: red; "> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อ </label>
                                <input type="text" name="customerFirstName" id="customerFirstName" class="form-control" maxlength="20" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>นามสกุล </label>
                                <input type="text" name="customerLastName" id="customerLastName" class="form-control " maxlength="20" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เพศ </label>
                                <select id="customerGender" name="customerGender" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกเพศ</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>วันเกิด</label>
                                <input type="date" name="customerBdate" id="customerBdate" class="form-control " max="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <table style="width:100%" id="tablePhone">
                                    <tbody id="bodyTel">
                                        <tr>
                                            <td>เบอร์โทร</td>
                                        </tr>
                                        <tr id="row1">
                                            <td><input type="tel" class="form-control customerTel" name="customerTel[]" maxlength="10" minlength="10" required></td>
                                            <td>
                                                <button type="button" id="addCustomerTel" class="btn btn-info float-right"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span id="customerTelError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ที่อยู่</label>
                                <textarea name="customerAddress" id="customerAddress" class="form-control" rows="5" maxlength="100" required></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จังหวัด</label>
                                <select id="province" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                                    <?php foreach ($province as $row) : ?>
                                        <option value="<?= $row->PROVINCE_ID; ?>"><?= $row->PROVINCE_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เขต</label>
                                <select id="amphur" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกเขต</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>แขวง</label>
                                <select id="district" name="district" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสไปรษณีย์</label>
                                <select id="postcode" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกรหัสไปรษณีย์</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ประเภทสมาชิก</label>
                                <select id="customerType" name="customerType" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแขวง</option>
                                    <?php foreach ($customerType as $row) : ?>
                                        <option value="<?= $row->CUSTOMERTYPE_ID ?>"><?= $row->CUSTOMERTYPE_NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/customer/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
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