<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขล็อตวัตถุดิบ</h3>
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
                    <form method="POST" id="editLotIngredientForm">
                        <?php foreach ($lotingredient as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-7 ">
                                    <label for="lotEmployee">ผู้รับ</label>
                                    <input type="text" name="lotEmployee" id="lotEmployee" value="<?= $row->EMPLOYEE_FIRSTNAME . ' ' . $row->EMPLOYEE_LASTNAME; ?>" class="form-control" disabled>
                                    <input type="hidden" name="lotEmployeeID" id="lotEmployeeID" value="<?= $row->EMPLOYEE_ID ?>" class="form-control">
                                    <input type="hidden" name="lotID" id="lotID" value="<?= $row->LOT_ID ?>" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-7">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lotIngredientModal">
                                        เลือกวัตถุดิบ
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="lotIngredientModal" tabindex="-1" role="dialog" aria-labelledby="lotIngredientModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-lg" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="lotIngredientModalLabel">วัตถุดิบ</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body ">
                                                    <div class="table-responsive">
                                                        <table id="lotIngredientTable" class="display table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>รหัส</th>
                                                                    <th>ชื่อ</th>
                                                                    <th>เลือก</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $rowI = 1;
                                                                foreach ($ingredient as $row2) : ?>
                                                                    <tr id="row<?= $rowI ?>">
                                                                        <td><?= $row2->INGREDIENT_ID; ?></td>
                                                                        <td><?= $row2->INGREDIENT_NAME; ?></td>
                                                                        <td><button type="button" value="<?= $row2->INGREDIENT_ID ?>" class="selectLotIngredient btn btn-info">เลือก</button></td>
                                                                    </tr>
                                                                <?php $rowI++;
                                                                endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-7">
                                    <table style="width:100%" class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr class="d-flex">
                                                <th style="text-align: center;" class="align-middle col-5">เครื่องดื่ม</th>
                                                <th style="text-align: center;" class="align-middle col-5">ราคา</th>
                                                <th style="text-align: center;" class="align-middle col-2">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyLotIngredient">
                                            <?php $rows = 1;
                                            foreach ($lotdetail as $row3) : ?>
                                                <tr id="rowi<?= $rows ?>" class="d-flex">
                                                    <td style="text-align: center;" class="align-middle col-5 ">
                                                        <input type="text" name="lotIngredientName" value="<?= $row3->INGREDIENT_NAME ?>" class="form-control" disabled>
                                                        <input type="hidden" name="lotIngredientID[]" class="lotIngredientID" value="<?= $row3->INGREDIENT_ID ?>">
                                                    </td>
                                                    <td style="text-align: center;" class="align-middle col-5">
                                                        <input type="number" name="lotIngredientPrice[]" value="<?= $row3->LOTDETAIL_PRICE ?>" min="0" max="999999.99" step="0.01" class="form-control lotIngredientPrice" required>
                                                    </td>
                                                    <td style="text-align: center;" class="align-middle col-2">
                                                        <button type="button" id="<?= $rows ?>" class="btn btn-danger btn-removei"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            <?php $rows++;
                                            endforeach; ?>
                                        </tbody>
                                    </table>
                                    <span id="lotIngredientError" style="color: red;"> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-7 ">
                                    <label for="lotTotalShow">ราคารวม</label>
                                    <input type="text" name="lotTotalShow" id="lotTotalShow" class="form-control" value="<?= $row->LOT_TOTAL; ?>" disabled>
                                    <input type="hidden" name="lotTotal" id="lotTotal" class="form-control" value="<?= $row->LOT_TOTAL; ?>">
                                </div>
                            </div>

                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/lotingredient/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
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