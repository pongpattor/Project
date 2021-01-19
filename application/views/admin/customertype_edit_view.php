<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มแผนก</h3>
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
                    <form method="POST" id="formCustomerType">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อประเภทสมาชิก </label>
                                <input type="text" name="customerTypeName" id="customerTypeName" class="form-control " maxlength="50">
                                <span id="customerTypeNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ส่วนลด(%) </label>
                                <input type="text" name="customerTypeDiscount" id="customerTypeDiscount" class="form-control " maxlength="3">
                                <span id="customerTypeDiscountError" style="color: red;"> </span>

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ส่วนลดวันเกิด(%) </label>
                                <input type="text" name="customerTypeDiscountBdate" id="customerTypeDiscountBdate" class="form-control " maxlength="3">
                                <span id="customerTypeDiscountBdateError" style="color: red;"> </span>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/customertype/'); ?>" class="btn btn-danger" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_add" class="btn btn-success" type="submit" value="  เพิ่ม  ">
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


