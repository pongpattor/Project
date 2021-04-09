<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายการที่สั่ง </h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5>รหัสเซอร์วิส <span id="serviceID"><?php $serviceID =  $this->input->get('detailServiceID');
                                                                echo $serviceID; ?></span></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="orderDetailTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">รายการ</th>
                                                <th style="text-align: center;">จำนวน</th>
                                                <th style="text-align: center;">สถานะ</th>
                                                <th style="text-align: center;">แก้ไข</th>
                                                <th style="text-align: center;">ยกเลิก</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($serviceDetail as $row) : ?>
                                                <tr id="
                                                 <?php if ($row->PRODUCT_ID == null) {
                                                        echo $row->PROMOTIONSET_ID;
                                                    } else {
                                                        echo $row->PRODUCT_ID;
                                                    } ?>">
                                                    <td class="align-middle" style="text-align: center;"><?= $i; ?></td>
                                                    <td class="align-middle" style="text-align: center;">
                                                        <?php if ($row->PRODUCT_ID == null) {
                                                            echo $row->PROMOTIONSET_NAME;
                                                        } else {
                                                            echo $row->PRODUCT_NAME;
                                                        } ?>
                                                    </td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->sumAmount ?></td>
                                                    <td class="align-middle" style="text-align: center;">
                                                        <?php
                                                        if ($row->DTSER_STATUS == '0') {
                                                            echo 'ยังไม่ทำ';
                                                        } else if ($row->DTSER_STATUS == '1') {
                                                            echo 'กำลังทำ';
                                                        } else if ($row->DTSER_STATUS == '2') {
                                                            echo 'รอเสิร์ฟ';
                                                        } else if ($row->DTSER_STATUS == '3') {
                                                            echo 'เสิร์ฟแล้ว';
                                                        } else if ($row->DTSER_STATUS == '4') {
                                                            echo 'จ่ายแล้ว';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="align-middle" style="text-align: center;"><button type="button" class="btn btn-warning editOrder" value="<?php if ($row->PRODUCT_ID == null) {
                                                                                                                                                                            echo $row->PROMOTIONSET_ID;
                                                                                                                                                                        } else {
                                                                                                                                                                            echo $row->PRODUCT_ID;
                                                                                                                                                                        } ?>"><i class="fa fa-edit"></i></button></td>
                                                    <td class="align-middle" style="text-align: center;"><button type="button" class="btn btn-danger deleteOrder" value="<?php if ($row->PRODUCT_ID == null) {
                                                                                                                                                                                echo $row->PROMOTIONSET_ID;
                                                                                                                                                                            } else {
                                                                                                                                                                                echo $row->PRODUCT_ID;
                                                                                                                                                                            } ?>"><i class="fa fa-trash"></i></button></td>

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
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#orderDetailTable').dataTable({
            "lengthMenu": [
                [10, 15, 25, -1],
                [10, 15, 25, "All"]
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

    });
</script>