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
                    <form  method="POST" id="addTypeProductForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" >
                                <label>ชื่อประเภทสินค้า</label><br>
                                <input type="text" class="form-control" name="typeProductName" id="typeProductName" required maxlength="50">
                                <span id="typeProductNameError" style="color :red;"></span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>หมวดหมู่สินค้า</label><br>
                                <select name="typeProductGroup" id="typeProductGroup" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกหมวดหมู่สินค้า</option>
                                    <option value="1">อาหาร</option>
                                    <option value="2">เครื่องดื่ม</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/typeproduct/'); ?>" class="btn btn-danger  ">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success " type="submit" value="  เพิ่ม  ">
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