<?php 
session_start();
require_once("bit-admin/inc/functions.php"); global $addr; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php front_head("Contact"); ?>
</head>

<body>
    <!-- Navigation -->
    <?php front_menu(); ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo $addr; ?>/images/front/404.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading" style="color:#000;">
                        <h1>Ups.</h1>
                        <hr class="small">
                        <span class="subheading">You seem a bit lost.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php front_footer(); ?>
</body>

</html>
