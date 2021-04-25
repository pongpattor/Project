<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายงานสรุปกำไร/ขาดทุนเมนูตามช่วงเวลา </h3>
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
                                <form action="<?= site_url('admin/report/reportProfits') ?>" method="GET" id="reportProfitsForm">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-7">
                                                    <div class="form-group row">
                                                        <div class="col-2">
                                                            <label for="dateStart" class="col col-form-label">วันเริ่มต้น</label>
                                                        </div>
                                                        <div class="col-4">

                                                            <input type="date" name="dateStart" id="dateStart" class="form-control" required value="<?php
                                                                                                                                                    if ($this->input->get('dateStart')) {
                                                                                                                                                        echo $this->input->get('dateStart');
                                                                                                                                                    }
                                                                                                                                                    ?>">
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="dateEnd" class="col col-form-label">วันสิ้นสุด</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="date" name="dateEnd" id="dateEnd" class="form-control" required required value="<?php
                                                                                                                                                            if ($this->input->get('dateEnd')) {
                                                                                                                                                                echo $this->input->get('dateEnd');
                                                                                                                                                            }
                                                                                                                                                            ?>">
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
                    <div class="col-6">
                        <div class="card  shadow-lg text-center h-100">
                            <div class="card-body">
                                <h2 class="d-inline">อาหาร</h2>
                                <div class="table-responsive">
                                    <!-- <div id="foodpiechart"></div> -->
                                    <div id="foodBarChart"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="foodReporttable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อสินค้า</th>
                                                <th style="text-align: center;">ประเภทสินค้า</th>
                                                <th style="text-align: center;">กำไร/ขาดทุน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                $no = 1;
                                                foreach ($report as $row) : ?>
                                                    <?php if ($row->TYPEPRODUCT_GROUP == '1') { ?>
                                                        <tr>
                                                            <td class="align-middle " style="text-align: center;"><?= $no ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->profitss, 2); ?></td>
                                                        </tr>
                                                    <?php $no++;
                                                    } ?>
                                            <?php
                                                endforeach;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card shadow-lg text-center h-100">
                            <div class="card-body ">
                                <h2 class="d-inline">เครื่องดื่ม</h2>
                                <div class="table-responsive">
                                    <!-- <div id="drinkpiechart"></div> -->
                                    <div id="drinkBarChart"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="drinkReporttable" class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อสินค้า</th>
                                                <th style="text-align: center;">ประเภทสินค้า</th>
                                                <th style="text-align: center;">กำไร/ขาดทุน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                $no = 1;
                                                foreach ($report as $row) : ?>
                                                    <?php if ($row->TYPEPRODUCT_GROUP == '2') { ?>
                                                        <tr>
                                                            <td class="align-middle " style="text-align: center;"><?= $no ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->TYPEPRODUCT_NAME; ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->profitss, 2); ?></td>
                                                        </tr>
                                                    <?php $no++;
                                                    } ?>
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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        <?php if ($state == true) { ?>

            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(foodBarChart);
            google.charts.setOnLoadCallback(drinkBarChart);

            function foodBarChart() {
                var data = google.visualization.arrayToDataTable([
                    ['สินค้า', 'กำไร/ขาดทุน'],
                    <?php
                    $food = '';
                    $rowfood = 0;
                    foreach ($report as $row) :
                        if ($row->TYPEPRODUCT_GROUP == '1') {
                            $food .= "['$row->PRODUCT_NAME',$row->profitss],";
                            $rowfood++;
                        }
                        if ($rowfood == 9) {
                            break;
                        }
                    endforeach;
                    echo $food;
                    ?>
                ]);
                var options = {
                    chart: {
                        title: 'กำไร/ขาดทุน',
                    },
                    bars: 'vertical' // Required for Material Bar Charts.
                };

                var chart = new google.charts.Bar(document.getElementById('foodBarChart'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }

            function drinkBarChart() {
                var data = google.visualization.arrayToDataTable([
                    ['สินค้า', 'กำไร/ขาดทุน'],
                    <?php
                    $drink = '';
                    $rowdrink = 0;
                    foreach ($report as $row) :
                        if ($row->TYPEPRODUCT_GROUP == '2') {
                            $drink .= "['$row->PRODUCT_NAME',$row->profitss],";
                            $rowdrink++;
                        }
                        if ($rowdrink == 9) {
                            break;
                        }
                    endforeach;
                    echo $drink;
                    ?>
                ]);
                var options = {
                    chart: {
                        title: 'กำไร/ขาดทุน',
                    },
                    bars: 'vertical' // Required for Material Bar Charts.
                };

                var chart = new google.charts.Bar(document.getElementById('drinkBarChart'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }

        <?php } ?>

        $(document).ready(function() {

            $('#foodReporttable').dataTable({
                "lengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "All"]
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

            $('#drinkReporttable').dataTable({
                "lengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "All"]
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

            $('#dateStart').on('change', function() {
                var datestart = $(this).val();
                $('#dateEnd').val('');
                $('#dateEnd').prop('min', datestart);
            });

            function validationForm() {
                var dateStart = $('#dateStart').val();
                var dateEnd = $('#dateEnd').val();
                let check = true;
                if (dateStart == '' || dateEnd == '') {
                    check = false;
                }
                return check;

            }
            $('#reportProfitsForm').on('submit', function(e) {
                var chk = validationForm();
                if (chk == false) {
                    e.preventDefault();
                }
            });
        });
    </script>