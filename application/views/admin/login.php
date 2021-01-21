<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS JQUERY -->
    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('assets\script\node_modules\jquery\dist\jquery.js'); ?>"></script>
    <script src="<?= base_url('assets\bootstrap4\js\bootstrap.bundle.min.js'); ?>"></script>
    <!-- Icon -->
    <script src="<?= base_url('assets\icon_fontawesome\js\all.js'); ?>" crossorigin="anonymous"></script>
    <!-- script -->
    <script src="<?= base_url('assets/script.js') ?>"></script>
</head>

<body style="background-color: #AEDAD7;" class="container-fluid text-center">
    <div class=" row h-100 justify-content-center  align-items-center">
        <div class="col-6">
            <div class="card boder-0 shadow-lg ">
                <div class="card-header">
                    <h3>เข้าสู่ระบบ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 ">
                            <img src="<?= base_url('assets/image/logo.jpg') ?>" alt="" width="150px" height="150px" class="justify-content-center">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form action="<?= site_url('admin/login/Login') ?>" method="POST">
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6 ">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Username" name="username" id="username" maxlength="10" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6 ">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md col-xl-6 ">
                                        <input type="submit" value="เข้าสู่ระบบ" class="btn btn-success" id="Login">
                                    </div>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>