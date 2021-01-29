<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มโปรโมชั่นเซ็ต</h3>
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
                    <form method="POST" id="addPromotionSetForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionSetID">ชื่อโปรโมชั่นเซ็ต</label>
                                <input type="text" name="promotionSetName" id="promotionSetName" class="form-control" required maxlength="50">
                                <span id="promotionSetNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <!-- <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionSetCost">ราคาทุน</label>
                                <input type="number" name="promotionSetCostShow" id="promotionSetCostShow" class="form-control" value="0" required disabled>
                                <input type="hidden" name="promotionSetCost" id="promotionSetCost">
                            </div>
                        </div> -->
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionSetPrice">ราคาขาย</label>
                                <input type="number" name="promotionSetPrice" id="promotionSetPrice" class="form-control" value="0" min="0" max="999999.99" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionSetDateStart">วันเริ่มต้น</label>
                                <input type="date" name="promotionSetDateStart" id="promotionSetDateStart" class="form-control dateStart" required min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionSetDateEnd">วันสิ้นสุด</label>
                                <input type="date" name="promotionSetDateEnd" id="promotionSetDateEnd" class="form-control dateEnd" required>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#proSetProductModal">
                                    เลือกสินค้า
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="proSetProductModal" tabindex="-1" role="dialog" aria-labelledby="proSetProductModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-lg" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="proSetProductModalLabel">สินค้า</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body ">
                                                <div class="table-responsive">
                                                    <table id="proSetProductTable" class="display table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>รหัส</th>
                                                                <th>ชื่อ</th>
                                                                <th>ราคาทุน</th>
                                                                <th>ราคาขาย</th>
                                                                <th>เลือก</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $rowProduct = 1;
                                                            foreach ($product as $row) : ?>
                                                                <tr id="row<?= $rowProduct ?>">
                                                                    <td><?= $row->PRODUCT_ID; ?></td>
                                                                    <td><?= $row->PRODUCT_NAME; ?></td>
                                                                    <td><?= $row->PRODUCT_COSTPRICE; ?></td>
                                                                    <td><?= $row->PRODUCT_SELLPRICE; ?></td>
                                                                    <td><button type="button" value="<?= $row->PRODUCT_ID ?>" class="selectProSetProduct btn btn-info">เลือก</button></td>
                                                                </tr>
                                                            <?php $rowProduct++;
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
                                            <th style="text-align: center;" class="align-middle col-5">สินค้า</th>
                                            <th style="text-align: center;" class="align-middle col-5">จำนวน</th>
                                            <th style="text-align: center;" class="align-middle col-2">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyProSetProduct">
                                    </tbody>
                                </table>
                                <span id="proSetProductError" style="color: red;"> </span>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/recipe/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
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