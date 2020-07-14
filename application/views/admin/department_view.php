<h1 class="mt-4">แผนก</h1>
<div class="row ">
    <div class="col d-flex flex-row-reverse">

    <div class="p-2"><a href="<?= site_url('admin/admin/addDepartment'); ?>" class="nav-link btn btn-info">เพิ่มแผนก</a></div>
    </div>
</div><br>

<table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center;">รหัสแผนก
            </th>
            <th style="text-align: center;">ชื่อแผนก
            </th>
            <th style="text-align: center;">หัวหน้าแผนก
            </th>
            <th style="width: 180px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($department as $row2) : ?>
            <tr id="<?= $row2->DEPARTMENT_ID ?>" class="<?= $row2->DEPARTMENT_NAME; ?>">
                <td class="align-middle" style="text-align: center;"><?= $row2->DEPARTMENT_ID; ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row2->DEPARTMENT_NAME; ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row2->FIRSTNAME . ' ' . $row2->LASTNAME; ?></td>
                <td>
                    <center>
                        <form action="<?= site_url('admin/admin/editDepartment')?>" method="get">
                        <button name="departmentID" class="btn btn-warning col-5 edit" style="text-align: center;width: 100px;" value="<?=$row2->DEPARTMENT_ID?>">แก้ไข</button>
                        <button class="btn btn-danger col-5 delete" style="text-align: center;width: 100px;">ลบ</button>
                        </form>
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