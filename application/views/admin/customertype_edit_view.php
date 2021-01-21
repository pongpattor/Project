<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขประเภทสมาชิก</h3>
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
                    <form id="editCustomerTypeForm">
                        <?php foreach ($customerType as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อประเภทสมาชิก </label>
                                    <input type="hidden" name="customerTypeID" value="<?= $row->CUSTOMERTYPE_ID; ?>">
                                    <input type="hidden" name="customerTypeNameOld" value="<?= $row->CUSTOMERTYPE_NAME; ?>">
                                    <input type="text" name="customerTypeName" id="customerTypeName" class="form-control" maxlength="20" required value="<?= $row->CUSTOMERTYPE_NAME; ?>">
                                    <span id="customerTypeNameError" style="color: red;"> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ส่วนลด(%) </label>
                                    <input type="number" name="customerTypeDiscount" id="customerTypeDiscount" class="form-control" min="0" max="100" required value="<?= $row->CUSTOMERTYPE_DISCOUNT; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ส่วนลดวันเกิด(%) </label>
                                    <input type="number" name="customerTypeDiscountBdate" id="customerTypeDiscountBdate" class="form-control" min="0" max="100" required value="<?= $row->CUSTOMERTYPE_DISCOUNTBDATE; ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/customertype/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="แก้ไข">
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