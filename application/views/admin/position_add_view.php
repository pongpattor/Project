<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มตำแหน่ง</h3>
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
                    <form action="<?= site_url('admin/position/insertPos') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  " id="rowPositionName">
                                <label>ชื่อตำแหน่ง </label>
                                <input type="text" name="positionName" id="positionName" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>แผนก </label>
                                <select name="departmentID" id="departmentID" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="">สิทธิ์การเข้าใช้งานระบบ</label>
                                <input type="hidden" name="perPosition" id="perPosition" value="0,0,0,0,0,0,0,0,0,0,0,0,0">
                                <div class="card boder-0 ">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck1" class="chkper">
                                            <label class="form-check-label" for="exampleCheck1">จัดการข้อมูลพนักงาน เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck2" class="chkper">
                                            <label class="form-check-label" for="exampleCheck2">จัดการข้อมูลแผนก เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck3" class="chkper">
                                            <label class="form-check-label" for="exampleCheck3">จัดการข้อมูลตำแหน่ง เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck4" class="chkper">
                                            <label class="form-check-label" for="exampleCheck4">จัดการข้อมูลโต๊ะ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck5" class="chkper">
                                            <label class="form-check-label" for="exampleCheck5">จัดการข้อมูลสินค้า เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck6" class="chkper">
                                            <label class="form-check-label" for="exampleCheck6">จัดการข้อมูลประเภทสินค้า เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck7" class="chkper">
                                            <label class="form-check-label" for="exampleCheck7">จัดการข้อมูลประเภทเนื้อสัตว์ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck8" class="chkper">
                                            <label class="form-check-label" for="exampleCheck8">จัดการข้อมูลรับวัตถุดิบ เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck9" class="chkper">
                                            <label class="form-check-label" for="exampleCheck9">จัดการข้อมูลโปรโมชั่น เพิ่ม ลบ แก้ไข</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck10" class="chkper">
                                            <label class="form-check-label" for="exampleCheck10">ออกรายงาน</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck11" class="chkper">
                                            <label class="form-check-label" for="exampleCheck11">ระบบจัดการหน้าร้าน</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck12" class="chkper">
                                            <label class="form-check-label" for="exampleCheck12">ระบบจองคิว</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="permission[]" id="exampleCheck13" class="chkper">
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
                                            <a href="<?= site_url('admin/position/'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success col-7" type="submit" value="เพิ่ม">
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

ิ<br>
<script>
    $(document).ready(function() {

        function chkName() {
            departmentId = $('#departmentID').val();
            positionName = $('#positionName').val();
             $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameInsert') ?>",
                method: "POST",
                async: false,
                data: {
                    departmentId: departmentId,
                    positionName: positionName
                },
                success: function(data) {
                    if (data != 0) {
                        $('#btn_regis').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');
                    } else {
                        $('#alertidcard').remove();
                        $('#btn_regis').removeClass('idFalse');
                    }
                }
            });
        }

        $('#btn_regis').on('click', function() {
            chkName();
            if ($('#btn_regis').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            } 

        });

        $('.chkper').click(function() {
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


    });
</script>