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
                    <form id="addProduct" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <div class="row">
                                    <div class="col">
                                        <label>เลือกรูปภาพสินค้า <span style="color: red;">* </label>
                                        <input type="file" name="productImage" class="form-control-file" id="Image" accept="image/png,image/jpeg" required>
                                        <span id="imageError" style="color:red"></span>
                                    </div>
                                    <div class="col">
                                        <img id="imgPreview" src="#" width="150px" height="150px" class="float-right img" style="border-style:inset;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ชื่อสินค้า</label><br>
                                <input type="text" class="form-control" name="productName" id="productName" required maxlength="50">
                                <span id="productNameError" style="color:red"></span>
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
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ประเภทสินค้า</label><br>
                                <select name="productType" id="productType" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกประเภทสินค้า</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ราคาทุน</label><br>
                                <input type="number" class="form-control" name="productCostPrice" id="productCostPrice" required step="0.01" min="0" max="9999999.99">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ราคาขาย</label><br>
                                <input type="number" class="form-control" name="productSellPrice" id="productSellPrice" required step="0.01" min="0" max="9999999.99">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>แนะนำสินค้า</label><br>
                                <select name="productRecommended" id="productRecommended" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแนะนำสินค้า</option>
                                    <option value="1">แนะนำ</option>
                                    <option value="0">ไม่แนะนำ</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/product/'); ?>" class="btn btn-danger ">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success " type="submit" value="  เพิ่ม  ">
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