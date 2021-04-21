<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">วัตถุดิบ</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/ingredient/') ?>" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-3 form-group row">
                                    <div class="col-3"> <label for="ingredientActive" class="col-form-label">สถานะ</label></div>
                                    <div class="col">
                                        <select name="ingredientActive" id="ingredientActive" class="form-control">
                                            <option value="1,2" selected>ทั้งหมด</option>
                                            <option value="1" <?php if ($this->input->get('ingredientActive') == '1') {
                                                                    echo 'selected';
                                                                } ?>>มี</option>
                                            <option value="2" <?php if ($this->input->get('ingredientActive') == '2') {
                                                                    echo 'selected';
                                                                } ?>>หมด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row form-group">
                                        <div class="col">
                                            <div class="col-7 input-group">
                                                <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                                                <div class="input-group-append">
                                                    <button class="input-group-text"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <a href="<?= site_url('admin/ingredient/addIngredient') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <!-- <br> -->
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
                                        <th style="text-align: center;">รหัสวัตถุดิบ</th>
                                        <th style="text-align: center;">ชื่อวัตถุดิบ</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ingredient as $row) { ?>
                                        <tr id="<?= $row->INGREDIENT_ID; ?>" class="bgtable">
                                            <td class="align-middle " style="text-align: center;"><?= $row->INGREDIENT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->INGREDIENT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->INGREDIENT_ACTIVE == '1') {
                                                                                                        echo 'มี';
                                                                                                    } else {
                                                                                                        echo 'หมด';
                                                                                                    }
                                                                                                    ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/ingredient/editIngredient') ?>" method="get">
                                                        <button name="ingredientID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->INGREDIENT_ID; ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button class="btn btn-danger delete" style="text-align: center;" value="<?= $row->INGREDIENT_ID; ?>"><i class="fa fa-trash"></i></button>
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
            var ingredientID = $(this).val();
            var result = confirm(`ยืนยันการลบวัตถุดิบ รหัส ${ingredientID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/ingredient/deleteIngredient') ?>",
                    method: "POST",
                    data: {
                        ingredientID: ingredientID,
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == true) {
                            alert(`ลบวัตถุดิบ รหัส ${ingredientID} เสร็จสิ้น`);
                            location.href = "<?= site_url('admin/ingredient') ?>";
                        } else {
                            alert(`วัตถุดิบนี้อยู่ในสูตรการผลิตอาหาร\nไม่สามารถลบวัตถุดิบ รหัส ${ingredientID} นี้ได้`);

                        }

                    }
                });
            }
        });
    });
</script>