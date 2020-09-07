<div class="row">
    <div class="col-sm col-md">
        <h1>รับวัตถุดิบ</h1>
    </div>
</div>

<div>
    <div class="table-responsive row justify-content-center">
        <table>
            <tr>
                <td>
                    <div class="input-group mb-3 col-sm-6 col-md-6">
                        <input type="text" class="form-control" name="Searchtxt">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </td>
                <td><a href="<?= site_url('admin/admin/addReceiveIngredient'); ?>" class="nav-link btn btn-info"><i class="fa fa-plus-circle"></i></a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="text-align: center;">Lot</th>
                                <th style="text-align: center;">วันเวลาที่เข้า</th>
                                <th style="text-align: center;">ราคารวม</th>
                                <th style="text-align: center;  ">แก้ไข</th>
                                <th style="text-align: center;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</div>