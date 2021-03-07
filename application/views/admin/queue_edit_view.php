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
                    <form method="POST" id="addQueueForm">
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="employeeName">พนักงานที่รับจอง </label>
                                <input type="text" name="employeeName" id="employeeName" class="form-control" disabled >
                                <input type="hidden" name="employeeID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerName">ชื่อผู้จอง </label>
                                <input type="text" name="customerName" id="deskName" class="form-control" required maxlength="50">
                            </div>
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerTel">เบอร์โทร <span id="cusTelError" style="color:red;"></span></label>
                                <input type="tel" class="form-control" name="customerTel" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="customerAmount">จำนวนคน <span id="customerAmountError" style="color:red"></span>
                                </label>
                                <input type="number" class="form-control" name="customerAmount" id="customerAmount" min="1" value="1" required>
                            </div>
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="seatAll">จำนวนที่นั่งทั้งหมด </label>
                                <input type="number" class="form-control" name="seatAll" id="seatAll" value="0" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="queueDateTime">วันเวลาที่จอง </label>
                                <input type="datetime-local" name="queueDateTime" id="queueDateTime" class="form-control" required min="<?php echo date('Y-m-d') . "T00:00:00" ?>">
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
                                                    <div class="modal-body ">
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
                                <textarea name="note" class="form-control" cols="30" rows="3" maxlength="50"></textarea>
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
                                            <input class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>