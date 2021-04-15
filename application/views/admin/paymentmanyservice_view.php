<br>
<div class="row">
    <div class="col-12">
        <div class="card  boder-0 shadow-lg">
            <div class="card-header bg-light text-center">
                <h3 class="d-inline">เซอร์วิสที่ต้องการคิดเงิน</h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row">
    <div class="col">
        <div class="card  boder-0 shadow-lg">
            <div class="card-header bg-dark text-center text-white">
                <h3 class="d-inline">เซอร์วิสทั้งหมด</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="etcService">
                                <thead class="">
                                    <tr>
                                        <th style="text-align: center;">เซอร์วิส</th>
                                        <th style="text-align: center;">โต๊ะ</th>
                                        <th style="text-align: center;">เลือก</th>
                                    </tr>
                                </thead>
                                <tbody id="etcService">
                                    <?php
                                    foreach ($etcService as $row) : ?>
                                        <tr id="<?= $row->SERVICE_ID ?>">
                                            <td class="align-middle" style="text-align: center;"><?= $row->SERVICE_ID ?>
                                                <input type="hidden" name="EtcServiceID[]" class="EtcServiceID" value="<?= $row->SERVICE_ID ?>">
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php $j = 1;
                                                foreach ($etcSeat as $row2) :
                                                    if ($row2->SERVICE_ID == $row->SERVICE_ID) {
                                                        echo $row2->SEATNAME . ' ';
                                                        if ($j % 3 == 0) {
                                                            echo '<br>';
                                                        }
                                                        $j++;
                                                    }
                                                endforeach; ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <button type="button" class="btn btn-info selectEtcService">เลือก</button>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <form action="<?= site_url('admin/payment/pay') ?>" method="POST" id="SelectServicePaymentForm">
            <div class="card  boder-0 shadow-lg">
                <div class="card-header bg-dark text-center text-white">
                    <h3 class="d-inline">เซอร์วิสที่เลือก</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-sm" width="100%" cellspacing="0" id="sellTable">
                                    <thead class="">
                                        <tr>
                                            <th style="text-align: center;">เซอร์วิสที่เลือก</th>
                                            <th style="text-align: center;">ยกเลิก</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectService">
                                        <tr id="rowSelectService1">
                                            <td class="align-middle" style="text-align: center;">
                                                <?= $this->input->get('serviceID'); ?>
                                                <input type="hidden" name="selectServiceID[]" class="selectServiceID" value="<?= $this->input->get('serviceID'); ?>">
                                            </td>
                                            <td class="align-middle" style="text-align: center;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><br>
                    <div class="row ">
                        <div class="col">
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success form-control">ชำระเงิน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#etcService').dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "language": {
                "emptyTable": "ไม่มีข้อมูล กรุณาเลือกวันที่จองก่อน",
                "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
            }
        });

        function checkServiceSeat(serviceID) {
            var checkType = true;
            var rowid;
            $('.selectServiceID').each(function() {
                rowid = $(this).parents('tr').attr('id');
                rowSelectServiceID = $(`#${rowid} .selectServiceID`).val();
                if (serviceID == rowSelectServiceID) {
                    checkType = false;
                    return false;
                }
            });
            return checkType;
        }

        $(document).on('click', '.selectEtcService', function() {
            var rowid = $(this).parents('tr').attr('id');
            var check = checkServiceSeat(rowid);
            if (check == true) {
                var lastSelectService = $('#selectService tr:last-child').attr('id');
                var lastid = lastSelectService.substr(16);
                lastid = parseInt(lastid) + 1;
                var table = `<tr id="rowSelectService${lastid}">
                                <td class="align-middle" style="text-align: center;">${rowid}
                                    <input type="hidden" name="selectServiceID[]" class="selectServiceID" value="${rowid}">
                                </td>
                                <td class="align-middle" style="text-align: center;">
                                    <button type="button" class="btn btn-danger deleteSelectService"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>`;
                $('#selectService').append(table);
                // alert(lastSelectService);
            } else {
                alert('ซ้ำ');
            }
        });

        $(document).on('click', '.deleteSelectService', function() {
            var rowid = $(this).parents('tr').attr('id');
            $(`#${rowid}`).remove();
        });

        // $('#SelectServicePaymentForm').on('submit', function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: "",
        //         method : "POST",
        //         data: $(this).serialize(),
        //         dataType : "JSON",
        //         success:function(data){
        //            console.log(data); 
        //         }
        //     })
        // });

    });
</script>