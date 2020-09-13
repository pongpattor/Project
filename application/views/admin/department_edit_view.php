<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขแผนก</h3>
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
                    <form action="<?= site_url('admin/employee/updateDepartment') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <?php foreach ($oldDept as $row) : ?>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อแผนก </label>
                                    <input type="text" name="DEPARTMENT_NAME" class="form-control" value="<?= $row->DEPARTMENT_NAME ?>">
                                    <input type="hidden" name="DEPARTMENT_ID" value="<?= $row->DEPARTMENT_ID ?>">
                                </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/employee/department'); ?>" class="btn btn-danger">ยกเลิก</a>
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
                </div>
            </div>
        </div>
    </div>
</div>