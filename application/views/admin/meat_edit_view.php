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
                    <form action="<?= site_url('admin/meat/updateMeat') ?>" method="POST" id="formMeat">
                        <?php foreach ($meat as $row) { ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowMeat">
                                    <label>ชื่อเนื้อสัตว์</label>
                                    <input type="text" name="meatName" id="meatName" class="form-control" value="<?= $row->MEAT_NAME ?>" required>
                                    <input type="hidden" name="meatID" value="<?= $row->MEAT_ID; ?>">
                                    <input type="hidden" name="oldName" id="oldName" value="<?= $row->MEAT_NAME; ?>" id="oldMeatName">
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
                                            <a href="<?= site_url('admin/meat/'); ?>" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_update" class="btn btn-success" type="submit" value="บันทึก">
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
<br>

<script>
    $(document).ready(function() {


        function chkMeat() {
            var meatName = $('#meatName').val();
            var oldName = $('#oldName').val();
            $.ajax({
                url: "<?= site_url('admin/meat/updateCheckMeatName') ?>",
                method: "POST",
                data: {
                    meatName: meatName,
                    oldName: oldName
                },
                async: false,
                success: function(data) {
                    if (data != 0) {
                        $('#btn_update').removeClass('meatTrue');
                        $('#btn_update').addClass('meatFalse');
                        $('#alertMeat').remove();
                        $('#rowMeat').append(' <p style="color:red" id="alertMeat">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        $('#alertMeat').remove();
                        $('#btn_update').removeClass('meatFalse');
                        $('#btn_update').addClass('meatTrue');
                    }
                }
            });
        };

        $('#btn_update').on('click', function() {

            if (confirm('ยืนยันการแก้ไขข้อมูลเนื้อสัตว์')) {
                chkMeat();
                if ($('#btn_update').hasClass('meatFalse')) {
                    alert('ชื่อเนื้อสัตว์นี้ได้ถูกใช้ไปแล้ว');
                    return false;
                }
               
            }
            else{
                return false;
            }
        });

    });
</script>