<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขคิวล่วงหน้า</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form method="POST" id="editQueueForm">
                        <?php foreach ($queue  as $row) : ?>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="employeeName">พนักงานที่รับจอง </label>
                                    <input type="text" name="employeeName" id="employeeName" class="form-control" disabled value="<?= $row->EMPLOYEE_FIRSTNAME . ' ' . $row->EMPLOYEE_LASTNAME; ?>">
                                    <input type="hidden" name="queueID" value="<?= $row->QUEUE_ID; ?>">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerName">ชื่อผู้จอง </label>
                                    <input type="text" name="customerName" class="form-control" required maxlength="50" value="<?= $row->QUEUE_CUSNAME; ?>">
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerTel">เบอร์โทร <span id="cusTelError" style="color:red;"></span></label>
                                    <input type="tel" class="form-control" name="customerTel" maxlength="10" minlength="10" required value="<?= $row->QUEUE_CUSTEL; ?>">
                                    <input type="hidden" name="customerTelOld" value="<?= $row->QUEUE_CUSTEL; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="customerAmount">จำนวนคน <span id="customerAmountError" style="color:red"></span>
                                    </label>
                                    <input type="number" class="form-control" name="customerAmount" id="customerAmount" min="1" value="<?= $row->QUEUE_CUSAMOUNT; ?>" required>
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="seatAll">จำนวนที่นั่งทั้งหมด </label>
                                    <input type="number" class="form-control" name="seatAll" id="seatAll" value="<?= $row->amt; ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="queueDate">วันเวลาที่จอง </label>
                                    <input type="date" name="queueDate" id="queueDate" class="form-control" required min="<?php echo date('Y-m-d') ?>" value="<?php echo $row->QUEUE_DSTART ?>">
                                    <input type="hidden" name="queueDateOld" id="queueDateOld"  value="<?php echo $row->QUEUE_DSTART ?>">
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="queueTime">วันเวลาที่จอง </label>
                                    <input type="time" name="queueTime" id="queueTime" class="form-control" required min="09:00" max="21:00" value="<?php echo $row->QUEUE_TSTART ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="card boder-0 ">
                                        <div class="card-body">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deskModal">
                                                เลือกโต๊ะ 
                                            </button>
                                            <span id="deskError" style="color:red;"></span>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deskModal" tabindex="-1" role="dialog" aria-labelledby="deskModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-lg" role="document">
                                                    <div class="modal-content ">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deskModalLabel">โต๊ะ</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive" id="deskTableModal">
                                                                <table id="deskTable" class="display table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รหัส</th>
                                                                            <th>ชื่อ</th>
                                                                            <th>โซน</th>
                                                                            <th>จำนวนคน</th>
                                                                            <th>เลือก</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="deskBody">
                                                                        <?php
                                                                        $rowd = 1;
                                                                        foreach ($seat as $row3) :
                                                                            if ($row3->SEAT_TYPE == 1) : ?>
                                                                                <tr id="rowd<?= $rowd ?>">
                                                                                    <td><?= $row3->SEAT_ID ?></td>
                                                                                    <td><?= $row3->SEAT_NAME ?></td>
                                                                                    <td><?= $row3->ZONE_NAME ?></td>
                                                                                    <td><?= $row3->SEAT_AMOUNT ?></td>
                                                                                    <td><button type="button" class="selectDesk btn btn-primary">เลือก</button></td>
                                                                                </tr>
                                                                        <?php
                                                                                $rowd++;
                                                                            endif;
                                                                        endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <br>
                                                <table class="display table table-bordered" style="width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="align-middle" style="text-align: center;">โต๊ะ</th>
                                                            <th class="align-middle" style="text-align: center;">จำนวนที่นั่ง</th>
                                                            <th class="align-middle" style="text-align: center;">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="SdeskBody">
                                                        <?php
                                                        $rowsd = 1;
                                                        foreach ($queueSeat as $row2) :
                                                            if ($row2->SEAT_TYPE == 1) : ?>
                                                                <tr id="rowsd<?= $rowsd ?>">
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <input type="text" value="<?= $row2->SEAT_NAME ?>" style="text-align: center;" class="form-control" disabled>
                                                                        <input type="hidden" name="deskID[]" class="deskID" value="<?= $row2->QS_SEATID ?>">
                                                                    </td>
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <input type="text" value="<?= $row2->SEAT_AMOUNT ?>" style="text-align: center;" class="form-control seatAmount" disabled>
                                                                    </td>
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <button type="button" class="btn btn-danger deleteSD" value="<?= $rowsd; ?>" >ลบ</button>
                                                                    </td>
                                                                </tr>
                                                        <?php $rowsd++;
                                                            endif;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm col-md col-xl-6 ">
                                    <div class="card boder-0 ">
                                        <div class="card-body">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#karokeModal">
                                                เลือกห้องคาราโอเกะ
                                            </button>
                                            <span id="karaokeError" style="color:red;"></span>
                                            <!-- Modal -->
                                            <div class="modal fade" id="karokeModal" tabindex="-1" role="dialog" aria-labelledby="karaokeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-lg" role="document">
                                                    <div class="modal-content ">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="karaokeModalLabel">ห้องคาราโอเกะ</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body ">
                                                            <div class="table-responsive" id="karaokeTableModal">
                                                                <table id="karaokeTable" class="display table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รหัส</th>
                                                                            <th>ชื่อ</th>
                                                                            <th>โซน</th>
                                                                            <th>จำนวนคน</th>
                                                                            <th>ราคา/ชั่วโมง</th>
                                                                            <th>ราคาเหมา</th>
                                                                            <th>เลือก</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="karaokeBody">
                                                                        <?php
                                                                        $rowk = 1;
                                                                        foreach ($seat as $row4) :
                                                                            if ($row4->SEAT_TYPE == 2) : ?>
                                                                                <tr id="rowk<?= $rowk ?>">
                                                                                    <td><?= $row4->SEAT_ID ?></td>
                                                                                    <td><?= $row4->SEAT_NAME ?></td>
                                                                                    <td><?= $row4->ZONE_NAME ?></td>
                                                                                    <td><?= $row4->SEAT_AMOUNT ?></td>
                                                                                    <td><?= $row4->KARAOKE_PRICEPERHOUR ?></td>
                                                                                    <td><?= $row4->KARAOKE_FLATRATE ?></td>
                                                                                    <td><button type="button" class="selectKaraoke btn btn-primary">เลือก</button></td>
                                                                                </tr>
                                                                        <?php
                                                                                $rowk++;
                                                                            endif;
                                                                        endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <br>
                                                <table class="display table table-bordered" style="width: 100%;" id="SkaraokeTable">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="align-middle" style="text-align: center;">ห้องคาราโอเกะ</th>
                                                            <th class="align-middle" style="text-align: center;">จำนวนที่นั่ง</th>
                                                            <th class="align-middle" style="text-align: center;">ประเภทใช้งาน</th>
                                                            <th class="align-middle" style="text-align: center;">จำนวนใช้งาน</th>
                                                            <th class="align-middle" style="text-align: center;">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="SkaraokeBody">
                                                        <?php
                                                        $rowsk = 1;
                                                        foreach ($queueSeat as $row2) :
                                                            if ($row2->SEAT_TYPE == 2) : ?>
                                                                <tr id="rowsk<?= $rowsk ?>">
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <input type="text" value="<?= $row2->SEAT_NAME ?>" style="text-align: center;" class="form-control" disabled>
                                                                        <input type="hidden" name="karaokeID[]" class="karaokeID" value="<?= $row2->QS_SEATID ?>">
                                                                    </td>
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <input type="text" value="<?= $row2->SEAT_AMOUNT ?>" style="text-align: center;" class="form-control seatAmount" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <select name="karaokeUseType[]" class="form-control karaokeUseType" required>
                                                                            <option value="" selected disabled>กรุณาเลือกประเภทใช้งาน</option>
                                                                            <option value="1" <?php if ($row2->QSK_KARAOKEUSETYPE == '1') {
                                                                                                    echo 'selected ';
                                                                                                } ?>>เหมาห้อง</option>
                                                                            <option value="2" <?php if ($row2->QSK_KARAOKEUSETYPE == '2') {
                                                                                                    echo 'selected ';
                                                                                                } ?>>รายชั่วโมง</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" name="karaokeUseAmount[]" class="form-control karaokeUseAmount" min="1" max="<?php if ($row2->QSK_KARAOKEUSETYPE == '1') {
                                                                                                                                                                                echo '1';
                                                                                                                                                                            } else {
                                                                                                                                                                                echo '24';
                                                                                                                                                                            } ?>" value="<?= $row2->QSK_KARAOKEUSEAMOUNT ?>" required>
                                                                    </td>
                                                                    <td style="text-align: center;" class="align-middle">
                                                                        <button type="button" class="btn btn-danger deleteSK" value="<?= $rowsk ?>">ลบ</button>
                                                                    </td>
                                                                </tr>
                                                        <?php $rowsk++;
                                                            endif;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="seatAllError" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="note">หมายเหตุ </label>
                                    <textarea name="note" class="form-control" cols="30" rows="3" maxlength="50"><?= $row->QUEUE_NOTE; ?></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <center>
                                        <div class="input-group">
                                            <div class="col">
                                                <a href="<?= site_url('admin/queue/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input class="btn btn-success btn-xs" type="submit" value="บันทึก" <?php if($row->QUEUE_ACTIVE == '2'){echo 'disabled';}?>>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>