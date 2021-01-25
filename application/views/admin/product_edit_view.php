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
                    <form id="editProduct" method="POST" enctype="multipart/form-data">
                        <?php foreach ($product as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="row">
                                        <div class="col">
                                            <label>เลือกรูปภาพสินค้า <span style="color: red;">* </label>
                                            <input type="file" name="productImage" class="form-control-file" id="Image" accept="image/png,image/jpeg" >
                                            <input type="hidden" name="productImageOld" value="<?=$row->PRODUCT_IMAGE;?>">
                                            <span id="imageError" style="color:red"></span>                               
                                        </div>
                                        <div class="col">
                                            <img id="imgPreview" src="<?= base_url('assets/image/product/' . $row->PRODUCT_IMAGE) ?>" width="150px" height="150px" class="float-right img" style="border-style:inset;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ชื่อสินค้า</label><br>
                                    <input type="text" class="form-control" name="productName" id="productName" value="<?= $row->PRODUCT_NAME ?>" required maxlength="50">
                                    <input type="hidden" name="productID" value="<?=$row->PRODUCT_ID;?>">
                                    <input type="hidden" name="productNameOld" value="<?=$row->PRODUCT_NAME;?>">
                                    <span id="productNameError" style="color:red"></span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>หมวดหมู่สินค้า</label><br>
                                    <select name="typeProductGroup" id="typeProductGroup" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกหมวดหมู่สินค้า</option>
                                        <option value="1" <?php if ($row->TYPEPRODUCT_GROUP == '1') {
                                                                echo 'selected';
                                                            } ?>>อาหาร</option>
                                        <option value="2" <?php if ($row->TYPEPRODUCT_GROUP == '2') {
                                                                echo 'selected';
                                                            } ?>>เครื่องดื่ม</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ประเภทสินค้า</label><br>
                                    <select name="productType" id="productType" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกประเภทสินค้า</option>
                                        <?php foreach ($typeProduct as $row2) : ?>
                                            <option value="<?= $row2->TYPEPRODUCT_ID ?>" <?php if ($row->TYPEPRODUCT_ID == $row2->TYPEPRODUCT_ID) {
                                                                                                echo 'selected';
                                                                                            } ?>><?= $row2->TYPEPRODUCT_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ราคาทุน</label><br>
                                    <input type="number" class="form-control" value="<?= $row->PRODUCT_COSTPRICE ?>" name="productCostPrice" id="productCostPrice" required step="0.01" min="0" max="9999999.99">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ราคาขาย</label><br>
                                    <input type="number" class="form-control" value="<?= $row->PRODUCT_SELLPRICE ?>" name="productSellPrice" id="productSellPrice" required step="0.01" min="0" max="9999999.99">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>สถานะการใช้งาน</label><br>
                                    <select name="productActive" id="productActive" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกสถานะ</option>
                                        <option value="1" <?php if ($row->PRODUCT_ACTIVE == '1') {
                                                                echo 'selected';
                                                            } ?>>พร้อมใช้งาน</option>
                                        <option value="2" <?php if ($row->PRODUCT_ACTIVE == '2') {
                                                                echo 'selected';
                                                            } ?>>ไม่พร้อมใช้งาน</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <?php endforeach; ?> -->
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/product/'); ?>" class="btn btn-danger ">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input id="btn_update" class="btn btn-success " type="submit" value="แก้ไข">
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
