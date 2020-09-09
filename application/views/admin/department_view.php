<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">แผนก</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/admin/department');?>">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/admin/addDepartment') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm" width="100%" cellspacing="0">
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
                                                        <button name="departmentID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row2->DEPARTMENT_ID ?>"><i class="fa fa-edit"></i></button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
ฺ

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