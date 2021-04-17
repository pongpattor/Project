<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายงานยอดจำนวนการใช้โปรโมชั่นตามช่วงเวลา </h3>
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
                                <form action="<?= site_url('admin/report/reportAmountPromotion') ?>" method="GET" id="reportAmountPromotionForm">
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
                                <h2 class="d-inline">โปรโมชั่นลดราคา</h2>
                                <div id="propricepiechart"></div>
                                <div class="table-responsive">
                                    <table id="propricetable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                                <th style="text-align: center;">จำนวนที่ใช้งาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                $no = 1;
                                                foreach ($reportproprice as $rowprice) : ?>
                                                    <tr>
                                                        <td class="align-middle " style="text-align: center;"><?= $no ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $rowprice->PROMOTIONPRICE_NAME; ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $rowprice->cntpro; ?></td>
                                                    </tr>
                                                    <?php $no++;?>
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
                                <h2 class="d-inline">โปรโมชั่นเซ็ท</h2>
                                <div id="prosetpiechart"></div>
                                <div class="table-responsive">
                                    <table id="prosettable" class="table  table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">ชื่อโปรโมชั่น</th>
                                                <th style="text-align: center;">จำนวนที่ใช้งาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                $no = 1;
                                                foreach ($reportproset as $row) : ?>
                                                        <tr>
                                                            <td class="align-middle " style="text-align: center;"><?= $no ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->PROMOTIONSET_NAME; ?></td>
                                                            <td class="align-middle" style="text-align: center;"><?= $row->cntpro; ?></td>
                                                        </tr>
                                                    <?php $no++;?>
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
            google.charts.setOnLoadCallback(propricepiechart);
            google.charts.setOnLoadCallback(prosetpiechart);
            
            function prosetpiechart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'ReportAmountProset'],
                    <?php $rowPieNo = 0;
                    $proset = '';
                    foreach ($reportproset as $rowPie) :
                            $proset .= "['$rowPie->PROMOTIONSET_NAME',$rowPie->cntpro]";
                            if ($rowPieNo < (count($reportproset) - 1)) {
                                $proset .= ',';
                            }
                            $rowPieNo++;
                        
                        if ($rowPieNo == 9) {
                            break;
                        }
                    endforeach;
                    echo $proset;
                    //         
                    ?>
                ]);

                var options = {
                    title: 'กำไร/ขาดทุนประเภทเครื่องดื่ม'
                };
                document.getElementById("prosetpiechart").style.width = "100%";
                document.getElementById("prosetpiechart").style.height = "350px";
                var chart = new google.visualization.PieChart(document.getElementById('prosetpiechart'));
                chart.draw(data, options);
            }

            function propricepiechart() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'ReportAmountProprice'],
                    <?php $rowPieNo = 0;
                    $proprice = '';
                    foreach ($reportproprice as $rowPie) :
                            $proprice .= "['$rowPie->PROMOTIONPRICE_NAME',$rowPie->cntpro]";
                            if ($rowPieNo < (count($reportproprice) - 1)) {
                                $proprice .= ',';
                            }
                            $rowPieNo++;
                        if ($rowPieNo == 9) {
                            break;
                        }
                    endforeach;
                    echo $proprice;
                    ?>
                ]);

                var options = {
                    title: 'กำไร/ขาดทุนประเภทอาหาร'
                };
                document.getElementById("propricepiechart").style.width = "100%";
                document.getElementById("propricepiechart").style.height = "350px";
                var chart = new google.visualization.PieChart(document.getElementById('propricepiechart'));
                chart.draw(data, options);
            }
        <?php }  ?>

        $(document).ready(function() {

            $('#propricetable').dataTable({
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

            $('#prosettable').dataTable({
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

            $('#reportAmountPromotionForm').on('submit', function(e) {
                var chk = validationForm();
                if (chk == false) {
                    e.preventDefault();
                }
            });
        });
    </script>