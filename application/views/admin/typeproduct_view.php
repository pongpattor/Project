<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">ประเภทสินค้า</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/typeproduct/') ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/typeproduct/addTypeProduct') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <?php
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<div class="row">';
                echo '<div class="col-8">'; ?>
                <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                <?php echo '</div>';
                echo '<div class="col-4">';
                echo '<p class="float-right">จำนวน ' . $total . ' ประเภท</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสประเภทสินค้า</th>
                                        <th style="text-align: center;">หมวดหมู่สินค้า</th>
                                        <th style="text-align: center;">ชื่อประเภทสินค้า</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($typeProduct as $row) { ?>
                                        <tr id="<?= $row->TYPEPRODUCT_ID; ?>" class="bgtable">
                                            <td class="align-middle " style="text-align: center;"><?= $row->TYPEPRODUCT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_GROUP; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/typeproduct/editTypeProduct') ?>" method="get">
                                                        <button name="typeProductId" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->TYPEPRODUCT_ID; ?>"><i class="fa fa-edit"></i></button>
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
                            <?php if ($links != null) {
                                echo $links;
                            } else { ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item active"><a class="page-link " >1</a></li>
                                    </ul>
                                </nav>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.delete').click(function() {
            var id = $(this).parents('tr').attr('id');
            var result = confirm(`ยืนยันการลบ รหัสประเภท ${id}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/typeProduct/deleteTypeProduct') ?>",
                    method: "POST",
                    data: {
                        typeProductId: id,
                    },
                    success: function(data) {
                        alert(`ลบ ${id} เสร็จสิ้น`);
                        window.location.href = "<?= site_url('admin/typeproduct/') ?>";
                    }
                });
            }
        });

        $('.bgtable').mouseover(function() {
            var ID = $(this).attr("ID");
            $('#' + ID).css("background-color", "#C6FFF8");
        });
        $('.bgtable').mouseout(function() {
            var ID = $(this).attr("ID");
            $('#' + ID).css("background-color", "");
        });

    });
</script>