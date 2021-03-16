<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มคิวหน้าร้าน</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form method="POST" id="addQueueWalkinForm">
                        <?php foreach ($queueWalkin as $row) : ?>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerName">ชื่อผู้จอง </label>
                                    <input type="text" name="customerName"  class="form-control" required maxlength="50">
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerTel">เบอร์โทร <span id="cusTelError" style="color:red;"></span></label>
                                    <input type="tel" class="form-control" name="customerTel" maxlength="10" minlength="10" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerAmount">จำนวนคน <span id="customerAmountError" style="color:red"></span>
                                    </label>
                                    <input type="number" class="form-control" name="customerAmount" id="customerAmount" min="1" value="1" required>
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="note">หมายเหตุ </label>
                                    <textarea name="note" class="form-control" cols="30" rows="3" maxlength="50"></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/queuewalkin/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
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