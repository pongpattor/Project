<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มเนื้อสัตว์</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container" id="bodyCard">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <form action="<?= site_url('admin/meat/') ?>" method="POST" id="formMeat">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6 " id="rowMeat">
                                <label>ชื่อเนื้อสัตว์</label>
                                <input type="text" name="meatName" id="meatName" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/meat/'); ?>" class="btn btn-danger">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input id="btn_regis" class="btn btn-success" type="submit" value="  เพิ่ม  ">
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

        // TEST
        // $('#btn_regis').on('click', function(e) {
        //     e.preventDefault();
        //     var meatName = $('#meatName').val();
        //     console.log(meatName);
        //     $.ajax({
        //         url: "<?= site_url('admin/product/checkMeatName') ?>",
        //         method: "POST",
        //         data: {
        //             meatName: meatName
        //         },
        //         success: function(data) {
        //             if (data != 0) {
        //                 // alert('กรุณากรอกข้อมูลให้ถูกต้อง');
        //                 // $('input[name="meatName"]').addClass('idFalse');
        //                 $('#alertidcard').remove();
        //                 $('#rowMeat').append(' <p style="color:red" id="alertidcard">ชื่อเนื้อชนิดนี้มีในระบบแล้ว</p>');
        //                 console.log(data);
        //             } else {
        //                 $('#alertidcard').remove();
        //                 console.log(data);
        //                 $('#formMeat').submit();
        //                 // $('input[name="meatName"]').removeClass('idFalse');
        //             }
        //         },
        //     });
        // }); 


        $('#formMeat').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url :"<?= site_url('admin/product/test')?>",
                method : "POST",
                data : $('#formMeat').serialize(),
                success:function(data){
                        console.log(data);
                }
            })
        });
        
        // $('#btn_regis').click(function() {
        //     var meatName = $('#meatName').val();
        //     $.ajax({
        //         url: "<?= site_url('admin/product/checkMeatName') ?>",
        //         method: "POST",
        //         data: {
        //             meatName: meatName
        //         },
        //         success: function(data) {
        //             if (data != 0) {
        //                 $('#alertidcard').remove();
        //                 alert('กรุณากรอกข้อมูลให้ถูกต้อง');
        //                 $('#rowMeat').append(' <p style="color:red" id="alertidcard">ชื่อเนื้อสัตว์นี้ได้ถูกใช้ไปแล้ว</p>');        
        //                 return false;  
        //             } 
        //         }
        //     });
        // });


        $('#meatName').on('focusout', function() {
            // var meatName = $('#meatName').val();
            // $.ajax({
            //     url: "<?= site_url('admin/product/checkMeatName') ?>",
            //     method: "POST",
            //     data: {
            //         meatName: meatName
            //     },
            //     success: function(data) {
            //         if (data != 0) {
            //             $('input[name="meatName"]').addClass('idFalse');
            //             $('#alertidcard').remove();
            //             alert('กรุณากรอกข้อมูลให้ถูกต้อง');
            //             $('#rowMeat').append(' <p style="color:red" id="alertidcard">ชื่อแผนกนี้ได้ถูกใช้ไปแล้ว</p>');          
            //         } else {
            //             $('#alertidcard').remove();
            //             // $('#brdept').remove();
            //             $('input[name="meatName"]').removeClass('idFalse');
            //         }
            //     }
            // });
        });
    });
</script>