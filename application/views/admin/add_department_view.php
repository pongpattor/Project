<h1 class="mt-4"></h1>
<br>
<form action="<?= site_url('admin/admin/addDepartment') ?>" method="POST" enctype="multipart/form-data">
    <div class="row justify-content-center">
        <div class="col-5 ">
            <label>ชื่อแผนก</label>
            <input type="text" name="department" class="form-control">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-5 ">
            <label>หัวหน้าแผนก </label>
            <select name="header" id="header" class="form-control">
                <option value="" selected >กรุณาเลือกหัวหน้าแผนก</option>
                <?php foreach ($employee as $row) : ?>
                    <option value="<?= $row->ID; ?>"  ><?= $row->FIRSTNAME.' '.$row->LASTNAME; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-5 ">
            <center>
                <div class="input-group">
                    <div class="col">
                        <a href="#" class="btn btn-danger">ยกเลิก</a>
                    </div>
                    <div class="col">
                        <input id="btn_regis" class="btn btn-success" type="submit" value="สมัครสมาชิก">
                    </div>
                </div>
            </center>
        </div>
    </div>
</form>
<br>

<br>