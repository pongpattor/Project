<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มประเภทสินค้า</h3>
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
                    <form action="<?= site_url('admin/product/insertTypeProduct') ?>" method="POST" id="formTypeProduct">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ชื่อประเภทสินค้า</label><br>
                                <input type="text" class="form-control" name="typeProductName" id="typeProductName" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>หมวดหมู่สินค้า</label><br>
                                <select name="typeProductGroup" id="typeProductGroup" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกหมวดหมู่สินค้า</option>
                                    <option value="อาหาร">อาหาร</option>
                                    <option value="เครื่องดื่ม">เครื่องดื่ม</option>
                                    <option value="ท็อปปิ้ง">ท็อปปิ้ง</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/product/typeProduct/'); ?>" class="btn btn-danger  ">ยกเลิก</a>
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
<script>
    $(document).ready(function() {

   


        $('#btn_regis').click(function() {
            if ($('input[name="typeProductName"]').hasClass('idFalse')) {
                 alert('มีชื่อประเภทนี้ในหมวดหมู่สินค้าแล้ว');
                return false;
            }

        });

        $('#typeProductGroup').change(function() {
            tpGroup = $(this).val();
            tpName = $('#typeProductName').val();
            // console.log(tpGroup);
            // console.log(tpName);
            $.ajax({
                url: "<?= site_url('admin/product/checkTypeProductName') ?>",
                method: "POST",
                data: {
                    typeProductName: tpName,
                    typeProductGroup: tpGroup
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="typeProductName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        // $('#rowPositionName').append('<br id="brdept">');
                        // $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                        $('#rowTypeProductName').append(' <p style="color:red" id="alertidcard">มีชื่อประเภทนี้ในหมวดหมู่สินค้าแล้ว</p>');

                        return false;

                    } else {
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        $('input[name="typeProductName"]').removeClass('idFalse');
                    }
                }
            });
        });

        $('#typeProductName').focusout(function() {
            tpGroup = $('#typeProductGroup').val();
            tpName = $(this).val();
            // console.log(tpGroup);
            // console.log(tpName);
            $.ajax({
                url: "<?= site_url('admin/product/checkTypeProductName') ?>",
                method: "POST",
                data: {
                    typeProductName: tpName,
                    typeProductGroup: tpGroup
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="typeProductName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        // $('#rowPositionName').append('<br id="brdept">');
                        // $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                        $('#rowTypeProductName').append(' <p style="color:red" id="alertidcard">มีชื่อประเภทนี้ในหมวดหมู่สินค้าแล้ว</p>');

                    } else {
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        $('input[name="typeProductName"]').removeClass('idFalse');
                    }
                }
            });
        });

        $('#formTypeProduct').submit(function(){

        },2000);
    });
</script>