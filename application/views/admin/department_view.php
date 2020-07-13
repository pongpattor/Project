<h1 class="mt-4">พนักงาน</h1>
<div class="row ">
    <div class="col d-flex flex-row-reverse">
        <div class="p-2"><a href="<?= site_url('admin/admin/addDepartment'); ?>" class="nav-link btn btn-info">เพิ่มแผนก</a></div>
    </div>
</div>

<table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center;">รหัสแผนก
            </th>
            <th style="text-align: center;">ชื่อแผนก
            </th>
            <th style="text-align: center;">หัวหน้าแผนก
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php  ?>
        <tr>
            <td class="align-middle" style="text-align: center;">ID</td>
            <td class="align-middle" style="text-align: center;">NAME</td>
            <td class="align-middle" style="text-align: center;">HEAD</td>
            <td>
                <center>
                    <button class="btn btn-warning col-5 edit" style="text-align: center;">แก้ไข</button>
                    <button class="btn btn-danger col-5 delete" style="text-align: center;">ลบ</button>
                </center>
            </td>
        </tr>
        <?php  ?>
    </tbody>
</table>
