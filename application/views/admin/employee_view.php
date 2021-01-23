<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">พนักงาน </h3>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/employee/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/employee/addEmployee') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
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
                        echo '<p class="float-right">จำนวนพนักงาน ' . $total . ' คน</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        ?>
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark ">
                                    <tr>
                                        <th style="text-align: center;">รหัสประจำตัวพนักงาน
                                        </th>
                                        <th style="text-align: center;">รูป</th>
                                        <th style="text-align: center;">ชื่อ-สกุล
                                        </th>
                                        <th style="text-align: center;">เบอร์โทรศัทพ์
                                        </th>
                                        <th style="text-align: center;">แผนก
                                        </th>
                                        <th style="text-align: center;">ตำแหน่ง
                                        </th>
                                        <th style="text-align: center;">ลืมรหัส</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($employee as $row) : ?>
                                        <tr id="<?= $row->EMPLOYEE_ID ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->EMPLOYEE_ID ?></td>
                                            <td class="align-middle" style="text-align: center;"><img src="" alt="" width="80px" height="80px"></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->EMPLOYEE_FIRSTNAME . ' ' . $row->EMPLOYEE_LASTNAME ?></td>
                                            <td class="align-middle" style="text-align: center;"> <?php foreach ($employeeTel as $row2) {
                                                            if ($row2->EMPLOYEETEL_ID == $row->EMPLOYEE_ID) {
                                                                echo $row2->EMPLOYEETEL_TEL . '<br>';
                                                            }
                                                        } ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->DEPARTMENT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button name="resetPass" class="btn btn-primary resetPass" value="<?= $row->EMPLOYEE_ID ?>"> <i class="fa fa-key"></i></button>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?= site_url('admin/employee/editEmployee') ?>" method="GET">
                                                        <button name="employeeID" class="btn btn-warning edit" class="btn btn-warning" value="<?= $row->EMPLOYEE_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                </center>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <button class="btn btn-danger  delete" style="text-align: center; "> <i class="fa fa-trash"></i></button>
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
                                        <li class="page-item active"><a class="page-link">1</a></li>

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

        $('.resetPass').on('click', function() {
            var empID = $(this).parents("tr").attr("id");
            var result = confirm('ยืนยันการรีเซ็ทรหัสผ่านของ ' + empID);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/employee/resetPassword'); ?>",
                    method: "POST",
                    data: {
                        empID: empID
                    },
                    success: function(data) {
                        alert(`กรุณาจดรหัสผ่านใหม่ของ ${empID} \nรหัสผ่านใหม่คือ ${data}`);

                    }
                });
            }
        });

        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            var result = confirm(`ยืนยันการลบ ${ID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/employee/deleteEmployee') ?>",
                    method: "POST",
                    data: {
                        empID: ID
                    },
                    success: function() {
                        alert(`ลบ ${ID} เสร็จสิ้น`);
                        window.location.href = "<?= site_url('admin/employee/') ?>";
                    }
                });
            }
        });
    });
</script>