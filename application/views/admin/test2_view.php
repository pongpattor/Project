<br>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card boder-0 shadow-lg">
                <div class="card-body">
                    <h3 class="d-inline">เพิ่มสูตรการผลิต</h3>
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
                    <form method="POST" id="addRecipeForm">
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal">
                                    เลือกสินค้า
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="productModalLabel">สินค้า</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table id="productTable" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัส</th>
                                                            <th>ชื่อ</th>
                                                            <th>เลือก</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $rowProduct = 1;
                                                        foreach ($product as $row) : ?>
                                                            <tr id="rowProduct<?= $rowProduct ?>">
                                                                <td><?= $row->PRODUCT_ID; ?></td>
                                                                <td><?= $row->PRODUCT_NAME; ?></td>
                                                                <td><button type="button" value="<?= $row->PRODUCT_ID ?>" class="selectProduct btn btn-info" data-dismiss="modal">เลือก</button></td>
                                                            </tr>
                                                        <?php $rowProduct++;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7 " id="recipeProduct">
                                <input type="text" name="" id="" class="form-control" disabled>
                                <span id="productError" style="color: red;"> </span>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ingredientModal">
                                    เลือกวัตถุดิบ
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="ingredientModal" tabindex="-1" role="dialog" aria-labelledby="ingredientModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ingredientModalLabel">วัตถุดิบ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table id="ingredientTable" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัส</th>
                                                            <th>ชื่อ</th>
                                                            <th>เลือก</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $rowIngredient = 1;
                                                        foreach ($ingredient as $row) : ?>
                                                            <tr id="row<?= $rowIngredient ?>">
                                                                <td><?= $row->INGREDIENT_ID; ?></td>
                                                                <td><?= $row->INGREDIENT_NAME; ?></td>
                                                                <td><button type="button" value="<?= $row->INGREDIENT_ID ?>" class="selectIngredient btn btn-info">เลือก</button></td>
                                                            </tr>
                                                        <?php $rowIngredient++;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-7">
                                <table style="width:100%" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr class="d-flex">
                                            <th style="text-align: center;" class="align-middle col-5">วัตถุดิบ</th>
                                            <th style="text-align: center;" class="align-middle col-5">ความสำคัญ</th>
                                            <th style="text-align: center;" class="align-middle col-2">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyIngredient">
                                    </tbody>
                                </table>
                                <span id="ingredientError" style="color: red;"> </span>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-sm col-md col-xl-6  ">
                                <center>
                                    <div class="input-group">
                                        <div class="col">
                                            <a href="<?= site_url('admin/recipe/'); ?>" class="btn btn-danger btn-xs" id="btn_cancel">ยกเลิก</a>
                                        </div>
                                        <div class="col">
                                            <input class="btn btn-success btn-xs" type="submit" value="  เพิ่ม  ">
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
        $('#ingredientTable').DataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ]
        });

        $('#productTable').DataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ]
        });

        $('.delete').on('click', function(e) {
            var del = $(this).val();
            alert(del);
        });

        $('.selectProduct').on('click', function() {
            var rowid = $(this).parents("tr").attr("id");
            var id = $('#' + rowid + ' td').html();
            var name = $('#' + rowid + ' td:nth-child(2)').html();
            var txt = `<input type="text"  value="${name}"  class="form-control" disabled>
                        <input type="hidden" name="recipeProductID" val="${id}">
                        <span id="productError" style="color: red;"> </span>`;

            $('#recipeProduct').html(txt);

        });



        var rowIngredient = 1;
        $('.selectIngredient').on('click', function(e) {
            var rowid = $(this).parents("tr").attr("id");
            var id = $('#' + rowid + ' td').html();
            var name = $('#' + rowid + ' td:nth-child(2)').html();
            var txt = ` <tr id="row${rowIngredient}" class="d-flex">
                            <td style="text-align: center;" class="align-middle col-5 ">
                            <input type="text"  value="${name}"  class="form-control" disabled>
                            <input type="hidden" name="recipeIngredient[]" val="${id}">
                            </td>
                            <td style="text-align: center;" class="align-middle col-5">
                                <select name="ingredientImportant[]" class="form-control" required>
                                        <option value="" selected disabled>กรุณาเลือกความสำคัญวัตถุดิบ</option>
                                        <option value="1">สำคัญ</option>
                                        <option value="0">ไม่สำคัญ</option>
                                </select>
                            </td>
                            <td style="text-align: center;" class="align-middle col-2">
                                <button type="button" id="${rowIngredient}" class="btn btn-danger btn-remove"><i class="fa fa-minus"></i></button>
                            </td>
                        </tr>`;
            console.log(txt);
            $('#bodyIngredient').append(txt);
            rowIngredient++;
            $('.btn-remove').on('click', function() {
                var btn_del = $(this).attr("id");
                $('#row' + btn_del).remove();
            });
        });
    });
</script>