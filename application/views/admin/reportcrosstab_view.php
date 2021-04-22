<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายงานปริมาณยอดขายประจำปี </h3>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <form action="<?= site_url('admin/report/reportCrossTab') ?>" method="GET" id="reportCrossTabForm">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label for="year" class="col col-form-label">วันเริ่มต้น</label>
                                                        </div>
                                                        <div class="col">
                                                            <?php $year = date('Y'); ?>
                                                            <select name="year" id="year" class="form-control " required>
                                                                <option value="" disabled selected>กรุณาเลือก</option>
                                                                <?php for ($i = 0; $i < 10; $i++) : ?>
                                                                    <option value="<?= $year ?>" <?php
                                                                                                    if ($this->input->get('year') == $year) {
                                                                                                        echo 'selected';
                                                                                                    }
                                                                                                    ?>><?= $year ?></option>
                                                                <?php $year = $year - 1;
                                                                endfor; ?>

                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-secondary float-left">ค้นหา <i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card  shadow-lg text-center h-100">
                            <div class="card-body">
                                <h2 class="d-inline">สินค้า</h2>
                                <div class="table-responsive">
                                    <table id="crosstabtable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">สินค้า/เดือน</th>
                                                <th style="text-align: center;">มกราคม</th>
                                                <th style="text-align: center;">กุมภาพันธ์</th>
                                                <th style="text-align: center;">มีนาคม</th>
                                                <th style="text-align: center;">เมษายน</th>
                                                <th style="text-align: center;">พฤษภาคม</th>
                                                <th style="text-align: center;">มิถุนายน</th>
                                                <th style="text-align: center;">กรกฎาคม</th>
                                                <th style="text-align: center;">สิงหาคม</th>
                                                <th style="text-align: center;">กันยายน</th>
                                                <th style="text-align: center;">ตุลาคม</th>
                                                <th style="text-align: center;">พฤศจิกายน</th>
                                                <th style="text-align: center;">ธันวาคม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                foreach ($report as $row) : ?>
                                                    <tr>
                                                        <td class="align-middle " style="text-align: center;"><?= $row->PRODUCT_NAME ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Jan, 2);  ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Feb, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Mar, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Apr, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->May, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Jun, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Jul, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Aug, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Sep, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Oct, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Nov, 2); ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= number_format($row->Dec, 2); ?></td>
                                                    </tr>
                                            <?php
                                                endforeach;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#crosstabtable').dataTable({
                "lengthMenu": [
                    [10, 25, -1],
                    [10, 25, "All"]
                ],
                "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                }],
                "language": {
                    "emptyTable": "ไม่มีข้อมูล",
                    "zeroRecords": "ไม่มีข้อมูลที่คุณค้นหา"
                }
            });

        });
    </script>