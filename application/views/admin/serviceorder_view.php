<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">สั่งอาหารและเครื่องดื่ม </h3>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="row">
    <div class="col-7">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input changeTypeOrder" type="radio" name="inlineRadioOptions" id="fooddrink" value="1" checked>
                                    <label class="form-check-label" for="fooddrink">อาหารและเครื่องดื่ม</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input changeTypeOrder" type="radio" name="inlineRadioOptions" id="proset" value="2">
                                    <label class="form-check-label" for="proset">โปรโมชั่นเซ็ท</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" id="headOrderTable">
                                    <table class="table  table-bordered " width="100%" cellspacing="0" id="orderTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">รูป</th>
                                                <th style="text-align: center;">ชื่อรายการ</th>
                                                <th style="text-align: center;">ราคา</th>
                                                <th style="text-align: center;">โปรโมชั่น</th>
                                                <th style="text-align: center;">เพิ่ม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order as $row) : ?>
                                                <tr id="<?= $row->PRODUCT_ID; ?>">
                                                    <td class="align-middle"><img src="<?= base_url('assets/image/product/' . $row->PRODUCT_IMAGE); ?>" alt="" width="50px" height="50px"></td>
                                                    <td class="align-middle"><?= $row->PRODUCT_NAME; ?></td>
                                                    <td class="align-middle"><?php if ($row->PRICE_DISCOUNT == NULL) {
                                                                                    echo  $row->PRODUCT_SELLPRICE;
                                                                                } else {
                                                                                    echo "<font style=\"color:#BFBFBF;\"><del>$row->PRODUCT_SELLPRICE</del></font><br>";
                                                                                    echo '<font style="color:red;">';
                                                                                    echo number_format($row->PRICE_DISCOUNT, 2);
                                                                                    echo '</font>';
                                                                                } ?></td>
                                                    <td class="align-middle"><?= $row->PROMOTIONPRICE_NAME; ?></td>
                                                    <td class="align-middle"><button class="btn btn-success addOrder"> <i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-0 shadow-lg">
            <div class="card-header">
                <h4>รายการที่สั่ง</h4>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#orderTable').dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "language": {
                "emptyTable": "ไม่มีข้อมูล",
                "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
            }
        });

        $('.changeTypeOrder').on('change', function() {
            var type = $(this).val();
            var table = "";
            if (type == '1') {
                $.ajax({
                    url: "<?= site_url('admin/service/indexOrder') ?>",
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        console.log(data.order);
                        table = `
                        <table class="table  table-bordered " width="100%" cellspacing="0" id="orderTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">รูป</th>
                                                <th style="text-align: center;">ชื่อรายการ</th>
                                                <th style="text-align: center;">ราคา</th>
                                                <th style="text-align: center;">โปรโมชั่น</th>
                                                <th style="text-align: center;">เพิ่ม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        $.each(data.order, function(key, value) {
                            let proname = "";
                            let discount = 0;
                            let price = parseFloat(value.PRODUCT_SELLPRICE).toFixed(2);

                            if (value.PROMOTIONPRICE_NAME != null) {
                                proname = value.PROMOTIONPRICE_NAME;
                            }

                            table += `  
                                    <tr id = "${value.PRODUCT_ID}" >
                                        <td class="align-middle"> <img src="<?= base_url('assets/image/product/'); ?>${value.PRODUCT_IMAGE}" alt="" width="50px" height="50px"> </td> 
                                        <td class="align-middle">${value.PRODUCT_NAME}</td> 
                                        <td class="align-middle">`;
                            if (value.PRICE_DISCOUNT == null) {
                                table +=`
                                        ${price}
                                        `;
                            } else {
                                discount = parseFloat(value.PRICE_DISCOUNT).toFixed(2);
                                table += ` <font style="color:#BFBFBF;"><del>
                                        ${price}
                                        </del></font><br>
                                        <font style="color:red;">${discount} </font>`;
                            }
                            table += `  </td> 
                                        <td class="align-middle">${proname} </td> 
                                        <td class = "align-middle"><button class="btn btn-success addOrder"> <i class="fa fa-plus"> </i></button> </td> 
                                    </tr>             
                                `;
                        });
                        table += ` </tbody>
                                    </table>`;
                    }
                });
            } else {
                $.ajax({
                    url: "<?= site_url('admin/service/indexPromotionSet') ?>",
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        // console.log(data.order);
                        table = `
                        <table class="table  table-bordered " width="100%" cellspacing="0" id="orderTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                                <th style="text-align: center;">ราคา</th>
                                                <th style="text-align: center;" >รายละเอียด</th>
                                                <th style="text-align: center;">เพิ่ม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        // <button class="btn btn-warning" value="${value.PROMOTIONSET_ID}" ><i class="far fa-file-alt"></i>
                        var i = 1;
                        $.each(data.order, function(key, value) {
                            table += `
                                    <tr id="${value.PROMOTIONSET_ID}">
                                        <td class="align-middle">${value.PROMOTIONSET_NAME}</td>
                                        <td class="align-middle">${value.PROMOTIONSET_PRICE}</td>
                                        <td class="align-middle" style="width:18%">                                                                                                                   
                                            <button type="button" class="btn btn-warning detailPromotionset" data-toggle="modal" data-target="#modal${i}" value="${value.PROMOTIONSET_ID}" >
                                            <i class="far fa-file-alt"></i>
                                            </button>
                                            <div class="modal fade" id="modal${i}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">${value.PROMOTIONSET_NAME}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body modalPromotionSetBody" >
                                                        ...
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button></td>
                                        <td class="align-middle" style="width:18%"><button class="btn btn-success addOrder" value="${value.PROMOTIONSET_ID}" ><i class="fa fa-plus"></i></button></td>
                                    </tr>`
                            i++;
                        });
                        table += ` </tbody>
                                    </table>`;
                    }

                });
            }

            $('#headOrderTable').html(table);
            $('#orderTable').dataTable({
                "lengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "All"]
                ],
                "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                }],
                "language": {
                    "emptyTable": "ไม่มีข้อมูล",
                    "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
                }
            });
        });


        $(document).on('click', '.detailPromotionset', function() {
            var promotionSetID = $(this).val();
            var rowid = $(this).parents('tr').attr('id');
            var sellprice = $(`#${rowid} td:nth-child(2)`).html();
            $.ajax({
                url: "<?= site_url('admin/service/indexPromotionSetDetail') ?>",
                method: "POST",
                data: {
                    promotionSetID: promotionSetID,
                },
                dataType: "JSON",
                success: function(data) {
                    var table = `
                        <table class="table  table-bordered " width="100%" cellspacing="0" id="orderTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อรายการ</th>
                                                <th style="text-align: center;" >จำนวน</th>
                                                <th style="text-align: center;" >ราคาขาย</th>
                                                <th style="text-align: center;" >ราคารวม</th>

                                            </tr>
                                        </thead>
                                        <tbody>                   
                        `;
                    var i = 1;
                    var totalprice = 0;
                    $.each(data.promotionSetDetail, function(key, value) {
                        table += `
                                    <tr>
                                        <td class="align-middle">${i}</td>
                                        <td class="align-middle">${value.PRODUCT_NAME}</td>
                                        <td class="align-middle">${value.PROSETDETAIL_AMOUNT}</td>
                                        <td class="align-middle">${value.PRODUCT_SELLPRICE}</td>
                                        <td class="align-middle">${value.SUMEACHORDER}</td>

                                    </tr>
                                `;
                        i++;
                        totalprice += parseFloat(value.SUMEACHORDER);
                    });
                    var saveMoney = sellprice - totalprice;
                    totalprice = totalprice.toFixed(2);
                    saveMoney = saveMoney.toFixed(2);
                    table += ` </tbody>
                    </table>
                    <div class="row">
                        <div class="col text-right">
                        ราคาโปรโมชั่น  
                        </div>
                        <div class="col-3 text-right"> ${sellprice}</div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                        ราคาขายทั้งหมด  
                        </div>
                        <div class="col-3 text-right"> ${totalprice}</div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                        ประหยัด 
                        </div>
                        <div class="col-3 text-right"> ${saveMoney}</div>

                    </div>
                    `;
                    $(`#${rowid} .modalPromotionSetBody`).html(table);

                }
            });

        });

        $(document).on('click', '.addOrder', function() {
            var rowid = $(this).parents('tr').attr('id');
            alert(rowid);
        });
    });
</script>