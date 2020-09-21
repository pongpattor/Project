<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขเนื้อสัตว์</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="container" id="bodyCard">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?= site_url('admin/product/updateMeat') ?>" method="POST" id="formMeat">
                        <?php foreach ($meat as $row) { ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowMeat">
                                    <label>ชื่อเนื้อสัตว์</label>
                                    <input type="text" name="meatName" id="meatName" class="form-control" value="<?= $row->MEAT_NAME ?>" required>
                                    <input type="hidden" name="meatID" value="<?= $row->MEAT_ID; ?>">
                                    <input type="hidden" name="oldName" value="<?= $row->MEAT_NAME; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowMeat">
                                    <label>สถานะ</label>
                                    <select name="meatStatus" id="meatStatus" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกสถานะ</option>
                                        <option value="1" <?php if ($row->MEAT_STATUS == 1) {
                                                                echo 'selected';
                                                            } ?>>มี</option>
                                        <option value="0" <?php if ($row->MEAT_STATUS == 2) {
                                                                echo 'selected';
                                                            } ?>>หมด</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/product/meat'); ?>" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success" type="submit" value="  เพิ่ม  ">
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