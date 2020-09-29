<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขตำแหน่ง</h3>
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
                    <form action="<?= site_url('admin/position/updatePosition') ?>" method="POST">
                        <?php foreach ($oldPos as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowPositionName">
                                    <label>ชื่อตำแหน่ง </label>
                                    <input type="text" name="positionName" class="form-control" id="positionName" value="<?= $row->POSITION_NAME ?>" required>
                                    <input type="hidden" name="oldPositionName" id="oldPositionName" value="<?= $row->POSITION_NAME ?>">
                                    <input type="hidden" name="positionID" value="<?= $row->POSITION_ID ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <label>แผนก </label>
                                    <select name="departmentID" class="form-control" id="departmentID" required>
                                        <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                        <?php foreach ($department as $row2) : ?>
                                            <option value="<?= $row2->DEPARTMENT_ID; ?>" <?php if ($row->DEPT_ID == $row2->DEPARTMENT_ID) echo 'selected'; ?>><?= $row2->DEPARTMENT_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="">สิทธิ์การเข้าใช้งานระบบ</label>
                                    <?php
                                    $permissions = implode(",", $permission);
                                    ?>
                                    <input type="hidden" name="perPosition" id="perPosition" value="<?= $permissions; ?>">
                                    <div class="card boder-0 ">
                                        <div class="card-body">

                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck1" class="chkper" <?php if ($permission[0] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck1">จัดการข้อมูลพนักงาน เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck2" class="chkper" <?php if ($permission[1] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck2">จัดการข้อมูลแผนก เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck3" class="chkper" <?php if ($permission[2] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck3">จัดการข้อมูลตำแหน่ง เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck4" class="chkper" <?php if ($permission[3] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck4">จัดการข้อมูลโต๊ะ เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck5" class="chkper" <?php if ($permission[4] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck5">จัดการข้อมูลสินค้า เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck6" class="chkper" <?php if ($permission[5] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck6">จัดการข้อมูลประเภทสินค้า เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck7" class="chkper" <?php if ($permission[6] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck7">จัดการข้อมูลประเภทเนื้อสัตว์ เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck8" class="chkper" <?php if ($permission[7] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck8">จัดการข้อมูลรับวัตถุดิบ เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck9" class="chkper" <?php if ($permission[8] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck9">จัดการข้อมูลโปรโมชั่น เพิ่ม ลบ แก้ไข</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck10" class="chkper" <?php if ($permission[9] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck10">ออกรายงาน</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck11" class="chkper" <?php if ($permission[10] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck11">ระบบจัดการหน้าร้าน</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck12" class="chkper" <?php if ($permission[11] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck12">ระบบจองคิว</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" id="exampleCheck13" class="chkper" <?php if ($permission[12] == 1) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                                <label class="form-check-label" for="exampleCheck13">ระบบห้องครัว</label>
                                            </div>
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
                                                <a href="<?= site_url('admin/position/'); ?>" class="btn btn-danger ">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input id="btn_update" class="btn btn-success " type="submit" value="บันทึก">
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



<script>
    $(document).ready(function() {

        //Test Start
        function chkName() {
            departmentId = $('#departmentID').val();
            positionName = $('#positionName').val();
            oldname = $('#oldPositionName').val();

            return $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameUpdate') ?>",
                method: "POST",
                async: false,
                data: {
                    departmentId: departmentId,
                    positionName: positionName,
                    oldPositionName: oldname
                },
                success: function(data) {
                    console.log(data);
                    if (data != 0) {
                        $('#btn_update').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');
                    } else {
                        $('#alertidcard').remove();
                        $('#btn_update').removeClass('idFalse');
                    }
                }
            });
        }

        $('#btn_update').on('click', function() {
            chkName();
            if ($('#btn_update').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            } else {
                alert('แก้ไขตำแหน่งเรียบร้อย');
            }

        });

        //Test End



        var departmentId;
        var positionName;
        var oldPositionName;


        $('#departmentID').change(function() {
            departmentId = $(this).val();
            positionName = $('#positionName').val();
            oldname = $('#oldPositionName').val();
            console.log(oldname);
            $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameUpdate') ?>",
                method: "POST",
                data: {
                    departmentId: departmentId,
                    positionName: positionName,
                    oldPositionName: oldname
                },
                success: function(data) {
                    if (data != 0) {
                        $('#btn_update').addClass('idFalse');
                        $('#alertidcard').remove();     
                        $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');

                    } else {
                        $('#alertidcard').remove();
                        $('#btn_update').removeClass('idFalse');
                    }
                }
            });
        });

        $('.chkper').on('click',function() {
            var perList = [];
            $('input[type=checkbox]').each(function() {
                if ($(this).prop("checked") == true) {
                    perList.push(1)
                } else {
                    perList.push(0)
                }
            });
            $('#perPosition').val(perList);
            // console.log(perList);

        });


        // $('#positionName').focusout(function() {
        //     departmentId = $('#departmentID').val();
        //     positionName = $(this).val();
        //     oldname = $('#oldPositionName').val();
        //     console.log(oldname);
        //     $.ajax({
        //         url: "<?= site_url('admin/position/checkPositionNameUpdate') ?>",
        //         method: "POST",
        //         data: {
        //             departmentId: departmentId,
        //             positionName: positionName,
        //             oldPositionName: oldname
        //         },
        //         success: function(data) {
        //             if (data != 0) {
        //                 $('input[name="positionName"]').addClass('idFalse');
        //                 $('#alertidcard').remove();
        //                 // $('#brdept').remove();
        //                 // $('#rowPositionName').append('<br id="brdept">');
        //                 // $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
        //                 $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');

        //             } else {
        //                 $('#alertidcard').remove();
        //                 // $('#brdept').remove();
        //                 $('input[name="positionName"]').removeClass('idFalse');
        //             }
        //         }
        //     });
        // });


        // $('#btn_update').click(function() {
        //     if ($('input[name="positionName"]').hasClass('idFalse')) {
        //         alert('กรุณากรอกข้อมูลให้ถูกต้อง');
        //         return false;
        //     }

        // });

    });
</script>