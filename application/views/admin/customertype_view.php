<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">ประเภทสมาชิก</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/customertype/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/customertype/addCustomerType') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <br>
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
                        echo '<p class="float-right">จำนวน ' . $total . ' ประเภท</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table  table-bordered table-sm" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">รหัสประเภทสมาชิก</th>
                                                <th style="text-align: center;">ชื่อประเภทสมาชิก</th>
                                                <th style="text-align: center;">ส่วนลดสมาชิก(%)</th>
                                                <th style="text-align: center;">ส่วนลดวันเกิด(%)</th>
                                                <th style="text-align: center;  ">แก้ไข</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerType as $row) : ?>
                                                <tr id="<?= $row->CUSTOMERTYPE_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->CUSTOMERTYPE_ID; ?></td>
                                                    <td class="align-middle <?= $row->CUSTOMERTYPE_NAME; ?>" style="text-align: center;"><?= $row->CUSTOMERTYPE_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->CUSTOMERTYPE_DISCOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->CUSTOMERTYPE_DISCOUNTBDATE; ?></td>

                                                    <td>
                                                        <center>                      
                                                            <form action="<?= site_url('admin/customertype/editCustomerType') ?>" method="get">
                                                                <button name="customerTypeID" class="btn btn-warning edit" style="text-align: center;" value="<?= $row->CUSTOMERTYPE_ID ?>"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <button class="btn btn-danger deleteCustomerType" style="text-align: center;" value="<?= $row->CUSTOMERTYPE_ID; ?>"><i class="fa fa-trash"></i></button>
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
    </div>
</div>
