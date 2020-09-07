<div class="row">
    <div class="col-sm col-md">
        <h1>รับวัตถุดิบ</h1>
    </div>
</div>
<div class="row ">
    <div class="col-sm col-md">
        <div class="col d-flex flex-row-reverse">
            <a href="<?= site_url('admin/admin/addReceiveIngredient'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
        </div>
        <br>
        <form action="#" method="GET">
            <div class="input-group mb-3 col-sm-6 col-md-6">
                <input type="text" class="form-control" name="Searchtxt">
                <div class="input-group-append">
                    <button class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
                <tr id="<?= $row->RECEIVE_INGREDIENT_ID ?>">
                    <td class="align-middle" style="text-align: center;"><?= $row->RECEIVE_INGREDIENT_ID; ?></td>
                    <td class="align-middle" style="text-align: center;"><?= $row->DATE_AT . "  " . $row->TIME_AT; ?></td>
                    <td class="align-middle" style="text-align: center;"><?= $row->TOTAL_PRICE; ?></td>
                    <td>
                        <center>
                            <form action="<?= site_url('admin/admin/editReceiveIngredient') ?>" method="get">
                                <button name="ReceiveID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->RECEIVE_INGREDIENT_ID ?>"><i class="fa fa-cog"></i></button>
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
</div>
<script>
    $(document).ready(function() {

        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            console.log(ID);
            var result = confirm(`ยืนยันการลบ LOT ที่ ${ID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deleteReceiveIngredient') ?>",
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

    });
</script>