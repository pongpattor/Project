<div>
    <h1 class="alert alert-info" style="color: black;">Customer</h1>
</div>

<div class="row ">
    <div class="col">
    </div>

</div>
<table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center;">USERNAME
            </th>
            <th style="text-align: center;">FIRSTNAME
            </th>
            <th style="text-align: center;">LASTNAME
            </th>
            <th style="text-align: center;">EMAIL
            </th>
            <th style="text-align: center;">TEL
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customer as $row) : ?>
            <tr>
                <td class="align-middle" style="text-align: center;"><?= $row->USERNAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->FIRSTNAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->LASTNAME ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->EMAIL ?></td>
                <td class="align-middle" style="text-align: center;"><?= $row->TEL ?></td>
                <td>
                    <center>
                        <button class="btn btn-info col-sm-4">ดูข้อมูล</button>
                        <button class="btn btn-danger col-sm-4">ลบ</button>
                    </center>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>