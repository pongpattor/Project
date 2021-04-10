<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">ครัวอาหาร </h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header">
                <h4>รายการอาหาร</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="FoodTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">#</th>
                                        <th style="text-align: center;">รายการ</th>
                                        <th style="text-align: center;">จำนวน</th>
                                        <th style="text-align: center;">หมายเหตุ</th>
                                        <th style="text-align: center;">ประเภท</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">ปรุง</th>
                                        <th style="text-align: center;">เสิร์ฟ</th>
                                        <th style="text-align: center;">ยกเลิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($food as $row) : ?>
                                        <tr id="rowFood<?= $i ?>">
                                            <td class="align-middle" style="text-align: center;"><?= $i ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME ?> <input type="hidden" class="serviceID" value="<?= $row->DTSER_ID ?>">
                                                <input type="hidden" class="serviceNo" value="<?= $row->DTSER_NO ?>">
                                            </td>
                                            <?php $amount = 0;
                                            if ($row->DPRODTSER_AMOUNT == null) {
                                                $amount = $row->DTSER_AMOUNT;
                                            } else {
                                                $amount = $row->DPRODTSER_AMOUNT;
                                            }
                                            ?>
                                            <td class="align-middle" style="text-align: center;"><?= $amount ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->DTSER_NOTE ?></td>
                                            <?php $typeUse = '';
                                            if ($row->DTSER_TYPEUSE == 1) {
                                                $typeUse = 'ทานนี่';
                                            } else {
                                                $typeUse = 'กลับบ้าน';
                                            } ?>
                                            <td class="align-middle" style="text-align: center;"><?= $typeUse ?></td>
                                            <?php $status = '';
                                            if ($row->DPRODTSER_STATUS == 1) {
                                                $status = 'กำลังทำ';
                                            } else {
                                                if ($row->DTSER_STATUS == 0) {
                                                    $status = 'ยังไม่ทำ';
                                                } else {
                                                    $status = 'กำลังทำ';
                                                }
                                            }
                                            ?>
                                            <td class="align-middle" style="text-align: center;"><?= $status ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row->DPRODTSER_STATUS == 0) {
                                                    if ($row->DTSER_STATUS == 0) {
                                                        echo "<button class=\"btn btn-info \">ปรุง</button>";
                                                    }
                                                }

                                                ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row->DPRODTSER_STATUS == 1) {
                                                    echo "<button class=\"btn btn-success \">เสิร์ฟ</button>";
                                                } else  if ($row->DTSER_STATUS == 1) {
                                                    echo "<button class=\"btn btn-success \">เสิร์ฟ</button>";
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row->DPRODTSER_STATUS == 0) {
                                                    if ($row->DTSER_STATUS == 0) {
                                                        echo "<button class=\"btn btn-danger\">ยกเลิก</button>";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header">
                <h4>รายการอาหารซ้ำ</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="foodSameTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">#</th>
                                        <th style="text-align: center;">รายการ</th>
                                        <th style="text-align: center;">จำนวน</th>
                                        <th style="text-align: center;">หมายเหตุ</th>
                                        <th style="text-align: center;">ประเภท</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">ปรุง</th>
                                        <th style="text-align: center;">เสิร์ฟ</th>
                                        <th style="text-align: center;">ยกเลิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j = 1;
                                    foreach ($foodsame as $row2) : ?>
                                        <tr id="rowsame<?= $j ?>">
                                            <td class="align-middle" style="text-align: center;"><?= $j ?></td>
                                            <?php $textId = "";
                                            $textNo = "";
                                            $textDate = "";
                                            $textTime = "";
                                            for ($k = 0; $k < count($foodsameIdNo); $k++) {
                                                if (
                                                    $row2->PRODUCT_ID == $foodsameIdNo[$k]->PRODUCT_ID &&
                                                    $row2->DTSER_NOTE  == $foodsameIdNo[$k]->DTSER_NOTE &&
                                                    $row2->DTSER_TYPEUSE == $foodsameIdNo[$k]->DTSER_TYPEUSE &&
                                                    $row2->DTSER_STATUS == $foodsameIdNo[$k]->DTSER_STATUS
                                                ) {
                                                    $textId .= $foodsameIdNo[$k]->DTSER_ID;
                                                    $textNo .= $foodsameIdNo[$k]->DTSER_NO;
                                                    $textDate .= $foodsameIdNo[$k]->DTSER_DATE;
                                                    $textTime .= $foodsameIdNo[$k]->DTSER_TIME;

                                                    if ($k < count($foodsameIdNo)) {
                                                        $textId .= ',';
                                                        $textNo .= ',';
                                                        $textDate .= ',';
                                                        $textTime .= ',';
                                                    }
                                                }
                                            }
                                            ?>
                                            <td class="align-middle" style="text-align: center;"><?= $row2->PRODUCT_NAME ?>
                                                <input type="hidden" name="sameServiceID" class="sameServiceID" value="<?= $textId ?>">
                                                <input type="hidden" name="sameServiceNo" class="sameServiceNo" value="<?= $textNo ?>">
                                                <input type="hidden" name="sameProductID" class="sameProductID" value="<?= $row2->PRODUCT_ID ?>">
                                                <input type="hidden" name="sameServiceDate" class="sameServiceDate" value="<?= $textDate ?>">
                                                <input type="hidden" name="sameServiceTime" class="sameServiceTime" value="<?= $textTime ?>">
                                            </td>

                                            <td class="align-middle" style="text-align: center;"><?= $row2->sumAmount ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row2->DTSER_NOTE ?></td>
                                            <?php $typeUse = '';
                                            if ($row2->DTSER_TYPEUSE == 1) {
                                                $typeUse = 'ทานนี่';
                                            } else {
                                                $typeUse = 'กลับบ้าน';
                                            } ?>
                                            <td class="align-middle" style="text-align: center;"><?= $typeUse ?></td>
                                            <?php $status = '';
                                            if ($row2->DPRODTSER_STATUS == 1) {
                                                $status = 'กำลังทำ';
                                            } else {
                                                if ($row2->DTSER_STATUS == 0) {
                                                    $status = 'ยังไม่ทำ';
                                                } else {
                                                    $status = 'กำลังทำ';
                                                }
                                            }
                                            ?>
                                            <td class="align-middle" style="text-align: center;"><?= $status ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row2->DPRODTSER_STATUS == 0) {
                                                    if ($row2->DTSER_STATUS == 0) {
                                                        echo "<button class=\"btn btn-info sameCook\">ปรุง</button>";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row2->DPRODTSER_STATUS == 1) {
                                                    echo "<button class=\"btn btn-success sameServe\">เสิร์ฟ</button>";
                                                } else  if ($row2->DTSER_STATUS == 1) {
                                                    echo "<button class=\"btn btn-success sameServe\">เสิร์ฟ</button>";
                                                }                                              
                                                ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php
                                                if ($row2->DPRODTSER_STATUS == 0) {
                                                    if ($row2->DTSER_STATUS == 0) {
                                                        echo "<button class=\"btn btn-danger \">ยกเลิก</button>";
                                                    }
                                                }

                                                ?>
                                            </td>
                                        </tr>
                                    <?php $j++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#FoodTable').dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "language": {
                "emptyTable": "ไม่มีข้อมูล",
                "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
            }
        });

        $('#foodSameTable').dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "language": {
                "emptyTable": "ไม่มีข้อมูล",
                "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
            }
        });


        $(document).on('click', '.sameCook', function() {
            var rowid = $(this).parents('tr').attr('id');
            var serviceID = $(`#${rowid} .sameServiceID`).val();
            var serviceNO = $(`#${rowid} .sameServiceNo`).val();
            var productID = $(`#${rowid} .sameProductID`).val();
            var serviceDate = $(`#${rowid} .sameServiceDate`).val();
            var serviceTime = $(`#${rowid} .sameServiceTime`).val();

            $.ajax({
                url: "<?= site_url('admin/kitchen/cookSameService') ?>",
                method: "POST",
                data: {
                    serviceID: serviceID,
                    serviceNO: serviceNO,
                    productID: productID,
                    serviceDate: serviceDate,
                    serviceTime: serviceTime,
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>