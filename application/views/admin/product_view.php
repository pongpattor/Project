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
                <form action="#">
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
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสสินค้า</th>
                                        <th style="text-align: center;">รูปภาพ</th>
                                        <th style="text-align: center;">ชื่อสินค้า</th>
                                        <th style="text-align: center;">ราคาขาย</th>
                                        <th style="text-align: center;">ชื่อสินค้า</th>
                                        <th style="text-align: center;">ราคาทุน</th>
                                        <th style="text-align: center;  ">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php foreach ($dept_pos as $row) : ?>
                                        <tr id="<?= $row->POSITION_ID ?>" class="<?= $row->POSITION_NAME ?>">
                                            <td class="align-middle" style="text-align: center;"><?= $row->DEPARTMENT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME; ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/admin/editPosition') ?>" method="get">
                                                        <button name="positionID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->POSITION_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td>
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
<script>