<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= site_url('admin/admin/dashboard'); ?>">ADMIN FOODSHOP</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- div Space-->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
        <!-- div Space-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown input-group-append">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i>user</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('admin/admin/login'); ?>">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="<?= site_url('admin/admin/dashboard'); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#EmployeecollapseLayouts" aria-expanded="false" aria-controls="EmployeecollapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                            พนักงาน
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="EmployeecollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/admin/employee'); ?>">รายชื่อพนักงาน</a>
                                <a class="nav-link" href="<?= site_url('admin/admin/department'); ?>">แผนก</a>
                                <a class="nav-link" href="<?= site_url('admin/admin/position'); ?>">ตำแหน่ง</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="<?= site_url('admin/admin/customer'); ?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-user-circle"></i></div>
                            ลูกค้า
                        </a>

                        <a class="nav-link collapsed" href="<?= site_url('admin/admin/table'); ?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-table"></i></div>
                            โต๊ะ
                        </a>



                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main><br>
                <div id="content" class="container-fluid">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                        พนักงาน
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">รหัสประจำตัวพนักงาน
                                            </th>
                                            <th style="text-align: center;">ชื่อ-สกุล
                                            </th>
                                            <th style="text-align: center;">อีเมล
                                            </th>
                                            <th style="text-align: center;">เบอร์โทรศัพท์
                                            </th>
                                            <th style="text-align: center;">เงินเดือน
                                            </th>
                                            <th style="text-align: center;">แก้ไข</th>
                                            <th style="text-align: center;">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employee as $row) : ?>
                                            <tr id="<?= $row->ID ?>">
                                                <td class="align-middle" style="text-align: center;"><?= $row->ID ?></td>
                                                <td class="align-middle" style="text-align: center;"><?= $row->FIRSTNAME . ' ' . $row->LASTNAME ?></td>
                                                <td class="align-middle" style="text-align: center;"><?= $row->EMAIL ?></td>
                                                <td class="align-middle" style="text-align: center;"><?= $row->TEL ?></td>

                                                <td class="align-middle" style="text-align: center;"><?= $row->SALARY ?></td>
                                                <td>
                                                    <center>
                                                        <form action="<?= site_url('admin/admin/editEmployee') ?>" method="GET">
                                                            <button name="empID" class="btn btn-warning  edit" class="btn btn-warning" value="<?= $row->ID ?>"> <i class="fa fa-cog"></i></button>
                                                        </form>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <button class="btn btn-danger  delete" style="text-align: center; "> <i class="fa fa-trash"></i></button>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url('assets/script/scripts.js"') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/chartjs/datatables-demo.js') ?>"></script>
</body>

</html>