<br>
<div class="row">
    <div class="col-12">
        <div class="card  boder-0 shadow-lg">
            <div class="card-header bg-light text-center">
                <h3 class="d-inline">ประวัติการขาย</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/payment/historyPayment') ?>" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col">
                                    <div class="row form-group">
                                        <div class="col-7 input-group">
                                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                                            <div class="input-group-append">
                                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- <?php
                        echo '<div class="row">';
                        echo '<div class="col-12">';
                        echo '<div class="row">';
                        echo '<div class="col-8">'; ?>
                <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                <?php echo '</div>';
                echo '<div class="col-4">';
                echo '<p class="float-right">จำนวน ' . $total . ' ประเภท</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                ?> -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัส</th>
                                        <th style="text-align: center;">วัน/เดือน/ปี เวลา</th>
                                        <th style="text-align: center;">ราคาทั้งหมด</th>
                                        <th style="text-align: center;">พิมพ์</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historyPayment as $row) { ?>
                                        <tr id="<?= $row->RECEIPT_ID; ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->RECEIPT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->RECEIPT_DATE . ' ' . $row->RECEIPT_TIMES; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->RECEIPT_PRICETOTAL; ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <a href="<?= site_url('admin/payment/bill?receiptID=' . $row->RECEIPT_ID) ?>" target="_blank" class="btn btn-success  bill" style="text-align: center;"><i class="fa fa-print"></i></a>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <button class="btn btn-danger delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if ($links != null) {
                                echo $links;
                            } else { ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item active"><a class="page-link ">1</a></li>
                                    </ul>
                                </nav>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete', function() {
            var receiptID = $(this).parents('tr').attr('id');
            var result = confirm(`ยืนยันการลบประวัติการขาย รหัส ${receiptID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/payment/deleteReceipt') ?>",
                    method: "POST",
                    data: {
                        receiptID: receiptID,
                    },
                    success: function() {
                        alert(`ลบประวัติการขาย รหัส ${receiptID} เสร็จสิ้น`);
                        location.replace('<?= site_url('admin/payment/historyPayment') ?>');
                    }

                });
            }
        });
    });
</script>