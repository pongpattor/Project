<div class="row">
    <div class="col-sm col-md">
        <h1>ตำแหน่ง</h1>
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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning modal_edit"  data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-cog"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-sm col-md col-xl-6">
                                                <label>ชื่อตำแหน่ง</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-sm col-md col-xl-6">
                                                <label>แผนก</label>
                                                <select class="form-control" name="" id="">
                                                    <option value="">กรุณาเลือกแผนก</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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