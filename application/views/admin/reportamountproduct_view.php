<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายงานยอดจำนวนการขายตามช่วงเวลา </h3>
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
                                <form action="<?= site_url('admin/report/reportAmount') ?>" method="GET" id="reportAmountForm">
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
                                                    <div class="form-group row">
                                                        <div class="col-4">
                                                            <label for="sorting" class="col col-form-label">เรียง</label>
                                                        </div>
                                                        <div class="col-8">
                                                            <select name="sorting" id="sorting" class="form-control" required>
                                                                <option value="" selected disabled>กรุณาเลือก</option>
                                                                <option value="ASC" <?php
                                                                                    if ($this->input->get('sorting') == 'ASC') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>>น้อยไปมาก</option>
                                                                <option value="DESC" <?php
                                                                                        if ($this->input->get('sorting') == 'DESC') {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>มากไปน้อย</option>
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
                    <div class="col-6">
                        <div class="card  shadow-lg text-center h-100">
                            <div class="card-body">
                                <h2 class="d-inline">อาหาร</h2>
                                <div class="table-responsive">
                                    <div id="foodpiechart"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="foodReporttable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อสินค้า</th>
                                                <th style="text-align: center;">จำนวนที่ขายได้</th>
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
                                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->AllAmount); ?></td>
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
                                    <div id="drinkpiechart"></div>
                                </div>

                                <div class="table-responsive">
                                    <table id="drinkReporttable" class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อสินค้า</th>
                                                <th style="text-align: center;">จำนวนที่ขายได้</th>
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
                                                            <td class="align-middle" style="text-align: center;"><?= number_format($row->AllAmount); ?></td>
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
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(foodpiechart);
            google.charts.setOnLoadCallback(drinkpiechart);

            function drinkpiechart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'ReportAmountDrink'],
                    <?php $rowPieNo = 0;
                    $Drink = '';
                    foreach ($report as $rowPie) :
                        if ($rowPie->TYPEPRODUCT_GROUP == '2') {
                            $Drink .= "['$rowPie->PRODUCT_NAME',$rowPie->AllAmount]";
                            if ($rowPieNo < (count($report) - 1)) {
                                $Drink .= ',';
                            }
                            $rowPieNo++;
                        }
                        if ($rowPieNo == 9) {
                            break;
                        }
                    endforeach;
                    echo $Drink;
                    //         
                    ?>
                ]);

                var options = {
                    title: 'จำนวนยอดขายสินค้า'
                };
                document.getElementById("drinkpiechart").style.width = "100%";
                document.getElementById("drinkpiechart").style.height = "350px";
                var chart = new google.visualization.PieChart(document.getElementById('drinkpiechart'));
                chart.draw(data, options);
            }

            function foodpiechart() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'ReportAmountFood'],
                    <?php $rowPieNo = 0;
                    $Food = '';
                    foreach ($report as $rowPie) :
                        if ($rowPie->TYPEPRODUCT_GROUP == '1') {
                            $Food .= "['$rowPie->PRODUCT_NAME',$rowPie->AllAmount]";
                            if ($rowPieNo < (count($report) - 1)) {
                                $Food .= ',';
                            }
                            $rowPieNo++;
                        }
                        if ($rowPieNo == 9) {
                            break;
                        }
                    endforeach;
                    echo $Food;
                    ?>
                ]);

                var options = {
                    title: 'จำนวนยอดขายสินค้า'
                };
                document.getElementById("foodpiechart").style.width = "100%";
                document.getElementById("foodpiechart").style.height = "350px";
                var chart = new google.visualization.PieChart(document.getElementById('foodpiechart'));
                chart.draw(data, options);
            }
        <?php }  ?>

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
                var typeproduct = $('#typeProduct').val();
                var dateStart = $('#dateStart').val();
                var dateEnd = $('#dateEnd').val();
                var sorting = $('#sorting').val();
                let check = true;
                if (typeproduct == '' || dateStart == '' || dateEnd == '' || sorting == '') {
                    check = false;
                }
                return check;

            }

            $('#reportAmountForm').on('submit', function(e) {
                var chk = validationForm();
                if (chk == false) {
                    e.preventDefault();
                }
            });
        });
    </script>