<h1 class="mt-4">แผนก</h1>
<div class="row ">
    <div class="col d-flex flex-row-reverse">

        <div class="p-2"><a href="<?= site_url('admin/admin/addPosition'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a></div>
    </div>
</div><br>

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
                <td class="align-middle" style="text-align: center;"><?= $row->DEPARTMENT_NAME;?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME;?></td>
                <td>
                    <center>
                        <form action="<?= site_url('admin/admin/editPosition') ?>" method="get">
                            <button name="positionID" class="btn btn-warning col-3 edit" style="text-align: center;" value="<?=$row->POSITION_ID?>"><i class="fa fa-cog"></i></button>
                        </form>
                    </center>
                </td>
                <td>
                    <center>
                        <button class="btn btn-danger col-3 delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                    </center>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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