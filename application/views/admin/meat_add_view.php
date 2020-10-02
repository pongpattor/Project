<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มเนื้อสัตว์</h3>
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
                    <form action="<?= site_url('admin/meat/insertMeat') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowMeat">
                                <label>ชื่อเนื้อสัตว์</label>
                                <input type="text" name="meatName" id="meatName" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/meat/'); ?>" class="btn btn-danger">ยกเลิก</a>
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



    function chkMeat() {
            var meatName = $('#meatName').val();
            $.ajax({
                url: "<?= site_url('admin/meat/checkMeatName') ?>",
                method: "POST",
                data: {
                    meatName: meatName
                },
                async: false,
                success: function(data) {
                    if (data != 0) {
                        $('#btn_regis').removeClass('meatTrue');
                        $('#btn_regis').addClass('meatFalse');
                        $('#alertMeat').remove();
                        $('#rowMeat').append(' <p style="color:red" id="alertMeat">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        $('#alertMeat').remove();
                        $('#btn_regis').removeClass('meatFalse');
                        $('#btn_update').addClass('meatTrue');
                    }
                }
            });
        };

        $('#btn_regis').on('click',function() {
            chkMeat();
            if ($('#btn_regis').hasClass('meatFalse')) {
                alert('ชื่อเนื้อสัตว์นี้ได้ถูกใช้ไปแล้ว');
                return false;
            }

        });


    });
</script>