<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <div class="row ">
                    <div class="col">
                        <h3 class="d-inline"><a href="<?= site_url('admin/kitchen/kitchenFood') ?>">ครัวอาหาร</a>/<?= $title ?> </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row ">
    <div class="col-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <form action="<?= site_url('admin/kitchen/changeIngredient') ?>" method="GET">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col">
                                    <div class="row form-group">
                                        <div class="col">
                                            <div class="col-7 input-group">
                                                <input type="text" class="form-control" name="search" placeholder="กรุณากรอกคำที่ต้องการค้นหา">
                                                <div class="input-group-append">
                                                    <button class="input-group-text"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- <?php
                        echo '<div class="row">';
                        echo '<div class="col-12">';
                        echo '<div class="row">';
                        echo '<div class="col-8">'; ?>
                <?php if ($this->input->get('search'))  echo '<h4>คำที่คุณค้นหาคือ "' . $this->input->get('search') . '"</h4>'; ?>
                <?php echo '</div>';
                echo '<div class="col-4">';
                echo '<p class="float-right">จำนวน ' . $total . ' ประเภท</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                ?> -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;">ชื่อวัตถุดิบ</th>
                                        <th style="text-align: center;">สถานะ</th>
                                        <th style="text-align: center;">มี</th>
                                        <th style="text-align: center;">หมด</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rowi = 1;
                                    foreach ($ingredient as $row) { ?>
                                        <tr id="<?= $row->INGREDIENT_ID; ?>" class="bgtable">
                                            <td class="align-middle" style="text-align: center;"><?= $row->INGREDIENT_NAME; ?></td>
                                            <td class="align-middle" style="text-align: center;"><?= $row->INGREDIENT_ACTIVEE; ?></td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php if ($row->INGREDIENT_ACTIVE == '2') { ?>
                                                    <button type="button" class="btn btn-info haveIngredient">มี</button>
                                                <?php } ?>
                                            </td>
                                            <td class="align-middle" style="text-align: center;">
                                                <?php if ($row->INGREDIENT_ACTIVE == '1') { ?>
                                                    <button type="button" class="btn btn-danger haventIngredient">หมด</button>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if ($links != null) {
                                echo $links;
                            } else { ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item active"><a class="page-link ">1</a></li>
                                    </ul>
                                </nav>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click','.haveIngredient',function(){
            var rowid = $(this).parents('tr').attr('id');
            $.ajax({
                url : "<?=site_url('admin/kitchen/haveIngredient')?>",
                method : "POST",
                data : {
                    ingredientID : rowid,
                },
                success:function(){
                    let button = `<button class="btn btn-danger haventIngredient">หมด</button>`;
                    $(`#${rowid} td:nth-child(3)`).html('');
                    $(`#${rowid} td:nth-child(4)`).html(button);
                    $(`#${rowid} td:nth-child(2)`).html('มี');
                },
            });
        });

        $(document).on('click','.haventIngredient',function(){
            var rowid = $(this).parents('tr').attr('id');
            $.ajax({
                url : "<?=site_url('admin/kitchen/haventIngredient')?>",
                method : "POST",
                data : {
                    ingredientID : rowid,
                },
                success:function(){
                    let button = `<button class="btn btn-info haveIngredient">มี</button>`;
                    $(`#${rowid} td:nth-child(3)`).html(button);
                    $(`#${rowid} td:nth-child(4)`).html('');
                    $(`#${rowid} td:nth-child(2)`).html('หมด');
                },
            });
        });

    });
</script>