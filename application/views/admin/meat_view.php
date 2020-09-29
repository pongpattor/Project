<br>

<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">เนื้อสัตว์</h3>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/meat/') ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/meat/addMeat') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
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
                echo '<p class="float-right">จำนวน ' . $total . ' ชนิด</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn" class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">รหัสเนื้อสัตว์</th>
                                        <th style="text-align: center;">ชื่อเนื้อสัตว์</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">แก้ไข</th>
                                        <th style="text-align: center;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($meat as $row) : ?>
                                        <tr id="<?= $row->MEAT_ID ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->MEAT_ID; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->MEAT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?php if ($row->MEAT_STATUS == '1') {
                                                                                                        echo 'มี';
                                                                                                    } else {
                                                                                                        echo 'หมด';
                                                                                                    } ?></td>
                                            <td>
                                                <center>
                                                    <form action="<?= site_url('admin/meat/editmeat') ?>" method="get">
                                                        <button name="meatID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->MEAT_ID ?>"><i class="fa fa-edit"></i></button>
                                                    </form>
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
                            <?= $links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<br>
<script>
    $(document).ready(function() {

        $('.delete').click(function() {
            var id = $(this).parents('tr').attr('id');
            var result = confirm(`ยืนยันการลบ รหัสเนื้อสัตว์ ${id}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/meat/deleteMeat') ?>",
                    method: "POST",
                    data: {
                        meatId: id,
                    },
                    success: function(data) {
                        alert(`ลบ ${id} เสร็จสิ้น`);
                        window.location.href = "<?= site_url('admin/meat/') ?>";
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