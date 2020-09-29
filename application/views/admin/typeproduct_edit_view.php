<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขประเภทสินค้า</h3>
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
                    <form action="<?= site_url('admin/typeproduct/updateTypeProduct') ?>" method="POST">
                        <?php foreach ($typeProduct as $row) { ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ชื่อประเภทสินค้า</label><br>
                                    <input type="text" class="form-control" name="typeProductName" id="typeProductName" value="<?= $row->TYPEPRODUCT_NAME ?>" required>
                                    <input type="hidden" name="typeProductId" value="<?=$row->TYPEPRODUCT_ID;?>">
                                    <input type="hidden" name="oldTPName"  id="oldTPName" value="<?=$row->TYPEPRODUCT_NAME;?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>หมวดหมู่สินค้า</label><br>
                                    <select name="typeProductGroup" id="typeProductGroup" class="form-control" required>

                                        <option value="" selected disabled>กรุณาเลือกหมวดหมู่สินค้า</option>
                                        <option value="อาหาร" <?php if ($row->TYPEPRODUCT_GROUP == 'อาหาร') {
                                                                    echo 'selected';
                                                                } ?>>อาหาร</option>
                                        <option value="เครื่องดื่ม" <?php if ($row->TYPEPRODUCT_GROUP == 'เครื่องดื่ม') {
                                                                        echo 'selected';
                                                                    } ?>>เครื่องดื่ม</option>
                                        <option value="ท็อปปิ้ง" <?php if ($row->TYPEPRODUCT_GROUP == 'ท็อปปิ้ง') {
                                                                        echo 'selected';
                                                                    } ?>>ท็อปปิ้ง</option>
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
                                            <a href="<?= site_url('admin/typeproduct/'); ?>" class="btn btn-danger">ยกเลิก</a>
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
<script>
    $(document).ready(function() {

  

        $('#typeProductName').focusout(function() {
            var tpName = $('#typeProductName').val();
            var tpGroup = $('#typeProductGroup').val();
            var tpOldName = $('#oldTPName').val();

            $.ajax({
                url: "<?= site_url('admin/typeproduct/checkTypeProductNameUpdate') ?>",
                method: "POST",
                data: {
                    typeProductName: tpName,
                    typeProductGroup: tpGroup,
                    typeProductOldName : tpOldName
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

        $('#typeProductGroup').change(function() {
            var tpName = $('#typeProductName').val();
            var tpGroup = $('#typeProductGroup').val();
            var tpOldName = $('#oldTPName').val();
            $.ajax({
                url: "<?= site_url('admin/typeproduct/checkTypeProductNameUpdate') ?>",
                method: "POST",
                data: {
                    typeProductName: tpName,
                    typeProductGroup: tpGroup,
                    typeProductOldName : tpOldName
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

        $('#btn_update').click(function() {
            
            if ($('input[name="typeProductName"]').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }
        });
    });
</script>