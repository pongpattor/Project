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
                                                <th style="text-align: center;">หมายเหตุ</th>
                                                <th style="text-align: center;">สถานะ</th>
                                                <th style="text-align: center;">ยกเลิก</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($serviceDetail as $row) : ?>
                                                <?php if ($row->PRODUCT_ID == null) {
                                                    $orderId = $row->PROMOTIONSET_ID;
                                                } else {
                                                    $orderId = $row->PRODUCT_ID;
                                                } ?>
                                                <tr id="rowOrder<?= $i ?>">
                                                    <td class="align-middle" style="text-align: center;">
                                                        <span class="noShow"><?= $i; ?></span>
                                                        <input type="hidden" name="no" class="no" value="<?= $row->DTSER_NO ?>">
                                                    </td>
                                                    <?php if ($row->PRODUCT_ID == null) {
                                                        $orderName = $row->PROMOTIONSET_NAME;
                                                    } else {
                                                        $orderName = $row->PRODUCT_NAME;
                                                    } ?>
                                                    <td class="align-middle" style="text-align: center;"><?= $orderName ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->DTSER_AMOUNT ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->DTSER_NOTE ?></td>
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
                                                    <td class="align-middle" style="text-align: center;">
                                                        <button type="button" class="btn btn-danger deleteOrder" value="<?= $orderId ?>" <?php if ($row->DTSER_STATUS != 0) {
                                                                                                                                                echo 'disabled';
                                                                                                                                            } ?>>
                                                            <i class="fa fa-trash"></i>
                                                        </button>
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#orderDetailTable').dataTable({
            "lengthMenu": [
                [8, 15, 25, -1],
                [8, 15, 25, "All"]
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

        $(document).on('click', '.deleteOrder', function() {
            var rowid = $(this).parents('tr').attr('id');
            var serviceID = $('#serviceID').html();
            var no = $(`#${rowid} .no`).val();
            $.ajax({
                url: "<?= site_url('admin/service/checkOrderForDelete') ?>",
                method: "POST",
                data: {
                    serviceID: serviceID,
                    serviceNO: no
                },
                dataType: "JSON",
                success: function(data) {
                    if(data.status == true){
                        alert('ยกเลิกรายการเสร็จสิ้น');
                        location.reload();
                    }
                    else{
                        alert('ไม่สามารถยกเลิกรายได้');
                        location.reload();
                    }
                }
            })
        });
    });
</script>