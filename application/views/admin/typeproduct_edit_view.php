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
                                    <input type="hidden" name="typeProductId" value="<?= $row->TYPEPRODUCT_ID; ?>">
                                    <input type="hidden" name="oldTPName" id="oldTPName" value="<?= $row->TYPEPRODUCT_NAME; ?>">
                                    <input type="hidden" name="oldGPName" id="oldGPName" value="<?= $row->TYPEPRODUCT_GROUP; ?>">

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

        function chkTypeName() {
            tpName = $('#typeProductName').val();
            OldName = $('#oldTPName').val();
            tpGroup = $('#typeProductGroup').val();

            gOldName = $('#oldGPName').val();
            console.log(tpName);
            console.log(OldName);
            console.log(tpGroup);
            console.log(gOldName);
            $.ajax({
                url: "<?= site_url('admin/typeproduct/checkTypeProductNameUpdate') ?>",
                method: "POST",
                data: {
                    typeProductName: tpName,
                    typeProductOldName: OldName,
                    typeProductGroup: tpGroup,
                    typeProductOldGroup: gOldName,
                },
                async: false,
                success: function(data) {
                    console.log(data);
                    if (data != 0) {
                        $('#btn_update').removeClass('typeTrue');
                        $('#btn_update').addClass('typeFalse');
                        $('#alertTypeName').remove();
                        $('#rowTypeProductName').append(' <p style="color:red" id="alertTypeName">ชื่อประเภทสินค้านี้ได้ถูกใช้ไปแล้ว</p>');
                    } else {
                        $('#alertTypeName').remove();
                        $('#btn_update').removeClass('typeFalse');
                        $('#btn_update').addClass('typeTrue');
                    }
                }
            });
        };


        $('#btn_update').on('click', function() {
            if (confirm('ยืนยันการแก้ไขข้อมูลประเภทสินค้า')) {
                chkTypeName();
                if ($('#btn_update').hasClass('typeFalse')) {
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    return false;
                }
                else{
                    alert('แก้ไขข้อมูลประเภทสินค้าเสร็จสิ้น');
                }
            }
            else{
                return false;
            }

        });
    });
</script>