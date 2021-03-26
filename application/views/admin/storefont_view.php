ฺ<br>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="card boder-0 shadow-lg">
                    <div class="card-header ">
                        <h3 class="d-inline">เข้าใช้บริการ</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card ">
                                    <div class="card-header bg-dark text-white">
                                        <h4 class="d-inline">โต๊ะว่าง</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="#" method="GET">
                                            <?php $inputNo = 1;
                                            foreach ($zone as $row) : ?>
                                                <h4><?= $row->ZONE_NAME; ?></h4>
                                                <div class="row">
                                                    <?php foreach ($deskEmpty as $row2) : ?>
                                                        <?php if ($row->ZONE_ID == $row2->SEAT_ZONE) { ?>
                                                            <div class="col-4">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="deskEmpty[]" id="deskEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                    <label class="form-check-label" for="deskEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME . '  (' . $row2->SEAT_AMOUNT . ' ที่นั่ง )'; ?></label>
                                                                </div>
                                                            </div>
                                                        <?php $inputNo++;
                                                        } ?>

                                                    <?php endforeach; ?>
                                                </div>
                                                <br>
                                            <?php endforeach; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card ">
                                    <div class="card-header bg-dark text-white">
                                        <h4 class="d-inline">ห้องคาราโอเกะว่าง</h4>
                                    </div>
                                    <div class="card-body">

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

<script>
    
</script>