<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มแผนก</h3>
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
                    <form action="<?= site_url('admin/department/insertDepartment') ?>" method="POST" id="formDepartment">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowDeptName">
                                <label>ชื่อแผนก </label>
                                <input type="text" name="DEPARTMENT_NAME" id="department_name" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/department/'); ?>" class="btn btn-danger">ยกเลิก</a>
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
<script>
    $(document).ready(function() {

        // $('#btn_regis').click(function(e) {
        //     e.preventDefault();
        //     var deptName = $('#department_name').val();
        //     if(deptName == ""){
        //         alert('ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว')   ;               
        //     }
        //     else{
        //         $.ajax({
        //             url: "<?= site_url('admin/department/checkDepartmentNameInsert') ?>",
        //             method: "POST",
        //             data: {
        //                 departmentName: deptName
        //             },
        //             success: function(data) {
        //                 if (data != 0) {
        //                     alert('ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว')                  
        //                 } else {
        //                     $('#formDepartment').submit();
        //                 }
        //             }
        //         });
        //     }
               
        // });

        $('#btn_regis').click(function() {
            if ($('input[name="DEPARTMENT_NAME"]').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }
        });

        $('#department_name').on('focusout', function() {
            var deptName = $('#department_name').val();
            $.ajax({
                url: "<?= site_url('admin/department/checkDepartmentNameInsert') ?>",
                method: "POST",
                data: {
                    departmentName: deptName
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="DEPARTMENT_NAME"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        // $('#rowDeptName').append('<br id="brdept">');
                        // $('#rowDeptName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</div>');
                        $('#rowDeptName').append(' <p style="color:red" id="alertidcard">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</p>');

                    } else {
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        $('input[name="DEPARTMENT_NAME"]').removeClass('idFalse');
                    }
                }
            });
        })
    });
</script>