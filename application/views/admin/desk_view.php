<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">โต๊ะ</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/desk/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-6 input-group">
                            <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="<?= site_url('admin/desk/addDesk') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
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
                        echo '<p class="float-right">จำนวน ' . $total . ' โต๊ะ</p>';
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
                                                <th style="text-align: center;">รหัสโต๊ะ</th>
                                                <th style="text-align: center;">ชื่อโต๊ะ</th>
                                                <th style="text-align: center;">จำนวนที่นั่ง</th>
                                                <th style="text-align: center;">โซนที่นั่ง</th>
                                                <th style="text-align: center;">แก้ไข</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($desk as $row) : ?>
                                                <tr id="<?= $row->SEAT_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_ID; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_AMOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->ZONE_NAME; ?></td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <form action="<?= site_url('admin/desk/editDesk') ?>" method="get">
                                                                <button name="deskID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->SEAT_ID ?>"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <button class="btn btn-danger  delete" style="text-align: center;" value="<?= $row->SEAT_ID ?>"><i class="fa fa-trash"></i></button>
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

<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            var deskID = $(this).val();
            var result = confirm(`ยืนยันการลบโต๊ะ รหัส ${deskID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/desk/deleteSeat') ?>",
                    method: "POST",
                    data: {
                        deskID: deskID
                    },
                    success: function() {
                        alert(`ลบโซน รหัส ${deskID} เสร็จสิ้น`);
                        location.href = "<?= site_url('admin/desk/') ?>";
                    }
                });
            }
        });
    });
</script>