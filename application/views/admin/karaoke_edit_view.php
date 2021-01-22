<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขห้องคาราโอเกะ</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form method="POST" id="editKaraokeForm">
                    <?php foreach($karaoke as $row): ?>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ชื่อคาราโอเกะ </label>
                                <input type="text" name="karaokeName" id="karaokeName" class="form-control" value="<?=$row->SEAT_NAME?>" required maxlength="50">
                                <input type="hidden" name="karaokeID" value="<?=$row->SEAT_ID?>">
                                <input type="hidden" name="karaokeNameOld" value="<?=$row->SEAT_NAME?>">
                                <span id="karaokeNameError" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>โซนที่นั่ง</label>
                                <select name="karaokeZone" class="form-control" required>
                                <option value="" selected disabled>กรุณาเลือกโซนที่นั่ง</option>
                                <?php foreach($zone as $row2) : ?>
                                <option value="<?=$row2->ZONE_ID;?>" <?php if($row->SEAT_ZONE == $row2->ZONE_ID){
                                    echo 'selected';
                                } ?>><?=$row2->ZONE_NAME?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>จำนวนคน </label>
                                <input type="number" name="karaokeAmount" id="karaokeAmount" class="form-control" value="<?=$row->SEAT_AMOUNT?>" required min="1" max="99">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ราคาต่อชั่วโมง</label>
                                <input type="number" name="karaokePricePerHour" id="karaokePricePerHour" class="form-control"  value="<?=$row->KARAOKE_PRICEPERHOUR?>"  required min="1" max="99999">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>ราคาเหมา </label>
                                <input type="number" name="karaokeFlatRate" id="karaokeFlatRate" class="form-control"  value="<?=$row->KARAOKE_FLATRATE?>"  required min="1" max="99999">
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/karaoke/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success btn-xs" type="submit" value="แก้ไข">
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
