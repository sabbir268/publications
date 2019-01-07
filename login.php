<?php
ob_start();
require_once('app/init.php');

// if ($userO->is_login() ) {
//     redirect("index.php");
// }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="vendor/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/demo/favicon.html">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    <!-- CSS -->
    <link href="<?php echo SITE_ROOT ?>https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>assets/vendors/material-icons/material-icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>assets/vendors/mono-social-icons/monosocialiconsfont.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>assets/vendors/feather-icons/feather.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>vendor/jquery.perfect-scrollbar/1.4.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_ROOT ?>assets/css/main.css" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
    <script src="vendor/modernizr/2.8.3/modernizr.min.js"></script>
</head>

<body class="body-bg-full profile-page" style="background-image: url(assets/img/site-bg.jpg)">
    <div id="wrapper" class="row wrapper">
        <div class="container-min-full-height d-flex justify-content-center align-items-center">
            <div class="login-center">
                <div class="navbar-header text-center mt-2 mb-4">
                    <h4>
                    <a href="index.php">
                        <strong>Exam Controling Assitant</strong>
                    </a>
                </h4>
                </div>
                <!-- /.navbar-header -->
                <form  method="POST" action="app/action/login.php" >

                    <?php echo $obj->message(); ?>

                    <div class="form-group">
                        <label for="example-email">Username</label>
                        <input type="text" placeholder="username" class="form-control form-control-line" name="username" id="example-email" required>
                    </div>
                    <div class="form-group">
                        <label for="example-password">Password</label>
                        <input type="password" placeholder="password" id="password" name="password" class="form-control form-control-line" required>
                    </div>
                    <div class="form-group">
                        <button name="login" class="btn btn-block btn-lg btn-primary text-uppercase fs-12 fw-600" type="submit">Login</button>
                    </div>

                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.login-center -->
        </div>
        <!-- /.d-flex -->
    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="<?php echo SITE_ROOT ?>vendor/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>vendor/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>assets/js/material-design.js"></script>
</body>


</html>
