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
                        <div class="col-9">
                            <div class="row">
                                <div class="col-3">
                                    <select name="typeProductGroup" id="typeProductGroup" class="form-control" >
                                        <option value="1,2" selected>ทั้งหมด</option>
                                        <option value="1" <?php if ($this->input->get('typeProductGroup') == '1'){echo 'selected';}?>>อาหาร</option>
                                        <option value="2" <?php if ($this->input->get('typeProductGroup') == '2'){echo 'selected';}?>>เครื่องดื่ม</option>
                                    </select>
                                </div>
                                <div class="col-6 input-group">
                                    <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                                    <div class="input-group-append">
                                        <button class="input-group-text"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
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
                <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>';?>
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
                                        <th style="text-align: center;">ชื่อประเภทสินค้า</th>
                                        <th style="text-align: center;">หมวดหมู่สินค้า</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($typeProduct as $row) { ?>
                                        <tr id="<?= $row->TYPEPRODUCT_ID; ?>" class="bgtable">
                                            <td class="align-middle " style="text-align: center;"><?= $row->TYPEPRODUCT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->TYPEPRODUCT_GROUP == '1') {
                                                                                                        echo 'อาหาร';
                                                                                                    } else {
                                                                                                        echo 'เครื่องดื่ม';
                                                                                                    }
                                                                                                    ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/typeproduct/editTypeProduct') ?>" method="get">
                                                        <button name="typeProductID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->TYPEPRODUCT_ID; ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button class="btn btn-danger delete" style="text-align: center;" value="<?= $row->TYPEPRODUCT_ID; ?>"><i class="fa fa-trash"></i></button>
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
                                        <li class="page-item active"><a class="page-link ">1</a></li>
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
            var typeProductID = $(this).val();
            var result = confirm(`ยืนยันการลบ รหัสประเภทสินค้า ${typeProductID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/typeproduct/deleteTypeProduct') ?>",
                    method: "POST",
                    data: {
                        typeProductID: typeProductID,
                    },
                    success: function(data) {
                        alert(`ลบประเภทสินค้า รหัส ${typeProductID} เสร็จสิ้น`);
                        location.href = "<?= site_url('admin/typeproduct')?>";
                    }
                });
            }
        });


    });
</script>