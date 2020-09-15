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
                <form action="<?= site_url('admin/employee/employee'); ?>">
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
                                <?php  if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>';?>
                                <?php        echo '</div>';
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
                                        <th style="text-align: center;">อีเมล
                                        </th>
                                        <th style="text-align: center;">เบอร์โทรศัทพ์
                                        </th>
                                        <th style="text-align: center;">แผนก
                                        </th>
                                        <th style="text-align: center;">ตำแหน่ง
                                        </th>
                                        <th style="text-align: center;">เงินเดือน
                                        </th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($employee as $row) : ?>
                                        <tr id="<?= $row->ID ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->ID ?></td>
                                            <td class="align-middle" style="text-align: center;"><img src="<?= base_url('assets/image/employee/' . $row->IMG); ?>" alt="" width="80px" height="80px"></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->FIRSTNAME . ' ' . $row->LASTNAME ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->EMAIL ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PHONE ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->DEPARTMENT_NAME ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->SALARY ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <center>
                                                    <form action="<?= site_url('admin/employee/editEmployee') ?>" method="GET">
                                                        <button name="empID" class="btn btn-warning edit" class="btn btn-warning" value="<?= $row->ID ?>"> <i class="fa fa-edit"></i></button>
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
                            <?= $links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
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
                        location.reload();
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