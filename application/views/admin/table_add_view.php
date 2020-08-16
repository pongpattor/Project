<h1 class="mt-4">เพิ่มพนักงาน</h1>
<br>
<div class="container">
    <form action="<?= site_url('admin/admin/insertEmp') ?>" method="POST" enctype="multipart/form-data">

        <div class="row justify-content-center">
            <div class="col-sm col-md col-xl-6">
                <label>รูปโต๊ะ</label><br>
                <input type="file" name="" id="">
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-sm col-md col-xl-6">
                <center>
                    <div class="input-group">
                        <div class="col">
                            <a href="<?= site_url('admin/admin/employee'); ?>" class="btn btn-danger  ">ยกเลิก</a>
                        </div>
                        <div class="col">
                            <input id="btn_regis" class="btn btn-success " type="submit" value="  เพิ่ม  " >
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </form>
    <br>
</div>
<br>