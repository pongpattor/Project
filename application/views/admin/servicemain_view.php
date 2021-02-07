<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FoodShop</title>
    <!-- CSS JQUERY -->
    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/script/node_modules/jquery/dist/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrap4/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Icon -->
    <!-- <link rel="shortcut icon" href="<?php base_url('assets/image/favicon.ico') ?>" /> -->
    <script src="<?= base_url('assets/icon_fontawesome/js/all.js'); ?>" crossorigin="anonymous"></script>
    <!-- script -->
    <script src="<?= base_url('assets/script.js') ?>"></script>
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets\datatable\datatables.css') ?>" />
    <script type="text/javascript" src="<?= base_url('assets\datatable\datatables.js') ?>"></script>

</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <div class="navbar-brand">
            <img src="<?= base_url('assets/image/logo.jpg') ?>" width="30" height="30" class="d-inline-block align-top " alt="">
        </div>
        <ul class="navbar-nav ">
            <li class="nav-item  pl-3">
                <a class="nav-link" href="<?= site_url('admin/service') ?>">เข้าใช้บริการ <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link " href="<?= site_url('admin/queue') ?>">คิวล่วงหน้า</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">คิวหน้าร้าน</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">บริการในร้าน</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">ครัวอาหาร</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">ครัวเครื่องดื่ม</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">แจ้งเสิร์ฟ</a>
            </li>
            <li class="nav-item  pl-5">
                <a class="nav-link" href="#">ชำระเงิน</a>
            </li>
        </ul>
        <!-- div Space -->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
        <!-- div Space -->
        <a href="<?= site_url('admin/admin') ?>" style="color:yellow;">กลับสู่ระบบหลัก</a>
    </nav>
    <div id="layoutSidenav">
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

</body>

</html>