<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table id="customerTable" class="display">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>ชื่อสกุล</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer as $row) : ?>
                            <tr>
                                <td><?= $row->CUSTOMER_ID; ?></td>
                                <td><?= $row->CUSTOMER_FIRSTNAME . ' ' . $row->CUSTOMER_LASTNAME; ?></td>
                                <td><button value="<?= $row->CUSTOMER_ID ?>" class="delete btn btn-danger">click</button></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ]
        });

        $('.delete').on('click', function(e) {
            var del = $(this).val();
            alert(del);
        });
    });
</script>