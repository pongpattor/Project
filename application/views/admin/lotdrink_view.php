<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">ล็อตเครื่องดื่ม</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/lotdrink/'); ?>" method="GET">
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
                            <a href="<?= site_url('admin/lotdrink/addLotDrink') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
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
                                        <th style="text-align: center;">รหัสล็อต</th>
                                        <th style="text-align: center;">วัน/เดือน/ปี เวลา</th>
                                        <th style="text-align: center;">ราคารวม</th>
                                        <th style="text-align: center; ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lotdrink as $row) : ?>
                                        <tr id="<?= $row->LOT_ID ?>" class=" bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->LOT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->LOT_DATE.' '.$row->LOT_TIME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->LOT_TOTAL, 2); ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?= site_url('admin/lotdrink/editLotDrink') ?>" method="get">
                                                        <button name="lotDrinkID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->LOT_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button class="btn btn-danger delete" value="<?= $row->LOT_ID; ?>" style="text-align: center;"><i class="fa fa-trash"></i></button>
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
<br>
<!-- <script>
    $(document).ready(function() {

        $('.delete').click(function() {
            var productID = $(this).val();
            var result = confirm(`ยืนยันการลบ รหัสสินค้า ${productID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/product/deleteProduct') ?>",
                    method: "POST",
                    data: {
                        productID: productID,
                    },
                    success: function(data) {
                        alert(`ลบ ${productID} เสร็จสิ้น`);
                       location.href = "<?= site_url('admin/product/') ?>";
                    }
                });
            }
        });
    });
</script> -->