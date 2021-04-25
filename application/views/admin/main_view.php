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
    <script src="<?= base_url('assets/script/node_modules/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/bootstrap4/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Icon -->
    <script src="<?= base_url('assets/icon_fontawesome/js/all.min.js'); ?>" crossorigin="anonymous"></script>
    <!-- script -->
    <script src="<?= base_url('assets/script.js') ?>"></script>
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets\datatable\datatables.css') ?>" />
    <script type="text/javascript" src="<?= base_url('assets\datatable\datatables.js') ?>"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= site_url('admin/admin/'); ?>">ADMIN FOODSHOP</a>
        <!-- อาจจะใช้ -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <!-- div Space-->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
        <!-- div Space-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown input-group-append">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php echo $_SESSION['employeeName']; ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= site_url('admin/admin/changePassword'); ?>">เปลี่ยนรหัสผ่าน</a>
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
                    <?php if ($_SESSION['employeePermission']['16'] == '1' || $_SESSION['employeePermission']['17'] == '1' || $_SESSION['employeePermission']['18'] == '1'):?>
                        <div class="sb-sidenav-menu-heading">ระบบหน้าร้าน</div>
                        <!-- ไประบบหน้าร้าน -->
                        <a class="nav-link" href="<?= site_url('admin/service/index') ?>">
                            <div class="sb-nav-link-icon"><i class="fa fa-dollar-sign"></i></div>
                            ระบบจัดการหน้าร้าน
                        </a>
                        <?php endif; ?>
                        <div class="sb-sidenav-menu-heading">ระบบหลังร้าน</div>
                        <!-- สมาชิก -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#CustomercollapseLayouts" aria-expanded="false" aria-controls="CustomercollapseLayouts" <?php if ($_SESSION['employeePermission']['0'] != '1' && $_SESSION['employeePermission']['1'] != '1') {
                                                                                                                                                                                                echo 'hidden';
                                                                                                                                                                                            } ?>>
                            <div class="sb-nav-link-icon"><i class="fa fa-users"></i></div>
                            สมาชิก
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="CustomercollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/customer/'); ?>" <?php if ($_SESSION['employeePermission']['0'] != '1') {
                                                                                                    echo 'hidden';
                                                                                                }
                                                                                                ?>>รายชื่อสมาชิก</a>
                                <a class="nav-link" href="<?= site_url('admin/customertype/'); ?>" <?php if ($_SESSION['employeePermission']['1'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>ประเภทสมาชิก</a>
                            </nav>
                        </div>
                        <!-- พนักงาน -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#EmployeecollapseLayouts" aria-expanded="false" aria-controls="EmployeecollapseLayouts" <?php if ($_SESSION['employeePermission']['2'] != '1' && $_SESSION['employeePermission']['3'] != '1' && $_SESSION['employeePermission']['4'] != '1') {
                                                                                                                                                                                                echo 'hidden';
                                                                                                                                                                                            } ?>>
                            <div class="sb-nav-link-icon"><i class="fa fa-address-card"></i></div>
                            พนักงาน
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="EmployeecollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/employee/'); ?>" <?php if ($_SESSION['employeePermission']['2'] != '1') {
                                                                                                    echo 'hidden';
                                                                                                }
                                                                                                ?>>รายชื่อพนักงาน</a>
                                <a class="nav-link" href="<?= site_url('admin/position/'); ?>" <?php if ($_SESSION['employeePermission']['3'] != '1') {
                                                                                                    echo 'hidden';
                                                                                                }
                                                                                                ?>>ตำแหน่ง</a>
                                <a class="nav-link" href="<?= site_url('admin/department/'); ?>" <?php if ($_SESSION['employeePermission']['4'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>แผนก</a>
                            </nav>
                        </div>
                        <!-- สินค้า -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ProductcollapseLayouts" aria-expanded="false" aria-controls="ProductcollapseLayouts" <?php if ($_SESSION['employeePermission']['5'] != '1' && $_SESSION['employeePermission']['6'] != '1' && $_SESSION['employeePermission']['7'] != '1' && $_SESSION['employeePermission']['8'] != '1') {
                                                                                                                                                                                                echo 'hidden';
                                                                                                                                                                                            } ?>>
                            <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                            สินค้า
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="ProductcollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/product/'); ?>" <?php if ($_SESSION['employeePermission']['5'] != '1') {
                                                                                                    echo 'hidden';
                                                                                                }
                                                                                                ?>>รายการสินค้า</a>
                                <a class="nav-link" href="<?= site_url('admin/typeproduct/'); ?>" <?php if ($_SESSION['employeePermission']['6'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>ประเภทสินค้า</a>
                                <a class="nav-link" href="<?= site_url('admin/recipe/'); ?>" <?php if ($_SESSION['employeePermission']['7'] != '1') {
                                                                                                    echo 'hidden';
                                                                                                }
                                                                                                ?>>สูตรการผลิต</a>
                                <a class="nav-link" href="<?= site_url('admin/ingredient/'); ?>" <?php if ($_SESSION['employeePermission']['8'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>รายการวัตถุดิบ</a>
                            </nav>
                        </div>
                        <!-- ที่นั่ง -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#SeatcollapseLayouts" aria-expanded="false" aria-controls="SeatcollapseLayouts" <?php if ($_SESSION['employeePermission']['9'] != '1' && $_SESSION['employeePermission']['10'] != '1' && $_SESSION['employeePermission']['11'] != '1') {
                                                                                                                                                                                        echo 'hidden';
                                                                                                                                                                                    } ?>>
                            <div class="sb-nav-link-icon"><i class="fa fa-chair"></i></div>
                            ที่นั่ง
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="SeatcollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/desk') ?>" <?php if ($_SESSION['employeePermission']['9'] != '1') {
                                                                                                echo 'hidden';
                                                                                            }
                                                                                            ?>>โต๊ะ</a>
                                <a class="nav-link" href="<?= site_url('admin/karaoke') ?>" <?php if ($_SESSION['employeePermission']['10'] != '1') {
                                                                                                echo 'hidden';
                                                                                            }
                                                                                            ?>>ห้องคาราโอเกะ</a>
                                <a class="nav-link" href="<?= site_url('admin/zone') ?>" <?php if ($_SESSION['employeePermission']['11'] != '1') {
                                                                                                echo 'hidden';
                                                                                            }
                                                                                            ?>>โซนที่นั่ง</a>
                            </nav>
                        </div>
                        <!-- รับล็อต -->
                        <?php if ($_SESSION['employeePermission']['12'] == '1') {
                        ?>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#LotcollapseLayouts" aria-expanded="false" aria-controls="LotcollapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa fa-box"></i></div>
                                รับล็อต
                                <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="LotcollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?= site_url('admin/lotdrink') ?>">รับล็อตเครื่องดื่ม</a>
                                    <a class="nav-link" href="<?= site_url('admin/lotingredient') ?>">รับล็อตวัตถุดิบ</a>
                                </nav>
                            </div>
                        <?php } ?>
                        <!-- โปรโมชั่น -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#PromotioncollapseLayouts" aria-expanded="false" aria-controls="PromotioncollapseLayouts" <?php if ($_SESSION['employeePermission']['13'] != '1' && $_SESSION['employeePermission']['14'] != '1') {
                                                                                                                                                                                                    echo 'hidden';
                                                                                                                                                                                                } ?>>
                            <div class="sb-nav-link-icon"><i class="fa fa-bullhorn"></i></div>
                            โปรโมชั่น
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="PromotioncollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= site_url('admin/promotionprice') ?>" <?php if ($_SESSION['employeePermission']['13'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>โปรโมชั่นลดราคา</a>
                                <a class="nav-link" href="<?= site_url('admin/promotionset') ?>" <?php if ($_SESSION['employeePermission']['14'] != '1') {
                                                                                                        echo 'hidden';
                                                                                                    }
                                                                                                    ?>>โปรโมชั่นเซ็ต</a>
                            </nav>
                        </div>
                        <!-- รายงาน -->
                        <?php if ($_SESSION['employeePermission']['15'] == '1') { ?>


                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ReportcollapseLayouts" aria-expanded="false" aria-controls="ReportcollapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa fa-file-medical-alt"></i></div>
                                รายงาน
                                <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="ReportcollapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?= site_url('admin/report/reportCrossTab') ?>">รายงานปริมาณยอดขายประจำปี</a>
                                    <a class="nav-link" href="<?= site_url('admin/report/reportAmount') ?>">รายงานยอดจำนวนการขาย</a>
                                    <a class="nav-link" href="<?= site_url('admin/report/reportProfits') ?>">รายงานกำไร/ขาดทุนแต่ละเมนู</a>
                                    <a class="nav-link" href="<?= site_url('admin/report/reportAmountQueue') ?>">รายงานยอดจำนวนการจองคิว</a>
                                    <a class="nav-link" href="<?= site_url('admin/report/reportAmountPromotion') ?>">รายงานจำนวนใช้งานโปรโมชั่น</a>

                                </nav>
                            </div>
                        <?php }
                        ?>
                        <?php if ($_SESSION['employeePermission']['18'] == '1') { ?>
                            <a class="nav-link collapsed" href="<?= site_url('admin/payment/typePayment') ?>">
                                <div class="sb-nav-link-icon"><i class="far fa-money-bill-alt"></i></div>
                                ประเภทชำระเงิน
                            </a>

                        <?php }
                        ?>
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
            <footer class=" py-4 bg-light mt-auto">
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