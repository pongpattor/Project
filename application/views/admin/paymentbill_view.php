<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "THSarabun";
            font-size: 18pt;
        }
    </style>
</head>

<body >
    <?php foreach ($HeadReceipt as $row) { ?>
        <div style="text-align:center">
            <img src="<?= base_url('assets/image/logo.jpg') ?>" width="150px" height="100px" alt="">
        </div>
        <div style="text-align:center;">
            ซ.ลาดพร้าว87 แยก 4 <br> แขวงคลองเจ้าคุณสิงห์ เขตวังทองหลอง กรุงเทพมหานคร
        </div>
        <hr>
        <div>
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td>วันที่ <?= $row->RECEIPT_DATE; ?></td>
                        <?php $time = str_replace(':', '.', $row->RECEIPT_TIMES); ?>
                        <td>เวลา <?= $time . ' น.'; ?></td>
                    </tr>
                    <tr>
                        <td>เลขที่ใบเสร็จ <?= $row->RECEIPT_ID; ?></td>
                        <td>พนักงาน <?= $row->FULLNAME; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>

        <div>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">สินค้า</th>
                        <th>จำนวน</th>
                        <th style="text-align: right;">ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($BodyReceipt as $row2) :  ?>
                        <?php
                        $karaokeuseType = '';
                        $orderName = '';
                        if ($row2->DTREC_TYPEORDER == '1') {
                            $orderName = $row2->PRODUCT_NAME;
                        } else  if ($row2->DTREC_TYPEORDER == '2') {
                            $orderName = $row2->PROMOTIONSET_NAME;
                        } else {
                            $orderName = $row2->SEAT_NAME;
                            if ($row2->KARADTREC_USETYPE == '1') {
                                $karaokeuseType = '(เหมา)';
                            } else {
                                $karaokeuseType = '(รายชั่วโมง)';
                            }
                        }

                        ?>
                        <tr>
                            <td style="width: 50%;"><?= $orderName . ' ' . $karaokeuseType; ?></td>
                            <td style="width: 25%; text-align: center;"><?= number_format($row2->DTREC_AMOUNT); ?></td>
                            <td style="width: 25%; text-align: right;"><?= number_format($row2->DTREC_PRICEALL, 2); ?></td>
                        </tr>
                    <?php endforeach;  ?>
                </tbody>
            </table>
        </div>
        <hr>
        <div>
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 80%; text-align: right;"><?= 'ราคาวม'; ?></td>
                        <td style="width: 20%; text-align: right;"><?= number_format(($row->RECEIPT_PRICETOTAL - $row->RECEIPT_VAT), 2); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 80%; text-align: right;"><?= 'Vat(7%)'; ?></td>
                        <td style="width: 20%; text-align: right;"><?= number_format($row->RECEIPT_VAT, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 80%; text-align: right;"><?= 'ราคาสุทธิ'; ?></td>
                        <td style="width: 20%; text-align: right;"><?= number_format($row->RECEIPT_PRICETOTAL, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 80%; text-align: right;"><?= 'รับเงิน'; ?></td>
                        <td style="width: 20%; text-align: right;"><?= number_format($row->RECEIPT_PAYALL, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 80%; text-align: right;"><?= 'ทอนเงิน'; ?></td>
                        <td style="width: 20%; text-align: right;"><?= number_format($row->RECEIPT_PAYCHANGE, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr style="height: 2px;color: black;">
    <?php } ?>
    <!-- <script>
    function TEXT(){
        var x = "Total Height: " + screen.height;
        console.log(x);
    }
        setInterval(TEXT,1000);
    </script> -->
</body>

</html>