<br>
<div class="row">
    <div class="col-12">
        <div class="card boder-0 shadow-lg text-center">
            <div class="card-header  bg-white">
                <h3 class="d-inline">ออกรายงานยอดจำนวนการขายตามช่วงเวลา </h3>
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
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="form-group row">
                                                        <div class="col-6">
                                                            <label for="typeProduct" class="col col-form-label">ประเภทสินค้า</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select name="typeProduct" id="typeProduct" class="form-control" required>
                                                                <option value="" selected disabled>กรุณาเลือก</option>
                                                                <option value="1" <?php
                                                                                    if ($this->input->get('typeProduct') == '1') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>>อาหาร</option>
                                                                <option value="2" <?php
                                                                                    if ($this->input->get('typeProduct') == '2') {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>>เครื่องดื่ม</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <div class="col-6">
                                                            <label for="sorting" class="col col-form-label">เรียง</label>
                                                        </div>
                                                        <div class="col-6">
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
                                                <div class="col-1">
                                                    <button type="submit" class="btn btn-secondary float-left">ค้นหา <i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group row">
                                                <div class="col-2">
                                                    <label for="dateStart" class="col col-form-label">วันเริ่มต้น</label>
                                                </div>
                                                <div class="col-3">

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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <span class="float-right"><?= 'จำนวนทั้งหมด <span class="h4">' . $total . '</span> รายการ' ?></span> <!-- <canvas id="myChart" width="100%" height="20px"></canvas> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table id="selectedColumn " class="table  table-bordered table-sm" cellspacing="0" width="100%">
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
                                            <tr id="" class="bgtable">
                                                <td class="align-middle " style="text-align: center;"><?= $no ?></td>
                                                <td class="align-middle" style="text-align: center;"><?= $row->PRODUCT_NAME; ?></td>
                                                <td class="align-middle" style="text-align: center;"><?= $row->AllAmount; ?></td>
                                            </tr>
                                    <?php $no++;
                                        endforeach;
                                    } ?>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['กะเพราไก่', 'ต้มยำกุ้ง', 'ผัดไทยกุ้ง', 'ไข่ดาว'],
                    datasets: [{
                        label: '# of Votes',
                        minBarLength: 4,
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
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