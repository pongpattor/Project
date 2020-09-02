<h1 class="mt-4">เพิ่มแผนก</h1>
<br>
<div>
    <form action="<?= site_url('admin/admin/insertPos') ?>" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <div class="col-sm col-md col-xl-6  ">
                <label>ชื่อตำแหน่ง </label>
                <input type="text" name="positionName" id="positionName" class="form-control">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm col-md col-xl-6 ">
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
            <div class="col-sm col-md col-xl-6  ">
                <center>
                    <div class="input-group">
                        <div class="col">
                            <a href="<?= site_url('admin/admin/position'); ?>" class="btn btn-danger col-7 backPage">ยกเลิก</a>
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
    $(document).ready(function(){
        $('.backPage').click(function(){
            let positionName = $('#positionName').val();
            if(positionName != ''){
            if(confirm('คุณต้องการยกเลิกใช่หรือไม่')){
                return true;
            }
            else{
                return false;
            }}
            
        });
    });
</script>