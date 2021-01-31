<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">โปรโมชั่นส่วนลด</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/promotionprice/') ?>" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col">
                                    <div class="row form-group">
                                        <div class="col">
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
                        <div class="col-2">
                            <a href="<?= site_url('admin/promotionprice/addPromotionPrice') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <!-- <br> -->
                <?php
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
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสโปรโมชั่น</th>
                                        <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                        <th style="text-align: center;">ส่วนลด(%)</th>
                                        <th style="text-align: center;">วันเริ่มต้น</th>
                                        <th style="text-align: center;">วันสิ้นสุด</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($promotionPrice as $row) { ?>
                                        <tr id="<?= $row->PROMOTIONPRICE_ID; ?>" class="bgtable">
                                            <td class="align-middle " style="text-align: center;"><?= $row->PROMOTIONPRICE_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTIONPRICE_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTIONPRICE_DISCOUNT; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTIONPRICE_DATESTART; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTIONPRICE_DATEEND; ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/promotionprice/editPromotionPrice') ?>" method="get">
                                                        <button name="promotionPriceID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->PROMOTIONPRICE_ID; ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button class="btn btn-danger delete" style="text-align: center;" value="<?= $row->PROMOTIONPRICE_ID; ?>"><i class="fa fa-trash"></i></button>
                                                </center>
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

        $('.delete').click(function() {
            var promotionPriceID = $(this).val();
            var result = confirm(`ยืนยันการลบโปรโมชั่นลดราคา รหัส ${promotionPriceID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/promotionprice/deletePromotionPrice') ?>",
                    method: "POST",
                    data: {
                        promotionPriceID: promotionPriceID,
                    },
                    success: function() {
                        alert(`ลบโปรโมชั่นลดราคา รหัส ${promotionPriceID} เสร็จสิ้น`);
                        location.href = "<?= site_url('admin/promotionprice') ?>";
                    }
                });
            }
        });


    });
</script>