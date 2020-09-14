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

                    <div class="container">
                        <form action="<?= site_url('admin/desk/updateDesk') ?>" method="POST" enctype="multipart/form-data">
                            <?php foreach ($desk as $row) { ?>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6">
                                        <label>หมายเลขโต๊ะ</label><br>
                                        <input type="text" class="form-control" name="deskNumber" id="deskNumber" value="<?= $row->DESK_NUMBER; ?>">
                                        <input type="hidden" name="deskID" value="<?= $row->DESK_ID; ?>">
                                        <input type="hidden" name="oldNumber" value="<?= $row->DESK_NUMBER; ?>">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6">
                                        <label>สถานะ</label><br>
                                        <select name="status" class="form-control">
                                            <option value="0" <?php if ($row->DESK_STATUS == 0) echo 'selected'; ?>>ว่าง</option>
                                            <option value="1" <?php if ($row->DESK_STATUS == 1) echo 'selected'; ?>>ไม่ว่าง</option>
                                            <option value="2" <?php if ($row->DESK_STATUS == 2) echo 'selected'; ?>>ปรับปรุง</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/desk/'); ?>" class="btn btn-danger  ">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input id="btn_regis" class="btn btn-success " type="submit" value="  บันทึก  ">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <br>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>