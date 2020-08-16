<div class="row">
    <div class="col-sm col-md">
        <h1>โต๊ะ</h1>
    </div>
</div>
<div class="row ">
    <div class="col-sm col-md">
        <div class="col d-flex flex-row-reverse">
            <a href="<?= site_url('admin/admin/addTable') ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
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
    <table id="selectedColumn " class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;">เลขโต๊ะ</th>
                <th style="text-align: center;">รูปภาพ</th>
                <th style="text-align: center;">สถานะ</th>
                <th style="text-align: center;">แก้ไข</th>
                <th style="text-align: center;">ลบ</th>
            </tr>
        </thead>
        <tfoot class="thead-dark">
            <th style="text-align: center;">เลขโต๊ะ</th>
            <th style="text-align: center;">รูปภาพ</th>
            <th style="text-align: center;">สถานะ</th>
            <th style="text-align: center;">แก้ไข</th>
            <th style="text-align: center;">ลบ</th>
        </tfoot>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <center>
                        <form action="<?= site_url('admin/admin/editPosition') ?>" method="get">
                            <button name="positionID" class="btn btn-warning  edit" style="text-align: center;"><i class="fa fa-cog"></i></button>
                        </form>
                    </center>
                </td>
                <td>
                    <center>
                        <button class="btn btn-danger delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                    </center>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            var USERNAME = $(this).parents("tr").attr("id");
            alert(USERNAME);
            // var result = confirm(`ยืนยันการลบ ${USERNAME}`);
            // if (result) {
            //     $.ajax({
            //         url: "<?= site_url('admin/admin/deleteCustomer') ?>",
            //         method: "POST",
            //         data: {
            //             empID: ID
            //         },
            //         success: function() {
            //             alert(`ลบ ${USERNAME} เสร็จสิ้น`);
            //             location.reload();
            //         }
            //     });
            // }
        });
    });
</script>