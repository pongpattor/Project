<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <div class="row ">
                    <div class="col">
                        <h3 class="d-inline">รายการที่ต้องเสิร์ฟ</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">โต๊ะ</th>
                                        <th style="text-align: center;">รายกาาร</th>
                                        <th style="text-align: center;">จำนวน</th>
                                        <th style="text-align: center;">เสิร์ฟ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rowi = 1;
                                    foreach ($serviceServed as $row) { ?>
                                        <tr id="rowServed<?= $rowi; ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;">
                                                <?php $i = 0;
                                                foreach ($seatAll as $row2) {
                                                    if ($row->DTSER_ID == $row2->SERSEAT_SERVICEID) {
                                                        echo $row2->SEAT_NAMES . ' ';
                                                        $i++;
                                                        if ($i % 3 == 0) {
                                                            echo '<br>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->AMOUNT; ?></td>
                                            <td class="align-middle" style="text-align: center; width:15%;">
                                                <input type="hidden" class="serviceID" value="<?= $row->DTSER_ID; ?>">
                                                <input type="hidden" class="serviceNO" value="<?= $row->DTSER_NO; ?>">
                                                <input type="hidden" class="serviceTypeOrder" value="<?= $row->DTSER_TYPEORDER; ?>">
                                                <input type="hidden" class="productID" value="<?= $row->PRODUCT_ID; ?>">
                                                <button type="button" class="btn btn-success servedCustomer">เสิร์ฟ</button>
                                            </td>
                                        </tr>
                                    <?php $rowi++;
                                    } ?>
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

<script>
    $(document).ready(function() {
        function callServed() {
            $.ajax({
                url: "<?= site_url('admin/admin/callServed') ?>",
                dataType: "JSON",
                success: function(data) {
                    if (data.cnt > 0) {
                        $('#alertServe').html(data.cnt);
                    } else {
                        $('#alertServe').html('');
                    }
                }
            });
        }

        $(document).on('click', '.servedCustomer', function() {
            var rowid = $(this).parents('tr').attr('id');
            var serviceID = $(`#${rowid} .serviceID`).val();
            var serviceNO = $(`#${rowid} .serviceNO`).val();
            var serviceTypeOrder = $(`#${rowid} .serviceTypeOrder`).val();
            var productID = $(`#${rowid} .productID`).val();

            // alert(rowid+'\n'+serviceID+'\n'+serviceNO+'\n'+serviceTypeOrder+'\n'+productID);
            $.ajax({
                url: "<?= site_url('admin/service/servedCustomer') ?>",
                method: "POST",
                data: {
                    serviceID: serviceID,
                    serviceNO: serviceNO,
                    serviceTypeOrder: serviceTypeOrder,
                    productID: productID,
                },
                success: function() {
                    callServed();
                    location.reload();
                }
            });
        });


        function refreshPage(){
            location.reload();
        }

        setInterval(refreshPage,10000);
    });
</script>