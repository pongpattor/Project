<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขสินค้า</h3>
                </div>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?= site_url('admin/product/updateProduct') ?>" method="POST" enctype="multipart/form-data">
                        <?php foreach ($product as $row) { ?>

                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="row">
                                        <div class="col">
                                            <label>เลือกรูปภาพสินค้า <span style="color: red;">* </label>
                                            <input type="file" name="imgProduct" class="form-control-file" id="imgProduct" accept="image/*">
                                        </div>
                                        <div class="col">
                                            <img id="imgPreview" src="<?= base_url('assets/image/product/' . $row->PRODUCT_IMG) ?>" width="150px" height="150px" class="float-right img" style="border-style:inset;" />
                                            <input type="hidden" name="oldImg" value="<?= $row->PRODUCT_IMG ?>">
                                            <input type="hidden" name="productID" value="<?= $row->PRODUCT_ID ?>">
                                            <input type="hidden" name="oldName" value="<?= $row->PRODUCT_NAME ?>">
                                            <input type="hidden" name="oldType" value="<?= $row->TYPEPRODUCT_ID ?>">
                                            <input type="hidden" name="oldTpGroup" value="<?= $row->TYPEPRODUCT_GROUP?>">
                                            <input type="hidden" name="oldMeat" value="<?=$row->MEAT_FOOD_ID?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ชื่อสินค้า</label><br>
                                    <input type="text" class="form-control" name="productName" id="productName" value="<?= $row->PRODUCT_NAME; ?>" required>

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
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ประเภทสินค้า</label><br>
                                    <select name="typeProductName" id="typeProductName" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกประเภทสินค้า</option>
                                        <?php foreach ($typeproduct as $row2) { ?>
                                            <option value="<?= $row2->TYPEPRODUCT_ID ?>" <?php if ($row2->TYPEPRODUCT_ID == $row->TYPEPRODUCT_ID) {
                                                                                                echo 'selected';
                                                                                            } ?>><?= $row2->TYPEPRODUCT_NAME ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowMeat">
                                    <label>เนื้อสัตว์</label><br>
                                    <select name="meatName" id="meatName" class="form-control" required <?php if ($row->TYPEPRODUCT_GROUP != 'อาหาร') {
                                                                                                            echo 'disabled';
                                                                                                        } ?>>
                                        <option value="" selected disabled>กรุณาเลือกเนื้อสัตว์</option>
                                        <?php foreach ($meat as $row2) { ?>
                                            <option value="<?= $row2->MEAT_ID ?>" <?php if ($row2->MEAT_ID == $row->MEAT_FOOD_ID) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $row2->MEAT_NAME ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($row->TYPEPRODUCT_GROUP != 'อาหาร') {
                                        echo '<p style="color:red" id="alertidcard">*เฉพาะหมวดหมู่อาหาร</p>';
                                    } ?>


                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ราคาทุน</label><br>
                                    <input type="number" class="form-control" name="costPrice" id="costPrice" required step="0.01" min="0" max="9999999.99" value="<?= $row->PRODUCT_COSTPRICE; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ราคาขาย</label><br>
                                    <input type="number" class="form-control" name="sellPrice" id="sellPrice" required step="0.01" min="0" max="9999999.99" value="<?= $row->PRODUCT_SELLPRICE; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/product/'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success col-7" type="submit" value="บันทึก">
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

        $('#typeProductGroup').change(function() {
            var tpGroup = $('#typeProductGroup').val();

            if (tpGroup == 'อาหาร') {
                $('#meatName').prop('disabled', false);
                $('#alertidcard').remove();
            } else {
                $('#meatName').prop('disabled', true);
                $("#meatName").prop('selectedIndex', 0);
                $('#alertidcard').remove();
                $('#rowMeat').append(' <p style="color:red" id="alertidcard">*เฉพาะหมวดหมู่อาหาร</p>');
            }
            $.ajax({
                url: "<?= site_url('admin/product/fetchTypeProductName') ?>",
                method: "POST",
                data: {
                    typeProductGroup: tpGroup
                },
                success: function(data) {
                    $('#typeProductName').html(data);
                }
            });
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgProduct").change(function() {
            readURL(this);
        });
    });
</script>