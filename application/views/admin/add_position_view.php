<h1 class="mt-4">เพิ่มแผนก</h1>
<br>
<div>
    <form action="<?= site_url('admin/admin/insertPos') ?>" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>ชื่อตำแหน่ง </label>
                <input type="text" name="positionName" class="form-control">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <label>แผนก </label>
                <select name="departmentID" class="form-control">
                    <option value="" selected disabled>กรุณาเลือกแผนก</option>
                    <?php foreach($department as $row):?>
                        <option value="<?=$row->DEPARTMENT_ID;?>"><?=$row->DEPARTMENT_NAME;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-5 ">
                <center>
                    <div class="input-group">
                        <div class="col">
                            <a href="<?= site_url('admin/admin/position'); ?>" class="btn btn-danger col-7">ยกเลิก</a>
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