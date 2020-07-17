<br>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user mr-1"></i>
        พนักงาน
        <span class="  float-right">
        <a href="<?= site_url('admin/admin/addEmployee'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
        </span>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>TEL</th>
                        <th>EMAIL</th>
                        <th>SALARY</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employee as $row) : ?>
                        <tr id="<?= $row->ID ?>">
                            <td><?= $row->ID; ?></td>
                            <td><?= $row->FIRSTNAME . ' ' . $row->LASTNAME; ?></td>
                            <td><?= $row->TEL; ?></td>
                            <td><?= $row->EMAIL; ?></td>
                            <td><?= $row->SALARY; ?></td>
                            <td>
                                <center>
                                    <form action="<?= site_url('admin/admin/editEmployee') ?>" method="GET">
                                        <button name="empID" class="btn btn-warning  edit" class="btn btn-warning" value="<?= $row->ID ?>"> <i class="fa fa-cog"></i> </button>
                                    </form>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button class="btn btn-danger  delete" style="text-align: center; "> <i class="fa fa-trash"></i></button>
                                </center>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            var result = confirm(`ยืนยันการลบ ${ID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deleteEmployee') ?>",
                    method: "POST",
                    data: {
                        empID: ID
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