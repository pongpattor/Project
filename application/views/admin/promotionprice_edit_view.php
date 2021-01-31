<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขโปรโมชั่นลดราคา</h3>
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
                    <form method="POST" id="editPromotionPrice">
                    <?php foreach($promotionprice as $row) : ?>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionPriceName">ชื่อโปรโมชั่นลดราคา</label>
                                <input type="text" name="promotionPriceName" id="promotionPriceName" value="<?=$row->PROMOTIONPRICE_NAME?>" class="form-control" required maxlength="50">
                                <input type="hidden" name="promotionPriceNameOld" id="promotionPriceNameOld" value="<?=$row->PROMOTIONPRICE_NAME?>" >
                                <input type="hidden" name="promotionPriceID" id="promotionPriceID" value="<?=$row->PROMOTIONPRICE_ID?>" >
                                <span id="promotionPriceNameError" style="color: red;"> </span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionPriceDiscount">ส่วนลด</label>
                                <input type="number" name="promotionPriceDiscount" id="promotionPriceDiscount"  value="<?=$row->PROMOTIONPRICE_DISCOUNT?>" class="form-control" value="0" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionPriceDateStart">วันเริ่มต้น</label>
                                <input type="date" name="promotionPriceDateStart" id="promotionPriceDateStart"  value="<?=$row->PROMOTIONPRICE_DATESTART?>" class="form-control dateStart" required min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 ">
                                <label for="promotionPriceDateEnd">วันสิ้นสุด</label>
                                <input type="date" name="promotionPriceDateEnd" id="promotionPriceDateEnd"  value="<?=$row->PROMOTIONPRICE_DATEEND?>" class="form-control dateEnd" required>
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
                                                    <table id="proPriceProduct" class="display table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>รหัส</th>
                                                                <th>ชื่อ</th>
                                                                <th>เลือก</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $rowProduct = 1;
                                                            foreach ($product as $row2) : ?>
                                                                <tr id="row<?= $rowProduct ?>">
                                                                    <td><?= $row2->PRODUCT_ID; ?></td>
                                                                    <td><?= $row2->PRODUCT_NAME; ?></td>
                                                                    <td><button type="button" value="<?= $row2->PRODUCT_ID ?>" class="selectProPriceProduct btn btn-info">เลือก</button></td>
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
                                            <th style="text-align: center;" class="align-middle col-8">สินค้า</th>
                                            <th style="text-align: center;" class="align-middle col-4">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyProPriceProduct">
                                    <?php $rowpp = 1; foreach($propricedetail as $row3) : ?>
                                        <tr id="rowpp<?=$rowpp?>" class="d-flex">
                                            <td style="text-align: center;" class="align-middle col-8 ">
                                                <input type="text" name="promotionPriceProductName" value="<?=$row3->PRODUCT_NAME?>" class="form-control" disabled>
                                                <input type="hidden" name="promotionPriceProductID[]" class="promotionPriceProductID" value="<?=$row3->PRODUCT_ID?>">
                                            </td>
                                            <td style="text-align: center;" class="align-middle col-4">
                                                <button type="button" id="<?=$rowpp?>" class="btn btn-danger btn-removepp"><i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                        <?php $rowpp++; endforeach ; ?>
                                    </tbody>
                                </table>
                                <span id="ProPriceProductError" style="color: red;"> </span>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/promotionprice/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success btn-xs" type="submit" value="แก้ไข">
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <?php endforeach ; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>