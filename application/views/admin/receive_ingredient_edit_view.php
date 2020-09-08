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
                    <form action="<?= site_url('admin/admin/UpdateReceiveIngredient') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <table style="width:100%;" id="tableReceive">
                                    <tbody>
                                        <tr>
                                            <td>ชื่อรายการวัตถุดิบ</td>
                                            <td>ราคาวัตถุดิบ</td>
                                        </tr>
                                        <?php $rowid = 1;
                                        foreach ($ingredient as $row) { ?>
                                            <tr id="row<?= $rowid; ?>">
                                                <td><input type="text" class="form-control" name="ReceiveName[]" value="<?= $row->INGREDIENT_NAME; ?>"></td>
                                                <td><input type="number" class="form-control" name="ReceivePrice[]" value="<?= $row->INGREDIENT_PRICE; ?>"></td>
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
                                            <a href="<?= site_url('admin/admin/receiveIngredient'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success col-7" type="submit" value="บันทึก">
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



<script>
    $(document).ready(function() {
        var row = 1;
        $('#addData').click(function() {
            row++;
            var txt = `<tr id="row${row}">
                            <td><input type="text" class="form-control" name="ReceiveName[]" id=""></td>
                            <td><input type="number" class="form-control" name="ReceivePrice[]" id=""></td>
                            <td><button type="button" id="${row}" class="btn btn-danger btn-remove">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>`;
            $('#tableReceive').append(txt);
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
    });
</script>