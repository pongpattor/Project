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
                    <form action="<?=site_url('admin/product/insertTypeProduct')?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ชื่อประเภทสินค้า</label><br>
                                <input type="text" class="form-control" name="typeProductName" id="typeProductName">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>กลุ่มสินค้า</label><br>
                                <select name="typeProductGroup" id="typeProductGroup" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกลุ่มสินค้า</option>
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
    $(document).ready(function(){
        $('#typeProductName').focusout(function(){
            var typeProductName = $('#typeProductName').val();
            $.ajax({
                url : "<?=site_url('admin/product/checkTypeProductName')?>",
                method : "POST",
            });
        });
    });
</script>