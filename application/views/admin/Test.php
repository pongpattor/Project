<div class="row">
    <div class="col-sm col-md">
        <h1>แผนก</h1>
    </div>
</div>
<div class="row ">
    <div class="col-sm col-md">
        <div class="col d-flex flex-row-reverse">
            <a href="<?= site_url('admin/admin/addEmployee'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
        </div>
        <br>
        <form action="<?php site_url('admin/admin/employee') ?>" method="GET">
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
                <th style="text-align: center;">รหัสแผนก</th>
                <th style="text-align: center;">ชื่อแผนก</th>
                <th style="text-align: center;  ">แก้ไข</th>
                <th style="text-align: center;">ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($department as $row2) : ?>
                <tr id="<?= $row2->DEPARTMENT_ID ?>" class="<?= $row2->DEPARTMENT_NAME; ?>">
                    <td class="align-middle" style="text-align: center;"><?= $row2->DEPARTMENT_ID; ?></td>
                    <td class="align-middle" style="text-align: center;"><?= $row2->DEPARTMENT_NAME; ?></td>
                    <td>
                        <center>
                            <form action="<?= site_url('admin/admin/editDepartment') ?>" method="get">
                                <button name="departmentID" class="btn btn-warning col-3 edit" style="text-align: center;" value="<?= $row2->DEPARTMENT_ID ?>"><i class="fa fa-cog"></i></button>
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
</div>
<script>
    $(document).ready(function() {


        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            var NAME = $(this).parents("tr").attr("class");
            var result = confirm(`ยืนยันการลบ ${NAME}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deleteDepartment') ?>",
                    method: "POST",
                    data: {
                        deptID: ID
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