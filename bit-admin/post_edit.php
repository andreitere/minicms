<?php 
session_start();
require_once("inc/functions.php");
admin_check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php admin_head("Articole"); ?>
    <script src="../components/tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            height: 700,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste jbimages"
              ],
                
              // ===========================================
              // PUT PLUGIN'S BUTTON on the toolbar
              // ===========================================
                
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
                
              // ===========================================
              // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
              // ===========================================
                
              relative_urls: false
         });
    </script>
</head>
<body>
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">BITCMS - Articole</a>
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


        
    
        <?php 
            if(isset($_GET['id'])) {
                $action = 'edit';
            } else {
                $action = 'new';
            }

        ?>


        <div id="page-wrapper" class="add_post_page">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editare Articol</h1>
                </div>
                <?php 
                    if(isset($_POST['publish'])) {
                        $response = add_new_post();
                        if($response) {
                            success_alert("Articolul a fost publicat.");
                        } else {
                            danger_alert("A aparut o eroare!");
                        }
                    } else if(isset($_POST['update'])){
                        $response = update_post();
                        if($response) {
                            success_alert("Articolul a fost actualizat.");
                        } else {
                            danger_alert("A aparut o eroare!");
                        }
                    }

                    
                ?>
            </div>
            <div class="row">
                    <?php
                        if($action == 'new') {
                            ?>
                            
                                <div class="panel panel-default" >
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form action="" method="POST" role="form">
                                                    <div class="form-group">
                                                        <label>Titlu</label>
                                                        <input class="form-control" name="p_title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Text area</label>
                                                        <textarea class="form-control" rows="3" name="p_content"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-default" name="publish">Publica</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>

    

                            <?php
                        } else {
                            $post = get_post_data($_GET['id']);
                            ?>
                                <div class="panel panel-default" >
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form action="" method="POST" role="form" >
                                                    <div class="form-group">
                                                        <label>Titlu</label>
                                                        <input class="form-control" name="p_title" value="<?php echo $post['p_title'] ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Text area</label>
                                                        <textarea class="form-control" rows="3" name="p_content" value=""><?php echo $post['p_content']; ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="p_id" value="<?php echo $post['p_id']; ?>">
                                                    <button type="submit" class="btn btn-default" name="update">Salveaza</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                  

                            

                            <?php
                        }
                    ?>

            </div>
        </div>
	</div>
</body>
</html>