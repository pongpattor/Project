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


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="navbar-brand">
            <img src="<?= base_url('assets/image/logo.jpg') ?>" width="30" height="30" class="d-inline-block align-top " alt="">
        </div> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="<?= site_url('admin/service') ?>" style="margin-left: 30px; margin-right: 30px;">เข้าใช้บริการ</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('admin/queue') ?>" style="margin-left: 30px; margin-right: 30px;">คิวล่วงหน้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('admin/queuewalkin') ?>" style="margin-left: 30px; margin-right: 30px;">คิวหน้าร้าน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="margin-left: 30px; margin-right: 30px;">บริการในร้าน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="margin-left: 30px; margin-right: 30px;">ครัวอาหาร</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="margin-left: 30px; margin-right: 30px;">ครัวเครื่องดื่ม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="margin-left: 30px; margin-right: 30px;">แจ้งเสิร์ฟ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="margin-left: 30px; margin-right: 30px;">ชำระเงิน</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('admin/admin') ?>" style="margin-left: 30px; margin-right: 30px;color:yellow">กลับสู่ระบบหลัก</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <main>
        <div id="content" class="container-fluid">
            <?php $this->load->view('admin/' . $page); 
            ?>
        </div>
    </main>
    <br><br>

</body>

</html>