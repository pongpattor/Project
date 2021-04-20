<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">รายงานยอดจำนวนการจองคิวตามช่วงเวลา </h3>
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
                                <form action="<?= site_url('admin/report/reportAmountQueue') ?>" method="GET" id="reportProfitsForm">
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
                    <div class="col">
                        <div class="card  shadow-lg text-center h-100">
                            <div class="card-body">
                                <h2 class="d-inline">จองคิว</h2>
                                <div class="table-responsive">
                                    <div id="queuepiechart"></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="queueTable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align: center;">ช่วงเวลา</th>
                                                <th style="text-align: center;">จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($state == true) {
                                                foreach ($report as $row) : ?>
                                                    <tr>
                                                        <td class="align-middle " style="text-align: center;"><?= $row->T1 ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $row->Time1; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle " style="text-align: center;"><?= $row->T2 ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $row->Time2; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle " style="text-align: center;"><?= $row->T3 ?></td>
                                                        <td class="align-middle" style="text-align: center;"><?= $row->Time3; ?></td>
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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        <?php if ($state == true) { ?>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(queuepiechart);

            function queuepiechart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'reportAmountQueue'],
                    <?php
                    foreach ($report as $rowPie) :
                        echo  "['$rowPie->T1',$rowPie->Time1],";
                        echo  "['$rowPie->T2',$rowPie->Time2],";
                        echo  "['$rowPie->T3',$rowPie->Time3]";
                    endforeach;
                    ?>
                ]);

                var options = {
                    title: 'จำนวนการจองคิวแต่ละช่วงเวลา'
                };
                document.getElementById("queuepiechart").style.width = "100%";
                document.getElementById("queuepiechart").style.height = "350px";
                var chart = new google.visualization.PieChart(document.getElementById('queuepiechart'));
                chart.draw(data, options);
            }
        <?php }  ?>

        $(document).ready(function() {


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