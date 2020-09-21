<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มตำแหน่ง</h3>
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
                    <form action="<?= site_url('admin/position/insertPos') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  " id="rowPositionName">
                                <label>ชื่อตำแหน่ง </label>
                                <input type="text" name="positionName" id="positionName" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 ">
                                <label>แผนก </label>
                                <select name="departmentID" id="departmentID" class="form-control" required>
                                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                    <?php foreach ($department as $row) : ?>
                                        <option value="<?= $row->DEPARTMENT_ID; ?>"><?= $row->DEPARTMENT_NAME; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/position/'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success col-7" type="submit" value="เพิ่ม">
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
        // var departmentId;
        // var positionName;
        // $('.backPage').click(function() {
        //     let positionName = $('#positionName').val();
        //     if (positionName != '') {
        //         if (confirm('คุณต้องการยกเลิกใช่หรือไม่')) {
        //             return true;
        //         } else {
        //             return false;
        //         }
        //     }

        // });

        // $('#btn_regis').click(function(e) {
        //     e.preventDefault();
        //     departmentId = $('#departmentID').val();
        //     positionName = $('#positionName').val();
        //     $.ajax({
        //         url: "<?= site_url('admin/position/checkPositionNameInsert') ?>",
        //         method: "POST",
        //         data: {
        //             departmentId: departmentId,
        //             positionName: positionName
        //         },
        //         success: function(data) {
        //             if (data != 0) {
        //                 $('#alertidcard').remove();
        //                 $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');
        //                 alert('กรุณากรอกข้อมูลให้ถูกต้อง');

        //             } else {
        //                 $('#alertidcard').remove();
        //             }
        //         }
        //     });
        // });

        // $('#positionName').on('input',function(){
        //     console.log('hello');
        //     $('#alertidcard').remove();

        // })

        $('#btn_regis').click(function() {
            if ($('input[name="positionName"]').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }

        });

        $('#departmentID').change(function() {
            departmentId = $(this).val();
            positionName = $('#positionName').val();
            $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameInsert') ?>",
                method: "POST",
                data: {
                    departmentId: departmentId,
                    positionName: positionName
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="positionName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        // $('#rowPositionName').append('<br id="brdept">');
                        // $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                        $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');

                    } else {
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        $('input[name="positionName"]').removeClass('idFalse');
                    }
                }
            });
        });

        $('#positionName').focusout(function() {
            departmentId = $('#departmentID').val();
            positionName = $(this).val();
            $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameInsert') ?>",
                method: "POST",
                data: {
                    departmentId: departmentId,
                    positionName: positionName
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="positionName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        // $('#rowPositionName').append('<br id="brdept">');
                        // $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                        $('#rowPositionName').append(' <p style="color:red" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</p>');
                    } else {
                        $('#alertidcard').remove();
                        // $('#brdept').remove();
                        $('input[name="positionName"]').removeClass('idFalse');
                    }
                }
            });
        });
    });
</script>