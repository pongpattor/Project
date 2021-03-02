<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขโต๊ะ</h3>
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
                    <form method="POST" id="editDeskForm">
                        <?php foreach ($desk as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อโต๊ะ </label>
                                    <input type="text" name="deskName" id="deskName" class="form-control" value="<?= $row->SEAT_NAME ?>" required maxlength="50">
                                    <input type="hidden" name="deskID" value="<?= $row->SEAT_ID; ?>">
                                    <input type="hidden" name="deskNameOld" value="<?= $row->SEAT_NAME; ?>">
                                    <span id="deskNameError" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>โซนที่นั่ง</label>
                                    <select name="deskZone" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกโซนที่นั่ง</option>
                                        <?php foreach ($zone as $row2) : ?>
                                            <option value="<?= $row2->ZONE_ID; ?>" <?php if ($row->SEAT_ZONE == $row2->ZONE_ID) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $row2->ZONE_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>จำนวนคน </label>
                                    <input type="number" name="deskAmount" id="deskAmount" value="<?= $row->SEAT_AMOUNT ?>" class="form-control" required min="1" max="99">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="deskQueue">อนุมัติการจอง</label>
                                    <select name="deskQueue" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกอนุมัติการจอง</option>
                                        <option value="1" <?php if ($row->SEAT_QUEUE == '1') {
                                                                echo 'selected';
                                                            }?>>สามารถจองได้</option>
                                        <option value="2" <?php if ($row->SEAT_QUEUE == '0') {
                                                                echo 'selected';
                                                            }?>>ไม่สามารถจองได้</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>สถานะการใช้งาน </label>
                                    <select name="deskActive" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกสถานะการใช้งาน</option>
                                        <option value="1" <?php if ($row->SEAT_ACTIVE == '1') {
                                                                echo 'selected';
                                                            } ?>>พร้อมใช้งาน</option>
                                        <option value="2" <?php if ($row->SEAT_ACTIVE == '0') {
                                                                echo 'selected';
                                                            } ?>>ไม่พร้อมใช้งาน</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/desk/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
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