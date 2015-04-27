<?php 
session_start();
require_once("bit-admin/inc/functions.php"); global $addr; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php front_head("Home"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>


    <!-- Navigation -->
    <?php front_menu(); ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo $addr;?>/images/front/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>BIT Blog</h1>
                        <hr class="small">
                        <span class="subheading">A simple CMS by Andrei Terecoasa</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
                <div class="col-md-6">
                    <?php login_actions(); ?>
                    <h2>Login</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" id="" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" id="" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <?php g_recaptcha(); ?>
                        </div>
                        <button type="submit" class="btn btn-default" name="login_action">Login</button>
                    </form>
                </div>
        </div>
    </div>

    <hr>

    <?php front_footer(); ?>

</body>

</html>
