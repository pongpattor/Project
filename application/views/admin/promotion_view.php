<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">โปรโมชั่น</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/promotion/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/promotion/addPromotion') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-12">
                        <?php
                        echo '<div class="row">';
                        echo '<div class="col-12">';
                        echo '<div class="row">';
                        echo '<div class="col-8">'; ?>
                        <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                        <?php echo '</div>';
                        echo '<div class="col-4">';
                        echo '<p class="float-right">จำนวน ' . $total . ' รายการ</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        ?>
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสโปรโมชั่น</th>
                                        <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                        <th style="text-align: center;">ส่วนลด %</th>
                                        <th style="text-align: center;">วันที่เริ่ม</th>
                                        <th style="text-align: center;">วันที่สิ้นสุด</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center; ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($promotion as $row) : ?>
                                        <tr id="<?= $row->PROMOTION_ID ?>" class=" bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTION_ID ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTION_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTION_DISCOUNT_PERCENT; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTION_START; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTION_END; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->PROMOTION_STATUS == 0) {
                                                                                                        echo 'รอดำเนินการ';
                                                                                                    } else if ($row->PROMOTION_STATUS == 1) {
                                                                                                        echo 'กำลังใช้งาน';
                                                                                                    } else if ($row->PROMOTION_STATUS == 2) {
                                                                                                        echo 'หมดอายุการใช้งาน';
                                                                                                    } else {
                                                                                                        echo 'เลิกใช้งาน';
                                                                                                    } ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?php echo site_url('admin/promotion/editpromotion')
                                                                    ?>" method="get">
                                                        <button name="promotionID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->PROMOTION_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button class="btn btn-danger  delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php if ($links != null) {
                                echo $links;
                            } else { ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item active"><a class="page-link " >1</a></li>

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
<br>
<script>
    $('.delete').click(function(e) {
        var ID = $(this).parents("tr").attr("id");
        var result = confirm(`ยืนยันการลบโปรโมชั่น รหัส ${ID}`);
        if (result) {
            $.ajax({
                url: "<?= site_url('admin/promotion/deletePromotion') ?>",
                method: "POST",
                data: {
                    promotionID: ID
                },
                success: function() {
                    alert(`ลบตำแหน่ง รหัส ${ID} เสร็จสิ้น`);
                    window.location.href = "<?= site_url('admin/promotion/') ?>";

                }
            });
        }
    });
</script>