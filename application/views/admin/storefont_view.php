ฺ<br>
<div class="row">
    <div class="col-10">
        <div class="card boder-0 shadow-lg h-100">
            <div class="card-header ">
                <h3 class="d-inline">เข้าใช้บริการ</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="card ">
                            <div class="card-header bg-dark text-white">
                                <h4 class="d-inline">โต๊ะว่าง</h4>
                            </div>
                            <div class="card-body">
                                <?php $inputNo = 1;
                                foreach ($zone as $row) : ?>
                                    <h4><?= $row->ZONE_NAME; ?></h4>
                                    <div class="row">
                                        <?php foreach ($deskEmpty as $row2) : ?>
                                            <?php if ($row->ZONE_ID == $row2->SEAT_ZONE) { ?>
                                                <div class="col-6">
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
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-header bg-dark text-white ">
                                <h4 class="d-inline">ห้องคาราโอเกะว่าง</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                foreach ($zone as $row) : ?>
                                    <h4><?= $row->ZONE_NAME; ?></h4>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <?php foreach ($karaokeEmpty as $row2) : ?>
                                                        <?php if ($row->ZONE_ID == $row2->SEAT_ZONE) { ?>
                                                            <tr class="d-flex form-check form-check-inline" id="rowka<?= $inputNo; ?>">
                                                                <!-- 
                                                                <td class="col-4"><input class="form-check-input useKaraokeEmpty" type="checkbox" name="karaokeEmpty[]" id="karaokeEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                    <label class="form-check-label" for="karaokeEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME . '  (' . $row2->SEAT_AMOUNT . ' ที่นั่ง )'; ?></label>
                                                                </td>
                                                                <td class="col-5"> <select name="karaokeUsetype[]" class="form-control karaokeUseTypeE" class="form-control" disabled>
                                                                        <option value="" disabled selected>เลือกการใช้งาน</option>
                                                                        <option value="1">เหมาห้อง </option>
                                                                        <option value="2">รายชั่วโมง</option>

                                                                    </select></td>
                                                                <td class="col-3"> <input type="number" name="karaokeUseAmount[]" class="form-control karaokeUseAmountE" min="1" max="1" value="1" disabled>
                                                                </td> -->


                                                                <td class="col-3"><input class="form-check-input useKaraokeEmpty" type="checkbox" name="karaokeEmpty[]" id="karaokeEmpty<?= $inputNo; ?>" value="<?= $row2->SEAT_ID; ?>">
                                                                    <label class="form-check-label" for="karaokeEmpty<?= $inputNo; ?>"><?= $row2->SEAT_NAME . '  (' . $row2->SEAT_AMOUNT . ' ที่นั่ง )'; ?></label>
                                                                </td>
                                                                <td class="col-2"><?= 'เหมา '.$row2->KARAOKE_FLATRATE . ' &#3647' ?> </td>
                                                                <td class="col-2"><?= 'ชม. '.$row2->KARAOKE_PRICEPERHOUR . ' &#3647' ?></td>

                                                                <td class="col"> <select name="karaokeUsetype[]" class="form-control karaokeUseTypeE" class="form-control" disabled>
                                                                        <option value="" disabled selected>เลือกการใช้งาน</option>
                                                                        <option value="1">เหมาห้อง </option>
                                                                        <option value="2">รายชั่วโมง</option>

                                                                    </select></td>
                                                                <td class="col-2"> <input type="number" name="karaokeUseAmount[]" class="form-control karaokeUseAmountE" min="1" max="1" value="1" disabled>
                                                                </td>
                                                            </tr>

                                                        <?php $inputNo++;
                                                        } ?>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card boder-0 shadow-lg h-100">
            <div class="card-header ">
                <h3 class="d-inline">รายละเอียด </h3>
            </div>
            <div class="card-body d-flex flex-column">
                <div id="enterServiceDetail">
                    <label for="AmountCustomer">จำนวนผู้เข้าใช้</label>
                    <input type="text" class="form-control" id="AmountCustomer" name="AmountCustomer">
                </div>
                <div class="mt-auto">
                    <button type="button" id="enterService" class="btn btn-success form-control ">เข้าใช้งาน</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.useKaraokeEmpty').on('change', function() {
            var rowid = $(this).parents('tr').attr('id');

            if ($(this).prop('checked') == true) {
                $(`#${rowid} td:nth-child(4) .karaokeUseTypeE`).prop('disabled', false);
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop('disabled', false);
            } else {
                $(`#${rowid} td:nth-child(4) .karaokeUseTypeE`).prop('disabled', true);
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop('disabled', true);
            }
        });

        $('.karaokeUseTypeE').on('change', function() {
            var rowid = $(this).parents('tr').attr('id');
            var type = $(this).val();
            if (type == '1') {
                $(`#${rowid} td:nth-child(5) .karaokeUseAmountE`).prop({
                    'min': 1,
                    'max': 1,
                    'value': 1,
                });

            } else {
                $(`#${rowid} td:nth-child(3) .karaokeUseAmountE`).prop({
                    'min': 1,
                    'max': 24,
                    'value': 1,
                });
            }
        });
    });
</script>