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
			<ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>



            <!-- SIDEBAR -->

            <?php include('sidebar.php'); ?>
		</nav>



        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Comentarii</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <?php 
                    if(isset($_GET['delete'])) {
                        delete_comment($_GET['delete']);
                    }
                    admin_list_comments(); ?>
                </div>
            </div>
        </div>
	</div>
</body>
</html>