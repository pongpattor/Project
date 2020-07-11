<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Bootstrap CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Jquery,Popper,bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!-- Social BTN CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- SWAL CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Document</title>


    <style>
        body {
            background-image: url('../../assets/image/bg.jpg');
        }

        #btn_search {
            border: 1px solid red;
            color: yellow;
        }

        #btn_search:hover {
            background-color: yellow;
            color: black;
        }


        .social:hover {
            background-color: red;
            width: 220px;
            height: 30px;
            text-align: center;
            margin: 4px 2px;
            border-radius: 20px;
        }

        li.social a:hover {
            color: yellow;
        }





    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-light" style="background-color: black;">
        <a class="navbar-brand" href="#"><img src="<?php echo base_url('assets/image/logo.jpg'); ?>" alt="" width="35px" height="35px"></a>
        <button style="background-color: white;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#" style="color:white">หน้าหลัก <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white">
                        ประเภทอาหาร
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">ต้ม</a>
                        <a class="dropdown-item" href="#">ผัด</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">ทั้งหมด</a>
                    </div>
                </li>

                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="btn_search">Search</button>
                    </form>
                </li>
            </ul>
            <ul class="navbar-nav ">
                <li class="nav-item" >
                    <a href="<?= site_url('user/signup'); ?>" style="color: white;">เข้าสู่ระบบ</a>
                </li>
            </ul>
            <ul></ul>
            <ul class="navbar-nav ">
                <li class="nav-item" >
                    <a href="<?= site_url('user/signup'); ?>" style="color:yellow">สมัครสมาชิก</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br>
    <!-- Header -->


    <!-- Body -->
    <?php $this->load->view($page); ?>
    <!-- Body -->


    <!-- Footer -->
    <footer class="page-footer font-small blue pt-4" style="background-color: black; color:white;">
        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-6 mt-md-0 mt-3">
                    <!-- Content -->
                    <h5 class="text-uppercase" style="color:yellow;">Footer Content</h5>
                    <p>Here you can use rows and columns to organize your footer content.</p>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none pb-3">
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- Links -->
                    <h5 class="text-uppercase" style="color:yellow;">Links</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#!" style="color:white;">Link 1</a>
                        </li>
                        <li>
                            <a href="#!" style="color:white;">Link 2</a>
                        </li>
                        <li>
                            <a href="#!" style="color:white;">Link 3</a>
                        </li>
                        <li>
                            <a href="#!" style="color:white;">Link 4</a>
                        </li>
                    </ul>

                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-3 mb-md-0 mb-3">
                    <!-- Links -->
                    <h5 class="text-uppercase" style="color:yellow;">Social</h5>
                    <ul class="list-unstyled ">
                        <li class="social">
                            <a href="#!" style="color:white;" class="fa fa-facebook">ติดตามเราบน เฟซบุ๊ก</a>
                        </li>
                        <li class="social">
                            <a href="#!" style="color:white;" class="fa fa-twitter">ติดตามเราบน ทวิตเตอร์</a>
                        </li>
                        <li class="social">
                            <a href="#!" style="color:white;" class="fa fa-instagram">ติดตามเราบน อินสตาแกรม</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="" style="color:yellow;"> FoodShop.com</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->

</body>

</html>