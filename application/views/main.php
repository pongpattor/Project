<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/script/node_modules/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrap4/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/icon_fontawesome/js/all.min.js'); ?>" crossorigin="anonymous"></script>
    <title>Foodshop</title>
    <style>
        .fcblack {
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light" style="background-color: #AEDAD7;">
            <a class="navbar-brand"><img src="<?php echo base_url('assets/image/logo.jpg'); ?>" alt="" width="35px" height="35px"></a>
            <span class="mr-2">Foodshop</span>
            <button style="background-color: white;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav mr-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        สินค้า
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">อาหาร</a>
                        <a class="dropdown-item" href="#">เครื่องดื่ม</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">โปรโมชั่นเซ็ท</a>
                        <a class="dropdown-item" href="#">โปรโมชั่นลดราคา</a>

                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <br><br><br>
    <!-- Body -->
    <div class="container-fluid" style="width: 70%;">
        <?php $this->load->view($page); ?>
    </div>
    <!-- Body -->
</body>

</html>