<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">โปรโมชั่น</h3>
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
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/product/addProduct') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-12">
                        <!-- <?php
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
                        ?> -->
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสโปรโมชั่น</th>
                                        <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                        <th style="text-align: center;">วันที่เริ่ม</th>
                                        <th style="text-align: center;">วันที่สิ้นสุด</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center; ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php foreach ($product as $row) : ?>
                                        <tr id="<?= $row->PRODUCT_ID ?>" class=" bgtable" >
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><img src="<?= base_url('assets/image/product/' . $row->PRODUCT_IMG); ?>" alt="" width="120px" height="120px"></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_GROUP; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_COSTPRICE; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_SELLPRICE; ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?= site_url('admin/product/editProduct') ?>" method="get">
                                                        <button name="productID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->PRODUCT_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button class="btn btn-danger  delete" style="text-align: center;"><i class="fa fa-trash"></i></button>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
