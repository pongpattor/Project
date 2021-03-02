<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <h3 class="d-inline">ห้องคาราโอเกะ</h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/karaoke/'); ?>" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-3 form-group row">
                                    <div class="col-3"> <label for="karaokeActive" class="col-form-label">สถานะ</label></div>
                                    <div class="col">
                                        <select name="karaokeActive" id="karaokeActive" class="form-control">
                                            <option value="1,0" selected>ทั้งหมด</option>
                                            <option value="1" <?php if ($this->input->get('karaokeActive') == '1') {
                                                                    echo 'selected';
                                                                } ?>>พร้อมใช้งาน</option>
                                            <option value="0" <?php if ($this->input->get('karaokeActive') == '0') {
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
                            <a href="<?= site_url('admin/karaoke/addKaraoke') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
                <!-- <br> -->
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
                        echo '<p class="float-right">จำนวน ' . $total . ' ห้อง</p>';
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
                                                <th style="text-align: center;">รหัสห้อง</th>
                                                <th style="text-align: center;">ชื่อห้อง</th>
                                                <th style="text-align: center;">จำนวนที่นั่ง</th>
                                                <th style="text-align: center;">โซนที่นั่ง</th>
                                                <th style="text-align: center;">ราคา/ชั่วโมง</th>
                                                <th style="text-align: center;">ราคาเหมา</th>
                                                <th style="text-align: center;">การจอง</th>
                                                <th style="text-align: center;">สถานะการใช้งาน</th>
                                                <th style="text-align: center;">แก้ไข</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($karaoke as $row) : ?>
                                                <tr id="<?= $row->SEAT_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_ID; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_AMOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->ZONE_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->KARAOKE_PRICEPERHOUR; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->KARAOKE_FLATRATE; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?php if ($row->SEAT_QUEUE == '1') {
                                                                                                                echo 'สามารถจองได้';
                                                                                                            } else {
                                                                                                                echo 'ไม่สามารถจองได้';
                                                                                                            }
                                                                                                            ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?php if ($row->SEAT_ACTIVE == '1') {
                                                                                                                echo 'พร้อมใช้งาน';
                                                                                                            } else {
                                                                                                                echo 'ไม่พร้อมใช้งาน';
                                                                                                            }
                                                                                                            ?></td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <form action="<?= site_url('admin/karaoke/editKaraoke') ?>" method="get">
                                                                <button name="karaokeID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->SEAT_ID ?>"><i class="fa fa-edit"></i></button>
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
            var karaokeID = $(this).val();
            var result = confirm(`ยืนยันการลบห้องคาราโอเกะ รหัส ${karaokeID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/karaoke/deleteSeat') ?>",
                    method: "POST",
                    data: {
                        karaokeID: karaokeID
                    },
                    success: function() {
                        alert(`ลบห้องคาราโอเกะ รหัส ${karaokeID} เสร็จสิ้น`);
                        location.href = "<?= site_url('admin/karaoke/') ?>";
                    }
                });
            }
        });
    });
</script>