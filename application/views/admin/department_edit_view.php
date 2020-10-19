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
                    <form action="<?= site_url('admin/department/updateDepartment') ?>" method="POST" id="formDepartment">
                        <div class="row justify-content-center">
                            <?php foreach ($oldDept as $row) : ?>
                                <div class="col-sm col-md col-xl-6" id="rowDeptName">
                                    <label>ชื่อแผนก </label>
                                    <input type="text" name="DEPARTMENT_NAME" id="department_name" class="form-control" value="<?= $row->DEPARTMENT_NAME ?>" required maxlength="50">
                                    <input type="hidden" name="oldDepartment_name" id="oldDepartment_name" value="<?= $row->DEPARTMENT_NAME ?>">
                                    <input type="hidden" name="DEPARTMENT_ID" value="<?= $row->DEPARTMENT_ID ?>">
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
<script>
    $(document).ready(function() {


        function chkName() {
            var deptName = $('#department_name').val();
            var oldDeptName = $('#oldDepartment_name').val();
            $.ajax({
                url: "<?= site_url('admin/department/checkDepartmentNameUpdate') ?>",
                method: "POST",
                async: false,
                data: {
                    departmentName: deptName,
                    oldDepartmentName: oldDeptName
                },
                success: function(data) {
                    if (data != 0) {
                        $('#btn_update').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowDeptName').append(' <p style="color:red" id="alertidcard">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        $('#alertidcard').remove();
                        $('#btn_update').removeClass('idFalse');
                    }
                }
            });
        }



        $('#btn_update').on('click', function() {

            if (confirm('ยืนยันการแก้ไขข้อมูลแผนก')) {
                chkName();
                if ($('#btn_update').hasClass('idFalse')) {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    return false;
                } else {
                    alert('แก้ไขเสร็จสิ้น');
                }
            }
            else{
                return false;
            }

        });

        // $('#btn_cancel').on('click', function() {
        //     var deptName = $('#department_name').val();
        //     var oldDeptName = $('#oldDepartment_name').val();
        //     if (deptName != oldDeptName) {
        //         confirm("คุณต้องการยกเลิกการแก้ไขใช่หรือไม่?");
        //     }
        // });



    });
</script>