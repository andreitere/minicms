<?php 
    session_start();
    require_once("inc/functions.php");
    admin_check_login();
    $deleted = null;
    if(isset($_GET['action']) && isset($_GET['id'])) {
       $deleted =  delete_post($_GET['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php admin_head("Admin"); ?>
    <link rel="stylesheet" href="../components/datatables/css/jquery.dataTables.css">
    <script type="text/javascript" src="../components/datatables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready( function () {
        $('#posts_table').DataTable({
            pageLength: 20
        });
    } );
</script>
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
                    <h1 class="page-header">Articole</h1>
                </div>
            </div>
            <div class="row">
                <?php if($deleted == true) {
                    ?>
                        <div class="alert alert-success">
                            Articolul a fost sters!
                        </div>
                    <?php
                }
               ?>
                <div class="col-lg-12">
                    <?php admin_list_posts(); ?>
                </div>
            </div>
        </div>
	</div>
</body>

</html>