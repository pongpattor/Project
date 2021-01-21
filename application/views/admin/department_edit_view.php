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
                    <form  method="POST" id="editDepartmentForm">
                        <div class="row justify-content-center">
                            <?php foreach ($department as $row) : ?>
                                <div class="col-sm col-md col-xl-6" >
                                    <label>ชื่อแผนก </label>
                                    <input type="text" name="departmentName" id="departmentName" class="form-control" value="<?= $row->DEPARTMENT_NAME ?>" maxlength="50" required>
                                    <span id="departmentNameError" style="color:red;"></span>
                                    <input type="hidden" name="departmentNameOld" id="oldDepartment_name" value="<?= $row->DEPARTMENT_NAME ?>">
                                    <input type="hidden" name="departmentID" value="<?= $row->DEPARTMENT_ID ?>">
                                </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/department/'); ?>" class="btn btn-danger" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input  class="btn btn-success" type="submit" value="แก้ไข">
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
