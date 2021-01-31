<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขล็อตเครื่องดื่ม</h3>
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
                    <form method="POST" id="editLotDrinkForm">
                        <?php foreach ($lotdrink as $row) : ?>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lotDrinklModal">
                                        เลือกเครื่องดื่ม
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="lotDrinklModal" tabindex="-1" role="dialog" aria-labelledby="lotDrinklModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-lg" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="lotDrinklModalLabel">เครื่องดื่ม</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body ">
                                                    <div class="table-responsive">
                                                        <table id="lotDrinkTable" class="display table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>รหัส</th>
                                                                    <th>ชื่อ</th>
                                                                    <th>เลือก</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $rowDrink = 1;
                                                                        foreach ($drink as $row2) : ?>
                                                                <tr id="row<?= $rowDrink ?>">
                                                                    <td><?= $row2->PRODUCT_ID; ?></td>
                                                                    <td><?= $row2->PRODUCT_NAME; ?></td>
                                                                    <td><button type="button" value="<?= $row2->PRODUCT_ID ?>" class="selectLotDrink btn btn-info">เลือก</button></td>
                                                                </tr>
                                                            <?php $rowDrink++;
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
                                        <tbody id="bodyLotDrink">
                                            <?php $rowLotDrink = 1;
                                            foreach ($lotdetail as $row3) : ?>
                                                <tr id="rowd<?=$rowLotDrink?>" class="d-flex">
                                                    <td style="text-align: center;" class="align-middle col-5 ">
                                                        <input type="text" name="lotDrinkName" value="<?=$row3->PRODUCT_NAME?>" class="form-control" disabled>
                                                        <input type="hidden" name="lotDrinkID[]" class="lotDrinkID" value="<?=$row3->PRODUCT_ID?>">
                                                    </td>
                                                    <td style="text-align: center;" class="align-middle col-5">
                                                        <input type="number" name="lotDrinkPrice[]" value="<?=$row3->LOTDETAIL_PRICE;?>" min="0" max="999999.99" step="0.01" class="form-control lotDrinkPrice" required>
                                                    </td>
                                                    <td style="text-align: center;" class="align-middle col-2">
                                                        <button type="button" id="<?=$rowLotDrink?>" class="btn btn-danger btn-removed"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            <?php $rowLotDrink++;
                                            endforeach; ?>
                                        </tbody>
                                    </table>
                                    <span id="lotDrinkError" style="color: red;"> </span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-7 ">
                                    <label for="lotTotalShow">ราคารวม</label>
                                    <input type="text" name="lotTotalShow" id="lotTotalShow" value="<?=$row->LOT_TOTAL;?>" class="form-control" disabled>
                                    <input type="hidden" name="lotTotal" id="lotTotal" value="<?=$row->LOT_TOTAL;?>" class="form-control" >
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/lotdrink/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
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