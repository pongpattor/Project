<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">โต๊ะ</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="#">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/admin/addDesk') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสโต๊ะ</th>
                                        <th style="text-align: center;">เลขโต๊ะ</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($desk as $row) { ?>
                                        <tr id="<?= $row->DESK_ID; ?>">
                                            <td class="align-middle" style="text-align: center;"><?= $row->DESK_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->DESK_NUMBER; ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php if ($row->DESK_STATUS == 0) {
                                                    echo 'ว่าง';
                                                } else if ($row->DESK_STATUS == 1) {
                                                    echo 'ไม่ว่าง';
                                                } else if ($row->DESK_STATUS == 2) {
                                                    echo 'ปรับปรุง';
                                                }
                                                ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/admin/editDesk') ?>" method="get">
                                                        <button name="deskID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->DESK_ID; ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button class="btn btn-danger delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
            var result = confirm(`ยืนยันการลบโต๊ะหมายเลข ${ID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/admin/deleteDesk') ?>",
                    method: "POST",
                    data: {
                        deskID: ID
                    },
                    success: function() {
                        alert(`ลบโต๊ะหมายเลข ${ID} เสร็จสิ้น`);
                        location.reload();

                    }
                });
            }
        });


    });
</script>