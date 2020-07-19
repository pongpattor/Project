<div class="row">
    <div class="col-sm col-md">
        <h1 >ลูกค้า</h1>
    </div>
</div>
<div class="row ">
    <div class="col-sm col-md">
        <div class="col d-flex flex-row-reverse">
            <a href="#" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
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
    <table class="table table-striped table-bordered table-sm" width="100%" cellspacing="0">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;">ชื่อ-สกุล</th>
                <th style="text-align: center;">เพศ</th>
                <th style="text-align: center;">อีเมล</th>
                <th style="text-align: center;">เบอร์โทรศัพท์</th>
                <th style="text-align: center;">วันเกิด</th>
                <th style="text-align: center;">วันเข้าใช้งาน</th>
                <th style="text-align: center;">แก้ไข</th>
                <th style="text-align: center;">ลบ</th>
            </tr>
        </thead>
        <tfoot class="thead-dark">
            <tr>
                <th style="text-align: center;">ชื่อ-สกุล</th>
                <th style="text-align: center;">เพศ</th>
                <th style="text-align: center;">อีเมล</th>
                <th style="text-align: center;">เบอร์โทรศัพท์</th>
                <th style="text-align: center;">วันเกิด</th>
                <th style="text-align: center;">วันเข้าใช้งาน</th>
                <th style="text-align: center;">แก้ไข</th>
                <th style="text-align: center;">ลบ</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($customer as $row) : ?>
                <tr>
                    <td style="text-align: center;"><?= $row->USERNAME . ' ' . $row->LASTNAME; ?></td>
                    <td style="text-align: center;"><?php if ($row->GENDER == 'M') echo 'ชาย';
                                                    elseif ($row->GENDER == 'F') echo 'หญิง'; ?></td>
                    <td style="text-align: center;"><?= $row->EMAIL; ?></td>
                    <td style="text-align: center;"><?= $row->TEL; ?></td>
                    <td style="text-align: center;"><?= $row->BDATE; ?></td>
                    <td style="text-align: center;"><?= $row->CREATE_AT; ?></td>
                    <td>
                        <center>
                            <form action="<?= site_url('admin/admin/editCustomer') ?>" method="GET">
                                <button name="username" class="btn btn-warning   edit" class="btn btn-warning" value="<?= $row->USERNAME ?>"> <i class="fa fa-cog"></i></button>
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
<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            var USERNAME = $(this).parents("tr").attr("id");
            alert(USERNAME);
            var result = confirm(`ยืนยันการลบ ${USERNAME}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deleteCustomer') ?>",
                    method: "POST",
                    data: {
                        empID: ID
                    },
                    success: function() {
                        alert(`ลบ ${USERNAME} เสร็จสิ้น`);
                        location.reload();
                    }
                });
            }
        });
    });
</script>