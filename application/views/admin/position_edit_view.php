<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">แก้ไขตำแหน่ง</h3>
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
                    <form action="<?= site_url('admin/position/updatePosition') ?>" method="POST" >
                        <?php foreach ($oldPos as $row) : ?>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6 " id="rowPositionName">
                                    <label>ชื่อตำแหน่ง </label>
                                    <input type="text" name="positionName" class="form-control" id="positionName" value="<?= $row->POSITION_NAME ?>" required>
                                    <input type="hidden" name="oldPositionName" id="oldPositionName" value="<?= $row->POSITION_NAME ?>">
                                    <input type="hidden" name="positionID" value="<?= $row->POSITION_ID ?>">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm col-md col-xl-6  ">
                                    <label>แผนก </label>
                                    <select name="departmentID" class="form-control" id="departmentID" required>
                                        <option value="" selected disabled>กรุณาเลือกแผนก</option>
                                        <?php foreach ($department as $row2) : ?>
                                            <option value="<?= $row2->DEPARTMENT_ID; ?>" <?php if ($row->DEPT_ID == $row2->DEPARTMENT_ID) echo 'selected'; ?>><?= $row2->DEPARTMENT_NAME; ?></option>
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
                                                <a href="<?= site_url('admin/position/'); ?>" class="btn btn-danger ">ยกเลิก</a>
                                            </div>
                                            <div class="col">
                                                <input id="btn_update" class="btn btn-success " type="submit" value="บันทึก">
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var departmentId;
        var positionName;
        var oldPositionName;

        $('#btn_update').click(function() {
            if ($('input[name="positionName"]').hasClass('idFalse')) {
                alert('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }

        });

        $('#departmentID').change(function() {
            departmentId = $(this).val();
            positionName = $('#positionName').val();
            oldname = $('#oldPositionName').val();
            console.log(oldname);
            $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameUpdate') ?>",
                method: "POST",
                data: {
                    departmentId: departmentId,
                    positionName: positionName,
                    oldPositionName: oldname
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="positionName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        $('#rowPositionName').append('<br id="brdept">');
                        $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                    } else {
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        $('input[name="positionName"]').removeClass('idFalse');
                    }
                }
            });
        });

        $('#positionName').focusout(function() {
            departmentId = $('#departmentID').val();
            positionName = $(this).val();
            oldname = $('#oldPositionName').val();
            console.log(oldname);
            $.ajax({
                url: "<?= site_url('admin/position/checkPositionNameUpdate') ?>",
                method: "POST",
                data: {
                    departmentId: departmentId,
                    positionName: positionName,
                    oldPositionName : oldname
                },
                success: function(data) {
                    if (data != 0) {
                        $('input[name="positionName"]').addClass('idFalse');
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        $('#rowPositionName').append('<br id="brdept">');
                        $('#rowPositionName').append(' <div class="alert alert-danger" role="alert" id="alertidcard">มีตำแหน่งนี้ในแผนกแล้ว</div>');
                    } else {
                        $('#alertidcard').remove();
                        $('#brdept').remove();
                        $('input[name="positionName"]').removeClass('idFalse');
                    }
                }
            });
        })
    });
</script>