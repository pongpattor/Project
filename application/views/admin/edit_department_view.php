<h1 class="mt-4">แก้ไขแผนก</h1>
<br>
<div>
    <form action="<?= site_url('admin/admin/updateDepartment') ?>" method="POST" enctype="multipart/form-data">
            <div class="row justify-content-center">
            <?php foreach ($oldDept as $row) : ?>
                <div class="col-5 ">
                    <label>ชื่อแผนก </label>
                    <input type="text" name="DEPARTMENT_NAME" class="form-control" value="<?= $row->DEPARTMENT_NAME ?>">
                    <input type="hidden" name="DEPARTMENT_ID" value="<?= $row->DEPARTMENT_ID?>">
                </div>
            </div>

            <br>
            <div class="row justify-content-center">
                <div class="col-5 ">
                    <center>
                        <div class="input-group">
                            <div class="col">
                                <a href="<?= site_url('admin/admin/department'); ?>" class="btn btn-danger">ยกเลิก</a>
                            </div>
                            <div class="col">
                                <input id="btn_update" class="btn btn-success" type="submit" value="บันทึก">
                            </div>
                        </div>
                    </center>
                </div>
                <?php endforeach; ?>
            </div>
    </form>
    <br>
</div>
<br>