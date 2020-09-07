<h1 class="mt-4">เพิ่มรายการรับวัตถุดิบ</h1>
<br>
<div>
    <form action="<?= site_url('admin/admin/InsertReceiveIngredient') ?>" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <div class="col-sm col-md col-xl-6  ">
                <table style="width:100%;" id="tableReceive">
                    <tbody>
                        <tr>
                            <td>ชื่อรายการวัตถุดิบ</td>
                            <td>ราคาวัตถุดิบ</td>
                        </tr>
                        <tr id="row1">
                            <td><input type="text" class="form-control" name="ReceiveName[]" id=""></td>
                            <td><input type="number" class="form-control" name="ReceivePrice[]" id=""></td>
                            <td><button type="button" class="btn btn-success" id="addData"><i class="fa fa-plus"></i></button></td>
                        </tr>
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

    <br>
</div>
<br>
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
            });
        });
    });
</script>