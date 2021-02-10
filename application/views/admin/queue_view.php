<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="d-inline">คิวล่วงหน้า</h3>
                    </div>
                    <div class="col">
                        <div class="row ">
                            <!-- <div class="col-8">
                                <h5 class="align-middle text-center float right">เวลาเลยกำหนด <span id="time"><?php foreach ($queueTime  as $row) {
                                                                                                                    echo $row->QUEUETYPE_TIME;
                                                                                                                } ?></span> นาที</h5>
                            </div> -->
                            <div class="col">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary  float-right" data-toggle="modal" data-target="#queueTimeModal">
                                    ตั้งค่าเวลาเลยกำหนด
                                </button>
                                <h4 class=" float-right">เวลาเลยกำหนด <span id="queueTimeShow"><?php foreach ($queueTime  as $row) {
                                                                                                                    echo $row->QUEUETYPE_TIME;
                                                                                                                } ?></span> นาที</h4>
                                                                                                            
                                <!-- Modal -->
                                <div class="modal fade" id="queueTimeModal" tabindex="-1" role="dialog" aria-labelledby="queueTimeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="queueTimeModalLabel">เวลาเลยกำหนดคิวล่วงหน้า</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" id="queueTimeForm">
                                                <div class="modal-body">
                                                    <?php foreach ($queueTime  as $row) : ?>
                                                        <div class="row justify-content-center">
                                                            <div class="col-sm col-md col-xl-7 ">
                                                                <label for="queueTime">เวลา (นาที)</label>
                                                                <input type="number" name="queueTime" id="queueTime" class="form-control" min="0" required value="<?= $row->QUEUETYPE_TIME ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="#" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
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
                            <a href="<?= site_url('admin/desk/addDesk') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </form>
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
                        echo '<p class="float-right">จำนวน ' . $total . ' โต๊ะ</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        ?> -->
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
                                                <th style="text-align: center;">สถานะการใช้งาน</th>
                                                <th style="text-align: center;">แก้ไข</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php foreach ($desk as $row) : ?>
                                                <tr id="<?= $row->SEAT_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_ID; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SEAT_AMOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->ZONE_NAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?php if ($row->SEAT_ACTIVE == '1') {
                                                                                                                echo 'พร้อมใช้งาน';
                                                                                                            } else {
                                                                                                                echo 'ไม่พร้อมใช้งาน';
                                                                                                            }
                                                                                                            ?></td>

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
                                            <?php endforeach; ?> -->
                                        </tbody>
                                    </table>
                                    <!-- <?php if ($links != null) {
                                                echo $links;
                                            } else { ?>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item active"><a class="page-link ">1</a></li>

                                            </ul>
                                        </nav>
                                    <?php } ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>