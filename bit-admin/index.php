<?php 
session_start();
require_once("inc/functions.php");
admin_check_login();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php admin_head("Admin"); ?>
</head>
<body>
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">BITCMS - Admin</a>
			</div>
			



            <!-- SIDEBAR -->

            <?php include('sidebar.php'); ?>
		</nav>



        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Principal</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php get_comments_number(); ?></div>
                                    <div>Comentarii</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">Vezi comentarii</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php get_posts_number(); ?></div>
                                    <div>Articole</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">Vezi articole</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
	</div>
</body>
</html>