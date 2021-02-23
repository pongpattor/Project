<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มคิวล่วงหน้า</h3>
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
                    <form method="POST" id="addQueueForm">
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerName">ชื่อผู้จอง </label>
                                <input type="text" name="customerName" id="deskName" class="form-control" required maxlength="50">
                            </div>
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerTel">เบอร์โทร </label>
                                <input type="tel" class="form-control" name="customerTel" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerAmount">จำนวนคน </label>
                                <input type="number" class="form-control" name="customerAmount" min="1" value="1" required>
                            </div>
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="queueTime">เวลาที่จอง </label>
                                <input type="time" name="queueTime" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="queueDate">วันที่จอง </label>
                                <input type="date" name="queueDate" class="form-control" required min="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>โต๊ะ </label>
                                <div class="card boder-0 ">
                                    <div class="card-body">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ห้องคาราโอเกะ </label>
                                <div class="card boder-0 ">
                                    <div class="card-body">
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
                                            <a href="<?= site_url('admin/queue/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
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