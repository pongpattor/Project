<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">สินค้า</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/product/'); ?>" method="GET">
                    <div class="row">
                    <div class="col-10">
                            <div class="row">
                                <div class="col-3 form-group row">
                                    <div class="col-3"> <label for="productActive" class="col-form-label">สถานะ</label></div>
                                    <div class="col">
                                        <select name="productActive" id="productActive" class="form-control">
                                            <option value="1,2" selected>ทั้งหมด</option>
                                            <option value="1" <?php if ($this->input->get('productActive') == '1') {
                                                                    echo 'selected';
                                                                } ?>>พร้อมใช้งาน</option>
                                            <option value="2" <?php if ($this->input->get('productActive') == '2') {
                                                                    echo 'selected';
                                                                } ?>>ไม่พร้อมใช้งาน</option>
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
                            <a href="<?= site_url('admin/product/addProduct') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <?php
                        echo '<div class="row">';
                        echo '<div class="col-12">';
                        echo '<div class="row">';
                        echo '<div class="col-8">'; ?>
                        <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                        <?php echo '</div>';
                        echo '<div class="col-4">';
                        echo '<p class="float-right">จำนวน ' . $total . ' รายการ</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        ?>
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสสินค้า</th>
                                        <th style="text-align: center;">รูปภาพ</th>
                                        <th style="text-align: center;">ชื่อสินค้า</th>
                                        <th style="text-align: center;">ประเภทสินค้า</th>
                                        <th style="text-align: center;">หมวดหมู่สินค้า</th>
                                        <th style="text-align: center;">ราคาทุน</th>
                                        <th style="text-align: center;">ราคาขาย</th>
                                        <th style="text-align: center;">สถานะการใช้งาน</th>
                                        <th style="text-align: center; ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($product as $row) : ?>
                                        <tr id="<?= $row->PRODUCT_ID ?>" class=" bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><img src="<?= base_url('assets/image/product/' . $row->PRODUCT_IMAGE); ?>" alt="" width="120px" height="120px"></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->TYPEPRODUCT_GROUP == '1') {
                                                                                                        echo 'อาหาร';
                                                                                                    } else if($row->TYPEPRODUCT_GROUP == '2'){
                                                                                                        echo 'เครื่องดื่ม';
                                                                                                    }
                                                                                                    ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->PRODUCT_COSTPRICE, 2); ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->PRODUCT_SELLPRICE, 2); ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->PRODUCT_ACTIVE == '1') {
                                                                                                        echo 'พร้อมใช้งาน';
                                                                                                    } else {
                                                                                                        echo 'ไม่พร้อมใช้งาน';
                                                                                                    }
                                                                                                    ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?= site_url('admin/product/editProduct') ?>" method="get">
                                                        <button name="productID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->PRODUCT_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button class="btn btn-danger delete" value="<?= $row->PRODUCT_ID ?>" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
<br>
<script>
    $(document).ready(function() {

        $('.delete').click(function() {
            var productID = $(this).val();
            var result = confirm(`ยืนยันการลบ รหัสสินค้า ${productID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/product/deleteProduct') ?>",
                    method: "POST",
                    data: {
                        productID: productID,
                    },
                    success: function(data) {
                        alert(`ลบ ${productID} เสร็จสิ้น`);
                       location.href = "<?= site_url('admin/product/') ?>";
                    }
                });
            }
        });
    });
</script>