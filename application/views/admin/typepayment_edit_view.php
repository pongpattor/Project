<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขประเภทการชำระเงิน</h3>
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
                    <?php foreach ($typepayment as $row) : ?>
                        <form method="POST" id="editTypePaymentForm">
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อประเภทการชำระเงิน </label>
                                    <input type="text" name="typePaymentName" id="typePaymentName" value="<?= $row->TYPEPAYMENT_NAME ?>" class="form-control" maxlength="50" required>
                                    <input type="hidden" name="typePaymentID" value="<?= $row->TYPEPAYMENT_ID ?>">
                                    <input type="hidden" name="typePaymentNameOld" value="<?= $row->TYPEPAYMENT_NAME ?>">
                                    <span id="typePaymentNameError" style="color: red;"> </span>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/payment/typePayment'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="บันทึก">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>