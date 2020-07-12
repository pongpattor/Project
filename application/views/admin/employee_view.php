<h1 class="mt-4">พนักงาน</h1>
<div class="row ">
    <div class="col d-flex flex-row-reverse">
        <div class="p-2"><a href="<?= site_url('admin/admin/addEmployee'); ?>" class="nav-link btn btn-info">เพิ่มพนักงาน</a></div>
    </div>

</div>
<table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center;">รหัสประจำตัวพนักงาน
            </th>
            <th style="text-align: center;">ชื่อ
            </th>
            <th style="text-align: center;">นามสกุล
            </th>
            <th style="text-align: center;">อีเมล
            </th>
            <th style="text-align: center;">เบอร์โทรศัพท์
            </th>
            <th style="text-align: center;">ตำแหน่ง
            </th>
            <th style="text-align: center;">เงินเดือน
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employee as $row) : ?>
            <tr id="<?= $row->ID ?>">
                <td class="align-middle" style="text-align: center;"><?= $row->ID ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->FIRSTNAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->LASTNAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->EMAIL ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->TEL ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->POSITION_NAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->SALARY ?></td>
                <td>
                    <center>
                        <a href="<?= site_url("admin/admin/editEmployee/$row->ID") ?>"><button class="btn btn-warning col-5" style="text-align: center;">แก้ไข</button></a>
                        <button class="btn btn-danger col-5 delete" style="text-align: center;" value="<?= $row->ID; ?>">ลบ</button>
                    </center>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            var ID = $(this).parents("tr").attr("id");
            var result = confirm(`ยืนยันการลบ ${ID}`);
           if(result){
               $.ajax({
                url : "<?= site_url('admin/admin/deleteEmployee')?>",
                method : "POST",
                data : {empID : ID},
                success:function(){
                    alert(`ลบ ${ID} เสร็จสิ้น`);
                    location.reload();
                }
               });
           }

        

        });
    });
</script>