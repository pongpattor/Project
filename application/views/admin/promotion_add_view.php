<br>
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มโปรโมชั่น</h3>
                </div>
            </div>
        </div>
    </div>
</div>
ฺ<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?= site_url('admin/promotion/insertPromotion') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ชื่อโปรโมชั่น</label><br>
                                <input type="text" class="form-control" name="promotionName" id="promotionName" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                <label>ส่วนลด %</label><br>
                                <input type="number" class="form-control" name="promotionDiscount" id="promotionDiscount" required min="0" max="100">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>ประเภทโปรโมชั่น</label><br>
                                <select name="typePromotion" id="typePromotion" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกประเภทโปรโมชั่น</option>
                                    <option value="0">ทุกรายการ</option>
                                    <option value="1">บางรายการ</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>วันที่เริ่ม <span style="color: red;">*</span> </label>
                                <input type="date" id="dateStart" name="dateStart" class="form-control" required min="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6">
                                <label>วันที่สิ้นสุด <span style="color: red;">*</span> </label>
                                <input type="date" id="dateEnd" name="dateEnd" class="form-control" required min="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <br>

                        <div class="row justify-content-center" id="showDetail">
                            <div class="col-sm col-md col-xl-6 ">
                                <label for="">เลือกรายการสินค้า</label>
                                <div class="card boder-0 ">
                                    <div class="card-body">
                                        <?php
                                        // echo '<pre>';
                                        // print_r( $product);
                                        // echo '</pre>';
                                        $rowid = 0;
                                        $j = 0;
                                        $num = count($product);
                                        for ($i = 0; $i < $num; $i += 3) {
                                            //echo $product[$i]->PRODUCT_NAME; 
                                        ?>
                                            <div class="form-check">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <?php if ($j < $num) { ?>
                                                                <div class="col-4"><input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i]->PRODUCT_ID ?>">
                                                                    <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i]->PRODUCT_NAME; ?></label>
                                                                </div>
                                                            <?php $j++;
                                                            }
                                                            $rowid++;
                                                            if ($j < $num) { ?>
                                                                <div class="col-4">
                                                                    <input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i + 1]->PRODUCT_ID ?>">
                                                                    <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i + 1]->PRODUCT_NAME; ?></label>
                                                                </div>
                                                            <?php $j++;
                                                            }
                                                            $rowid++;
                                                            if ($j < $num) { ?>

                                                                <div class="col-4">
                                                                    <input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i + 2]->PRODUCT_ID ?>">
                                                                    <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i + 2]->PRODUCT_NAME; ?></label>
                                                                </div>
                                                            <?php $j++;
                                                            }
                                                            $rowid++; ?>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        <?php    }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/promotion/'); ?>" class="btn btn-danger  backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success  " type="submit" value="  เพิ่ม  ">
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
<br>
<script>
    $(document).ready(function() {

        $('#dateStart').on('change', function() {
            var minDateEnd = $('#dateStart').val();
            $('#dateEnd').val("");
            $('#dateEnd').attr('min', minDateEnd);
        });

        $('#typePromotion').on('change', function() {
            var typePromotion = $('#typePromotion').val();
            // console.log(typePromotion);
            if (typePromotion == 0) {
                $('#showDetail').hide();
                // console.log(typePromotion);
            } else {
                $('#showDetail').show();
                // console.log(typePromotion);

            }
        });

        $('#addProduct').on('click', function() {

            var promotionName = $('#promotionName').val();
            var promotionDiscount = $('#promotionDiscount').val();
            var typePromotion = $('#typePromotion').val();
            var dateStart = $('#dateStart').val();
            var dateEnd = $('#dateEnd').val();
            $.ajax({
                url: "<?= site_url('admin/promotion/setPromotionDetail') ?>",
                method: "POST",
                data: {
                    promotionName: promotionName,
                    promotionDiscount: promotionDiscount,
                    typePromotion: typePromotion,
                    dateStart: dateStart,
                    dateEnd: dateEnd
                },
                success: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>