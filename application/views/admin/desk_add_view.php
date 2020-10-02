<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มโต๊ะ</h3>
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

                    <form action="<?= site_url('admin/desk/insertDesk') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowDeskNumber">
                                <label>หมายเลขโต๊ะ</label><br>
                                <input type="text" class="form-control" name="deskNumber" id="deskNumber" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/desk/'); ?>" class="btn btn-danger  ">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success " type="submit" value="  เพิ่ม  ">
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
<br>

<script>
    $(document).ready(function() {

        function chkDesk() {

            var deskNumber = $('#deskNumber').val();
            $.ajax({
                url: "<?= site_url('admin/desk/checkDeskNumber') ?>",
                method: "POST",
                data: {
                    deskNumber: deskNumber
                },
                async : false,
                success: function(data) {
                    if (data != 0) {
                        $('#btn_regis').removeClass('idTrue');
                        $('#btn_regis').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#rowDeskNumber').append(' <p style="color:red" id="alertidcard">โต๊ะหมายเลขนี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        $('#alertidcard').remove();
                        $('#btn_regis').removeClass('idFalse');
                        $('#btn_regis').addClass('idTrue');
                    }
                }
            });
        }

        $('#btn_regis').on('click', function() {
            chkDesk();
            if ($('#btn_regis').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }
        });
    });
</script>