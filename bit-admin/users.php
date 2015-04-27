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
                    <h1 class="page-header">Useri</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <?php 
                    if(isset($_GET['delete'])) {
                        delete_user($_GET['delete']);
                    }
                    admin_list_users(); ?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <?php change_u_type();?>
            	<form action="" method="POST">
                <h3>Schimba drepturi</h3>
                <div class="col-md-4">
            		<select class="form-control col-md-4 pull-left" name="user" id="">
         				 <?php list_users_option(); ?>
            		</select>
                </div> 
                <div class="col-md-4">
                    <select class="form-control col-md-4 pull-left" name="type" id="">
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </div> 
                    
                    <button type="submit" class="btn btn-default" name="change_u_type">Schimba</button>
            	</form>
            </div>
        </div>
	</div>
</body>
</html>