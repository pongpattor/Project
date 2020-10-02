<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">รับวัตถุดิบ</h3>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/receiveIngredient/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/receiveIngredient/addReceiveIngredient') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <?php
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<div class="row">';
                echo '<div class="col-8">'; ?>
                <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                <?php echo '</div>';
                echo '<div class="col-4">';
                echo '<p class="float-right">จำนวน ' . $total . ' ตำแหน่ง</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">Lot</th>
                                        <th style="text-align: center;">วันเวลาที่เข้า</th>
                                        <th style="text-align: center;">ราคารวม</th>
                                        <th style="text-align: center;  ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($receive_ingredient as $row) : ?>
                                        <tr id="<?= $row->RECEIVE_INGREDIENT_ID ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->RECEIVE_INGREDIENT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->DATE_AT . "  " . $row->TIME_AT; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->TOTAL_PRICE  ,2); ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/receiveIngredient/editReceiveIngredient') ?>" method="get">
                                                        <button name="ReceiveID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->RECEIVE_INGREDIENT_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button class="btn btn-danger  delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= $links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            console.log(ID);
            var result = confirm(`ยืนยันการลบ LOT ที่ ${ID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/receiveIngredient/deleteReceiveIngredient') ?>",
                    method: "POST",
                    data: {
                        ReceiveID: ID
                    },
                    success: function() {
                        alert(`ลบ ${ID} เสร็จสิ้น`);
                        location.reload();
                    }
                });
            }

        });

        $('.bgtable').mouseover(function() {
            var ID = $(this).attr("ID");
            $('#' + ID).css("background-color", "#C6FFF8");
        });
        $('.bgtable').mouseout(function() {
            var ID = $(this).attr("ID");
            $('#' + ID).css("background-color", "");
        });
    });
</script>