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
                    <form method="POST" id="editTypeProduct">
                        <?php foreach ($typeProduct as $row) { ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" >
                                    <label>ชื่อประเภทสินค้า</label><br>
                                    <input type="text" class="form-control" name="typeProductName" id="typeProductName" value="<?= $row->TYPEPRODUCT_NAME ?>" required>
                                    <input type="hidden" name="typeProductID" value="<?= $row->TYPEPRODUCT_ID; ?>">
                                    <input type="hidden" name="typeProductNameOld" id="typeProductNameOld" value="<?= $row->TYPEPRODUCT_NAME; ?>">
                                    <input type="hidden" name="typeProductGroupOld" id="typeProductGroupOld" value="<?= $row->TYPEPRODUCT_GROUP; ?>">
                                    <span id="typeProductNameError" style="color :red;"></span>
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
                                            <input  class="btn btn-success " type="submit" value="แก้ไข">
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
