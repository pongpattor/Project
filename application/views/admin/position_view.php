<div class="row">
    <div class="col-sm col-md">
        <h1 >ตำแหน่ง</h1>
    </div>
</div>
<div class="row ">
    <div class="col-sm col-md">
        <div class="col d-flex flex-row-reverse">
            <a href="<?= site_url('admin/admin/addPosition'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
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
            <th style="text-align: center;">แผนก</th>
            <th style="text-align: center;">ตำแหน่ง</th>
            <th style="text-align: center;  ">แก้ไข</th>
            <th style="text-align: center;">ลบ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dept_pos as $row) : ?>
            <tr id="<?= $row->POSITION_ID ?>" class="<?= $row->POSITION_NAME ?>">
                <td class="align-middle" style="text-align: center;"><?= $row->DEPARTMENT_NAME; ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME; ?></td>
                <td>
                    <center>
                        <form action="<?= site_url('admin/admin/editPosition') ?>" method="get">
                            <button name="positionID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->POSITION_ID ?>"><i class="fa fa-edit"></i></button>
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
            var NAME = $(this).parents("tr").attr("class");
            var result = confirm(`ยืนยันการลบ ${NAME}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deletePosition') ?>",
                    method: "POST",
                    data: {
                        posID: ID
                    },
                    success: function() {
                        alert(`ลบ ${NAME} เสร็จสิ้น`);
                        location.reload();

                    }
                });
            }
        });
        
    });
</script>