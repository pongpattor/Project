<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <!-- CSS JQUERY -->
    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('assets\script\node_modules\jquery\dist\jquery.js'); ?>"></script>
    <script src="<?= base_url('assets\bootstrap4\js\bootstrap.bundle.min.js'); ?>"></script>
    <!-- Icon -->
    <script src="<?= base_url('assets\icon_fontawesome\js\all.js'); ?>" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed ">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= site_url('admin/admin/home'); ?>">ADMIN FOODSHOP</a>
        <!-- อาจจะใช้ -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- div Space-->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
        <!-- div Space-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown input-group-append">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php echo $_SESSION['Empname'];?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">เปลี่ยนรหัสผ่าน</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('admin/admin/logout'); ?>">ออกจากระบบ</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">ระบบหน้าร้าน</div>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-dollar-sign"></i></div>
                            ระบบจัดการหน้าร้าน
                        </a>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-utensils"></i></div>
                            ระบบห้องครัว
                        </a>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-book-open"></i></div>
                            ระบบจองคิว
                        </a>


                        <div class="sb-sidenav-menu-heading">ระบบหลังร้าน</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#EmployeecollapseLayouts" aria-expanded="false" aria-controls="EmployeecollapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-address-card"></i></div>
                            พนักงาน
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="EmployeecollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/employee/'); ?>">รายชื่อพนักงาน</a>
                                <a class="nav-link" href="<?= site_url('admin/department/'); ?>">แผนก</a>
                                <a class="nav-link" href="<?= site_url('admin/position/'); ?>">ตำแหน่ง</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="<?= site_url('admin/desk/'); ?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-couch"></i></div>
                            โต๊ะ
                        </a>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ProductcollapseLayouts" aria-expanded="false" aria-controls="ProductcollapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-boxes"></i></div>
                            สินค้า
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="ProductcollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/product/'); ?>">รายการสินค้า</a>
                                <a class="nav-link" href="<?= site_url('admin/typeproduct/'); ?>">ประเภทสินค้า</a>
                                <a class="nav-link" href="<?= site_url('admin/meat/'); ?>">ประเภทเนื้อสัตว์</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="<?= site_url('admin/receiveIngredient/'); ?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-cart-arrow-down"></i></div>
                            รับวัตถุดิบ
                        </a>

                        <a class="nav-link collapsed" href="<?= site_url('admin/promotion/');?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-gifts"></i></div>
                            โปรโมชั่น
                        </a>
                        <a class="nav-link collapsed" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-medical-alt"></i></div>
                            รีพอร์ท
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div id="content" class="container-fluid">
                    <?php $this->load->view('admin/' . $page); ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted"><b>Copyright &copy; Your Website 2020</b></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url('assets/script/scripts.js"') ?>"></script>

</body>

</html>