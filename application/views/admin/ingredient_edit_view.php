<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขวัตถุดิบ</h3>
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
                    <form method="POST" id="editIngredientForm">
                        <?php foreach ($ingredient as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>ชื่อวัตถุดิบ </label>
                                    <input type="text" name="ingredientName" id="ingredientName" class="form-control" value="<?= $row->INGREDIENT_NAME ?>" required maxlength="50">
                                    <input type="hidden" name="ingredientID" value="<?= $row->INGREDIENT_ID ?>">
                                    <input type="hidden" name="ingredientNameOld" value="<?= $row->INGREDIENT_NAME ?>">
                                    <span id="ingredientNameError" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label>สถานะ</label>
                                    <select name="ingredientActive" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกสถานะ</option>
                                        <option value="1" <?php if ($row->INGREDIENT_ACTIVE == '1') {
                                                                echo 'selected';
                                                            } ?>>มี</option>
                                        <option value="2" <?php if ($row->INGREDIENT_ACTIVE == '2') {
                                                                echo 'selected';
                                                            } ?>>หมด</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/ingredient/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="แก้ไข">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>