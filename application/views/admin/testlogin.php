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
</head>

<body style="background-color: #AEDAD7;" class="container-fluid text-center">
    <div class=" row h-100 justify-content-center  align-items-center">
        <div class="col-6">
            <div class="card boder-0 shadow-lg ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row h-100 justify-content-center  align-items-center">
                                        <div class="col">
                                            <img src="<?= base_url('assets/image/logo.jpg') ?>" alt="" width="150px" height="150px" class="justify-content-center w-100">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <p style="font-size: 2rem;">เข้าสู่ระบบ</p>
                                    <br>
                                    <div class="col-12">
                                        <form action="<?= site_url('admin/login/Login') ?>" method="POST">
                                            <div class="row justify-content-center">
                                                <div class="col-10 ">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" maxlength="10" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-10 ">
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
                                                <div class="col-10 ">
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

            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {

            // $('#btnc').click(function(){
            //     $.ajax({
            //         url : "<?= site_url('admin/login/destroySession') ?>",
            //         success:function(data){
            //             console.log(data);
            //         }
            //     });
            // });

            $("#username").keypress(function(event) {
                var ew = event.which;
                if (ew == 32)
                    return true;
                if (48 <= ew && ew <= 57)
                    return true;
                if (65 <= ew && ew <= 90)
                    return true;
                if (97 <= ew && ew <= 122)
                    return true;
                return false;
            });

            $("#password").keypress(function(event) {
                var ew = event.which;
                if (ew == 32)
                    return true;
                if (48 <= ew && ew <= 57)
                    return true;
                if (65 <= ew && ew <= 90)
                    return true;
                if (97 <= ew && ew <= 122)
                    return true;
                return false;
            });




        });
    </script>

</body>

</html>