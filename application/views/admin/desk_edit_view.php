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
                        <form action="<?= site_url('admin/desk/updateDesk') ?>" method="POST">
                            <?php foreach ($desk as $row) { ?>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6" id="rowDeskNumber">
                                        <label>หมายเลขโต๊ะ</label><br>
                                        <input type="text" class="form-control" name="deskNumber" id="deskNumber" value="<?= $row->DESK_NUMBER; ?>" maxlength="3">
                                        <input type="hidden" name="deskID" value="<?= $row->DESK_ID; ?>">
                                        <input type="hidden" name="oldNumber" id="oldNumber" value="<?= $row->DESK_NUMBER; ?>">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6">
                                        <label>สถานะ</label><br>
                                        <select name="status" class="form-control">
                                            <option value="" disabled>กรุณาเลือกสถานะ</option>
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
                                                <input id="btn_update" class="btn btn-success " type="submit" value="บันทึก">
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
<br>

<script>
    $(document).ready(function() {

        function chkDesk() {

            var deskNumber = $('#deskNumber').val();
            var oldNumber = $('#oldNumber').val();
            $.ajax({
                url: "<?= site_url('admin/desk/checkDeskNumberUpdate') ?>",
                method: "POST",
                data: {
                    deskNumber: deskNumber,
                    oldNumber: oldNumber
                },
                async: false,
                success: function(data) {
                    if (data != 0) {
                        // console.log(data);
                        $('#btn_update').removeClass('idTrue');
                        $('#btn_update').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowDeskNumber').append(' <p style="color:red" id="alertidcard">โต๊ะหมายเลขนี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        // console.log(data);
                        $('#alertidcard').remove();
                        $('#btn_update').removeClass('idFalse');
                        $('#btn_update').addClass('idTrue');
                    }
                }
            });
        }

        $('#btn_update').on('click', function() {

            if (confirm('ยืนยันการแก้ไขข้อมูลโต๊ะ')) {
                chkDesk();
                if ($('#btn_update').hasClass('idFalse')) {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    return false;
                }
                else{
                    alert('แก้ไขข้อมูลโต๊ะเสร็จสิ้น');

                }
            }
            else{
                return false;
            }

        });
    });
</script>