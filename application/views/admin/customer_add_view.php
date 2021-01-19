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
                                <label>ชื่อ </label>
                                <input type="text" name="customerFirstName" id="customerFirstName" class="form-control" maxlength="50">
                                <span id="customerFirstNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>นามสกุล </label>
                                <input type="text" name="customerLastName" id="customerLastName" class="form-control " maxlength="3">
                                <span id="customerLastNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เพศ </label>
                                <select id="customerGender" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกคำนำหน้า</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerTypeNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>วันเกิด</label>
                                <input type="date" name="customerBdate" id="customerBdate" class="form-control " maxlength="3">
                                <span id="customerBdateError" style="color: red;"> </span>
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
                                            <td><input type="tel" class="form-control telphone" name="customerTel[]"></td>
                                            <td>
                                                <button type="button" id="addphone" class="btn btn-info float-right"><i class="fa fa-plus"></i></button>
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
                                <textarea name="customerAddress" id="customerAddress" class="form-control" rows="5" maxlength="100"></textarea>
                                <span id="customerAddressError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เพศ </label>
                                <select id="customerGender" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกคำนำหน้า</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerTypeNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จังหวัด</label>
                                <select id="customerProvince" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกจังหวัด</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerProvinceError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>เขต</label>
                                <select id="customerAmphur" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกเขต</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerAmphurError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>แขวง</label>
                                <select id="customerDistrict" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกแขวง</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerDistrictError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>รหัสไปรษณีย์</label>
                                <select id="customerPostCode" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกแขวง</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerPostCodeError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ประเภทสมาชิก</label>
                                <select id="customerType" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือกแขวง</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                                <span id="customerTypeError" style="color: red;"> </span>
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