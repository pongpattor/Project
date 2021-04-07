<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="d-inline">คิวหน้าร้าน</h3>
                    </div>
                    <div class="col">
                        <div class="row ">

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
                                            <form method="POST" id="queueWalkinTimeForm">
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
                                <div class="col-3 form-group row">
                                    <div class="col-3"> <label for="queueActive" class="col-form-label">สถานะ</label></div>
                                    <div class="col">
                                        <select name="queueActive" id="queueActive" class="form-control">
                                            <option value="0,1,2,3" selected>ทั้งหมด</option>
                                            <option value="0" <?php if ($this->input->get('queueActive') == '0') {
                                                                    echo 'selected';
                                                                } ?>>รอยืนยันเข้าใช้งาน</option>
                                            <option value="1" <?php if ($this->input->get('queueActive') == '1') {
                                                                    echo 'selected';
                                                                } ?>>จองคิว</option>
                                            <option value="2" <?php if ($this->input->get('queueActive') == '2') {
                                                                    echo 'selected';
                                                                } ?>>เข้าใช้งานคิว</option>
                                            <option value="3" <?php if ($this->input->get('queueActive') == '3') {
                                                                    echo 'selected';
                                                                } ?>>หมดเวลาจองคิว</option>
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
                            <a href="<?= site_url('admin/queuewalkin/addQueueWalkin') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
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
                        echo '<p class="float-right">จำนวน ' . $total . ' คิว</p>';
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
                                                <th style="text-align: center;">รหัสคิว</th>
                                                <th style="text-align: center;">ผู้จอง</th>
                                                <th style="text-align: center;">เบอร์โทร</th>
                                                <th style="text-align: center;">จำนวนคน</th>
                                                <th style="text-align: center;">วันเวลาจอง</th>
                                                <th style="text-align: center;">วันเวลาหลุดจอง</th>
                                                <th style="text-align: center;">หมายเหตุ</th>
                                                <th style="text-align: center;">สถานะ</th>
                                                <th style="text-align: center;">เรียก</th>
                                                <th style="text-align: center;">เช็คอิน</th>
                                                <th style="text-align: center;">แก้ไข</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($queue as $row) : ?>
                                                <tr id="<?= $row->QUEUE_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_ID; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_CUSNAME; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_CUSTEL; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_CUSAMOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_DSTART . ' ' . $row->QUEUE_TSTART; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_DEND . ' ' . $row->QUEUE_TEND; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->QUEUE_NOTE; ?></td>
                                                    <td class="align-middle" style="text-align: center;">
                                                        <?php
                                                        if ($row->QUEUE_ACTIVE == '0') {
                                                            echo 'รอยืนยันเข้าใช้งาน';
                                                        } else if ($row->QUEUE_ACTIVE == '1') {
                                                            echo 'จองคิว';
                                                        } else if ($row->QUEUE_ACTIVE == '2') {
                                                            echo 'เข้าใช้งานคิว';
                                                        } else if ($row->QUEUE_ACTIVE == '3') {
                                                            echo 'หมดเวลาจองคิว';
                                                        } else {
                                                            echo 'ยกเลิกคิว';
                                                        } ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <button type="button" name="callWalkin" class="btn btn-info  callWalkin" style="text-align: center;" value="<?= $row->QUEUE_ID ?>" <?php if ($row->QUEUE_ACTIVE != '1') {
                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                } ?>><i class="fa fa-hand-paper"></i></button>
                                                        </center>
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                                <button type="button" name="queueID" class="btn btn-success  checkin" style="text-align: center;" value="<?= $row->QUEUE_ID ?>" <?php if ($row->QUEUE_ACTIVE != '0') {
                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                } ?>><i class="fa fa-check"></i></button>
                                                        </center>
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <form action="<?= site_url('admin/queuewalkin/editQueueWalkin') ?>" method="get">
                                                                <button name="queueID" class="btn btn-warning  edit" style="text-align: center;" value="<?= $row->QUEUE_ID ?>"><i class="fa fa-edit"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                            <button class="btn btn-danger  delete" style="text-align: center;" value="<?= $row->QUEUE_ID ?>"><i class="fa fa-trash"></i></button>
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

        $('.delete').click(function() {
            var queueID = $(this).val();
            var result = confirm(`ยืนยันการลบคิว รหัส ${queueID}`);
            if (result) {
                $.ajax({
                    url: "<?= site_url('admin/queue/deleteQueue') ?>",
                    method: "POST",
                    data: {
                        queueID: queueID,
                    },
                    success: function() {
                        alert(`ลบโปรโมชั่นเซ็ต รหัส ${queueID} เสร็จสิ้น`);
                        location.href = "<?= site_url('admin/queue') ?>";
                    }
                });
            }
        });

        $('.callWalkin').on('click', function() {
            var queueID = $(this).val();
            var queueTime = $('#queueTimeShow').html();

            $.ajax({
                url: "<?= site_url('admin/queuewalkin/callWalkin') ?>",
                method: "POST",
                data: {
                    queueID: queueID,
                    queueTime: queueTime
                },
                dataType: "JSON",
                success: function(data) {
                    $(`#${queueID} td:nth-child(9) .callWalkin`).prop('disabled', true);
                    $(`#${queueID} td:nth-child(10) .checkin`).prop('disabled', false);
                    $(`#${queueID} td:nth-child(8)`).html('รอยืนยันเข้าใช้งาน');
                    alert('กรุณาเข้าใช้งานก่อน ' + data.datetime)
                    $(`#${queueID} td:nth-child(6)`).html(data.datetime);
                }
            });
        });

        $('.checkin').on('click', function() {
            var cf = confirm('ยืนยันการเข้าใช้งาน');
            if (cf == true) {
                var queueID = $(this).val();
                $.ajax({
                    url: "<?= site_url('admin/queuewalkin/checkin') ?>",
                    method: "POST",
                    data: {
                        queueID: queueID,
                    },
                    success: function() {
                        alert('เข้าใช้งาน');
                        let amount = $(`#${queueID} td:nth-child(4)`).html();
                        $(`#${queueID} td:nth-child(10) .checkin`).prop('disabled', true);
                        $(`#${queueID} td:nth-child(8) `).html('เข้าใช้งาน');
                        window.location.href = '<?=site_url('admin/service/storefont?queueID=')?>'+queueID+'&amount='+amount;

                    }
                });
            }
        });


        $('#queueWalkinTimeForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('admin/queuewalkin/updateQueueWalkinTime') ?>",
                method: "POST",
                data: $(this).serialize(),
                success: function() {
                    alert('แก้ไขเวลาเลยกำหนดเสร็จสิ้น');
                    location.reload();
                }
            });
        });

        function walkinTimeout() {
            $.ajax({
                url: "<?= site_url('admin/queuewalkin/walkinTimeOut') ?>",
            });
        }

        walkinTimeout();
        setInterval(walkinTimeout, 1000 * 60);
    });
</script>