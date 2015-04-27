<?php 
session_start();
require_once("bit-admin/inc/functions.php"); global $addr; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php front_head("Home"); ?>
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
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php front_list_posts_paginated();?>
            </div>
        </div>
    </div>

    <hr>

    <?php front_footer(); ?>

</body>

</html>
