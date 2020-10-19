<br>
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มสินค้า</h3>
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
                    <form action="<?= site_url('admin/product/insertProduct') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <div class="row">
                                    <div class="col">
                                        <label>เลือกรูปภาพสินค้า <span style="color: red;">* </label>
                                        <input type="file" name="imgProduct" class="form-control-file" id="imgProduct" accept="image/*" required>
                                    </div>
                                    <div class="col">
                                        <img id="imgPreview" src="#" width="150px" height="150px" class="float-right img" style="border-style:inset;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ชื่อสินค้า</label><br>
                                <input type="text" class="form-control" name="productName" id="productName" required>
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
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ประเภทสินค้า</label><br>
                                <select name="typeProductName" id="typeProductName" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกประเภทสินค้า</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowMeat">
                                <label>เนื้อสัตว์</label><br>
                                <select name="meatName" id="meatName" class="form-control" required disabled>
                                    <option value="" selected disabled>กรุณาเลือกเนื้อสัตว์</option>
                                    <?php foreach ($meat as $row) { ?>
                                        <option value="<?= $row->MEAT_ID ?>"><?= $row->MEAT_NAME ?></option>
                                    <?php } ?>
                                </select>
                                <p style="color:red" id="alertidcard">*เฉพาะหมวดหมู่อาหาร</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ราคาทุน</label><br>
                                <input type="number" class="form-control" name="costPrice" id="costPrice" required step="0.01" min="0" max="9999999.99">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ราคาขาย</label><br>
                                <input type="number" class="form-control" name="sellPrice" id="sellPrice" required step="0.01" min="0" max="9999999.99">
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/product/'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
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

        function checkProductName() {
            var productName = $('#productName').val();
            var typeProductGroup = $('#typeProductGroup').val();
            var typeProductName = $('#typeProductName').val();
            var meatName = $('#meatName').val();

            //    console.log(productName);
            //    console.log(typeProductGroup);
            //    console.log(typeProductName);
            //    console.log(meatName);

            $.ajax({
                url: "<?= site_url("admin/product/checkProductName"); ?>",
                method: "POST",
                data: {
                    productName: productName,
                    typeProductGroup: typeProductGroup,
                    typeProductName: typeProductName,
                    meatName: meatName,
                },
                async: false,
                success: function(data) {
                    if (data == 0) {
                        $('#alertProduct').remove();
                        $('#btn_regis').removeClass('False');
                    } else {
                        $('#btn_regis').addClass('False');
                        $('#alertProduct').remove();
                        $('#rowTypeProductName').append(' <p style="color:red" id="alertProduct">ชื่อสินค้านี้ได้ถูกใช้ไปแล้ว</p>');
                    }
                }
            });
        }

        $('#btn_regis').on('click', function() {
            checkProductName();
            if($('#btn_regis').hasClass('False')){
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }
            else{
                alert('เพิ่มข้อมูลสินค้าเสร็จสิ้น');

            }
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