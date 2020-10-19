<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขรายการรับวัตถุดิบ</h3>
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
                    <form action="<?= site_url('admin/receiveIngredient/UpdateReceiveIngredient') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <table style="width:100%;" id="tableReceive">
                                    <tbody id="bodyReceive">
                                        <tr>
                                            <td>ชื่อรายการวัตถุดิบ</td>
                                            <td>ราคาวัตถุดิบ</td>
                                        </tr>
                                        <?php $rowid = 1;
                                        foreach ($ingredient as $row) { ?>
                                            <tr id="row<?= $rowid; ?>">
                                                <td><input type="text" class="form-control" name="ReceiveName[]" value="<?= $row->INGREDIENT_NAME; ?>" required></td>
                                                <td><input type="number" class="form-control" name="ReceivePrice[]" value="<?= $row->INGREDIENT_PRICE; ?>" required min="0" max="9999999.99" step="0.01"></td>
                                                <?php if ($rowid == 1) { ?>
                                                    <td><button type="button" class="btn btn-success" id="addData"><i class="fa fa-plus"></i></button></td>
                                                <?php } else { ?>
                                                    <td><button type="button" id="<?= $rowid; ?>" class="btn btn-danger btn-remove">
                                                            <i class="fa fa-minus"></i></button></td>
                                                <?php } ?>
                                                <input type="hidden" name="receiveID" value="<?= $row->INGREDIENT_RECEIVE_ID; ?>">
                                            </tr>
                                        <?php $rowid++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/receiveIngredient/'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_update" class="btn btn-success col-7" type="submit" value="บันทึก">
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
        var id = $('tbody tr:last-child').attr('id');
        id = id.substr(3);
        var row = parseInt(id);
        $('#addData').click(function() {
            row++;
            var txt = `<tr id="row${row}">
                            <td><input type="text" class="form-control" name="ReceiveName[]" id="" required ></td>
                            <td><input type="number" class="form-control" name="ReceivePrice[]" id="" required  min="0"  max="9999999.99"  step="0.01"></td>
                            <td><button type="button" id="${row}" class="btn btn-danger btn-remove">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>`;
            $('#bodyReceive').append(txt);
            $('.btn-remove').on('click', function() {
                var btn_del = $(this).attr("id");
                $('#row' + btn_del).remove();
                console.log(btn_del);
            });
        });



        $('.btn-remove').on('click', function() {
            var btn_del = $(this).attr("id");
            $('#row' + btn_del).remove();
            console.log(btn_del);
        });



        function chkReceiveName() {
            var nameList = [];
            var breaker;

            $('input[type="text"]').each(function() {
                if ($(this).val == "") {
                    nameList.push($(this).val())
                } else {
                    nameList.push($(this).val())
                }
            });
            // console.log(nameList);
            for (var i = 0; i < nameList.length; i++) {
                for (var j = 0; j < nameList.length; j++) {
                    if (i == j) {
                        // console.log('continue');
                        continue;
                    } else if (nameList[i] == nameList[j]) {
                        // console.log(i + " :" + nameList[i] + ": " + nameList[j] + ': Found same');
                        $('#alertReceive').remove();
                        $('#tableReceive').append('<p style="color:red" id="alertReceive">กรุณาอย่ากรอกรายการรับซ้ำ</p>');
                        $('#btn_update').addClass('nameFalse');
                        breaker = 1;
                        break;
                    }
                }
                if (breaker == 1) {
                    // console.log('if break');
                    break;
                } else {
                    // console.log('else break');
                    $('#btn_update').removeClass('nameFalse');
                    $('#alertReceive').remove();
                    break;
                }
            }
        }

        $('#btn_update').on('click', function() {
            if (confirm('ยืนยันการแก้ไขข้อมูลรับวัตถุดิบ')) {
                chkReceiveName();
                if ($('#btn_update').hasClass('nameFalse')) {
                    // console.log('btn_regis')
                    alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                    return false;
                }
                else{
                    alert('แก้ไขข้อมูลรับวัตถุดิบเสร็จสิ้น');
                }
            }
            else{
                return false;
            }
        });
    });
</script>