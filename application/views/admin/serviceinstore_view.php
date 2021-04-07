<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="d-inline">เซอร์วิส</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="#" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row form-group">
                                <div class="col-7 input-group">
                                    <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                                    <div class="input-group-append">
                                        <button class="input-group-text"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <a href="<?= site_url('admin/queue/addQueue') ?>" class="btn btn-info float-right"><i class="fa fa-plus-circle"></i></a>
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
                        echo '<p class="float-right">จำนวน ' . $total . ' เซอร์วิส</p>';
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
                                                <th style="text-align: center;">รหัสเซอร์วิส</th>
                                                <th style="text-align: center;">จำนวนคน</th>
                                                <th style="text-align: center;">ที่นั่ง</th>
                                                <th style="text-align: center;">วันเวลาเข้าใช้งาน</th>
                                                <th style="text-align: center;">สถานะ</th>
                                                <th style="text-align: center;">รายละเอียดที่สั่ง</th>
                                                <th style="text-align: center;">สั่งอาหาร</th>
                                                <th style="text-align: center;">ย้ายโต๊ะ</th>
                                                <th style="text-align: center;">คิดเงิน</th>
                                                <th style="text-align: center;">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($service as $row) : ?>
                                                <tr id="<?= $row->SERVICE_ID ?>" class=" bgtable">
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SERVICE_ID; ?></td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SERVICE_CUSAMOUNT; ?></td>
                                                    <td class="align-middle" style="text-align: center;">
                                                        <?php $i=0; foreach ($serviceSeat as $row2) {
                                                            if ($row->SERVICE_ID == $row2->SERSEAT_SERVICEID) {
                                                                echo $row2->SEAT_NAMES . ' ';
                                                                $i++;
                                                                if ($i % 2 == 0) {
                                                                    echo '<br>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="align-middle" style="text-align: center;"><?= $row->SERVICE_DSTART.' '.$row->SERVICE_TSTART; ?></td>
                                                    <td class="align-middle" style="text-align: center;"></td>
                                                    <td class="align-middle" style="text-align: center;"><button>1</button></td>
                                                    <td class="align-middle" style="text-align: center;"><button>2</button></td>
                                                    <td class="align-middle" style="text-align: center;"><button>3</button></td>
                                                    <td class="align-middle" style="text-align: center;"><button>4</button></td>
                                                    <td class="align-middle" style="text-align: center;"><button>5</button></td>
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