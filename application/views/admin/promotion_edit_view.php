<br>
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขโปรโมชั่น</h3>
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
                    <form action="<?= site_url('admin/promotion/updatePromotion') ?>" method="POST" enctype="multipart/form-data">
                        <?php foreach ($promotion as $rowp) { ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ชื่อโปรโมชั่น</label><br>
                                    <input type="text" class="form-control" name="promotionName" id="promotionName" required value="<?= $rowp->PROMOTION_NAME; ?>">
                                    <input type="hidden" name="promotionID" value="<?= $rowp->PROMOTION_ID; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6" id="rowTypeProductName">
                                    <label>ส่วนลด %</label><br>
                                    <input type="number" class="form-control" name="promotionDiscount" id="promotionDiscount" required min="0" max="100" value="<?= $rowp->PROMOTION_DISCOUNT_PERCENT; ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>ประเภทโปรโมชั่น</label><br>
                                    <select name="typePromotion" id="typePromotion" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกประเภทโปรโมชั่น</option>
                                        <option value="0" <?php if ($rowp->PROMOTION_TYPE == 0) {
                                                                echo 'selected';
                                                            } ?>>ทุกรายการ</option>
                                        <option value="1" <?php if ($rowp->PROMOTION_TYPE == 1) {
                                                                echo 'selected';
                                                            } ?>>บางรายการ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>วันที่เริ่ม <span style="color: red;">*</span> </label>
                                    <input type="date" id="dateStart" name="dateStart" class="form-control" required min="<?= date('Y-m-d'); ?>" value="<?= $rowp->PROMOTION_START ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6">
                                    <label>วันที่สิ้นสุด <span style="color: red;">*</span> </label>
                                    <input type="date" id="dateEnd" name="dateEnd" class="form-control" required min="<?= date('Y-m-d'); ?>" value="<?= $rowp->PROMOTION_END ?>">
                                </div>
                            </div>
                            <br>

                            <div class="row justify-content-center" id="showDetail">
                                <div class="col-sm col-md col-xl-6 ">
                                    <label for="">เลือกรายการสินค้า</label>
                                    <div class="card boder-0 ">
                                        <div class="card-body">
                                            <?php
                                            $num = count($productm);
                                            $j = 0;
                                            $rowid = 0;
                                            for ($i = 0; $i < $num; $i += 3) {
                                            ?>
                                                <div class="form-check">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <?php if ($j < $num) { ?>
                                                                    <div class="col-4"><input type="checkbox" name="product[]" id="row<?= $rowid; ?>" checked class="chkper" value="<?= $productm[$i]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $productm[$i]->PRODUCT_NAME; ?></label>
                                                                    </div>
                                                                <?php $j++;
                                                                }
                                                                $rowid++; ?>
                                                                <?php if ($j < $num) { ?>

                                                                    <div class="col-4">
                                                                        <input type="checkbox" name="product[]" checked id="row<?= $rowid; ?>" class="chkper" value="<?= $productm[$i + 1]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $productm[$i + 1]->PRODUCT_NAME; ?></label>
                                                                    </div>
                                                                <?php $j++;
                                                                }
                                                                $rowid++; ?>
                                                                <?php if ($j < $num) { ?>

                                                                    <div class="col-4">
                                                                        <input type="checkbox" name="product[]" id="row<?= $rowid; ?>" checked class="chkper" value="<?= $productm[$i + 2]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $productm[$i + 2]->PRODUCT_NAME; ?></label>
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
                                            <?php
                                            $k = 0;
                                            $num2 = count($product);
                                            for ($i = 0; $i < $num2; $i += 3) {
                                                //echo $product[$i]->PRODUCT_NAME; 
                                            ?>
                                                <div class="form-check">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <?php if ($k < $num2) { ?>

                                                                    <div class="col-4"><input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i]->PRODUCT_NAME; ?></label>
                                                                    </div>
                                                                <?php $k++;
                                                                }
                                                                $rowid++; ?>
                                                                <?php if ($k < $num2) { ?>
                                                                    <div class="col-4">
                                                                        <input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i + 1]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i + 1]->PRODUCT_NAME; ?></label>
                                                                    </div>
                                                                <?php $k++;
                                                                }
                                                                $rowid++; ?>
                                                                <?php if ($k < $num2) { ?>
                                                                    <div class="col-4">
                                                                        <input type="checkbox" name="product[]" id="row<?= $rowid; ?>" class="chkper" value="<?= $product[$i + 2]->PRODUCT_ID ?>">
                                                                        <label class="form-check-label" for="row<?= $rowid; ?>"><?= $product[$i + 2]->PRODUCT_NAME; ?></label>
                                                                    </div>
                                                                <?php $k++;
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
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<script>
    $(document).ready(function() {
        var typePromotion = $('#typePromotion').val();
        if (typePromotion == 0) {
            $('#showDetail').hide();
            // console.log(typePromotion);
        } else {
            $('#showDetail').show();
            // console.log(typePromotion);

        }

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

  
    });
</script>