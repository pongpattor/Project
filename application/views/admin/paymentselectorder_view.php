<br>
<div class="row">
    <div class="col-12">
        <div class="card  boder-0 shadow-lg">
            <div class="card-header bg-light text-center">
                <h3 class="d-inline">เลือกสินค้าที่ต้องการแยกชำระเงิน</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<form action="<?= site_url('admin/payment/paySplit') ?>" id="splitOrderForm" method="POST">
    <div class="row">
        <div class="col-12">
            <div class="card  boder-0 shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-sm" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th style="text-align: center;">รายการ</th>
                                            <th style="text-align: center;">ประเภท</th>
                                            <th style="text-align: center;">หมายเหตุ</th>
                                            <th style="text-align: center;">จำนวน</th>
                                            <th style="text-align: center;">เลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="serviceID" value="<?= $this->input->get('serviceID'); ?>">
                                        <?php foreach ($orderDetail as $row) : ?>
                                            <tr id="<?= $row->DTSER_NO; ?>">
                                                <td class="align-middle" style="text-align: center;  width:10%"><?= $row->DTSER_NO ?></td>
                                                <?php $orderName = '';
                                                $orderID = '';
                                                $orderType = '';
                                                if ($row->PRODUCT_ID != null) {
                                                    $orderID = $row->PRODUCT_ID;
                                                    $orderName = $row->PRODUCT_NAME;
                                                    $orderType = 'อาหารหรือเครื่องดื่ม';
                                                } else if ($row->SEAT_ID != null) {
                                                    $orderID = $row->SEAT_ID;
                                                    $orderName = $row->SEAT_NAME;
                                                    $orderType = 'ห้องคาราโอเกะ';
                                                } else if ($row->PROMOTIONSET_ID != null) {
                                                    $orderID = $row->PROMOTIONSET_ID;
                                                    $orderName = $row->PROMOTIONSET_NAME;
                                                    $orderType = 'โปรโมชั่นเซ็ท';
                                                } ?>
                                                <td class="align-middle" style="text-align: center;"><?= $orderName; ?> </td>
                                                <td class="align-middle" style="text-align: center; width:15%"><?= $orderType; ?></td>
                                                <td class="align-middle" style="text-align: center; width:15%"><?= $row->DTSER_NOTE; ?></td>

                                                <td class="align-middle" style="text-align: center; width:15%">
                                                    <input type="hidden" name="orderID[]" class="orderID" value="<?= $orderID ?>" disabled>
                                                    <input type="number" name="orderAmount[]" class="orderAmount form-control text-center" value="<?= $row->DTSER_REMAINDER; ?>" min="1" max="<?= $row->DTSER_REMAINDER; ?>" disabled>
                                                </td>
                                                <td class="align-middle" style="text-align: center; width:15%">
                                                    <input type="checkbox" name="OrderNo[]" class="orderSelect" value="<?= $row->DTSER_NO ?>">
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div class="col">
                            <a href="<?= site_url('admin/service/instore') ?>" class="btn btn-danger">ยกเลิก</a>
                            <button type="submit" class="btn btn-info">ชำระเงิน</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('#splitOrderForm').on('submit', function() {
            var check = 0;
            $('.orderSelect').each(function() {
                if ($(this).prop('checked') == true) {
                    check = 1;
                    return false;
                }
            });
            if (check == 0) {
                alert('กรุณาเลือกรายการ');
                return false;
            } else {
                return true;
            }
        });

        $(document).on('change', '.orderAmount', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                $(this).val(1);
            }
        });
        $(document).on('change', '.orderSelect', function() {
            let rowid = $(this).parents('tr').attr('id');
            if ($(this).prop('checked') == true) {
                $(`#${rowid} .orderID`).prop('disabled', false);
                $(`#${rowid} .orderAmount`).prop('disabled', false);
            } else {
                $(`#${rowid} .orderID`).prop('disabled', true);
                $(`#${rowid} .orderAmount`).prop('disabled', true);
            }
        });

    });
</script>