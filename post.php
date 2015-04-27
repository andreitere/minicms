<?php 
session_start();
require_once("bit-admin/inc/functions.php"); global $addr; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php front_head("Post"); ?>
</head>

<body>
    <?php front_menu(); ?>
    <?php 
        $post = get_front_single_post();
        if ($post['error'] == 1) {
            header("Location: ". $addr ."/404.php");
        }
        $date = new DateTime($post['p_date']); 
        
    ?>

    <header class="intro-header" style="background-image: url('<?php echo $addr; ?>/images/front/post-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $post['p_title']; ?></h1>
                        <span class="meta">Posted by <a href="#"><?php echo $post['p_author']; ?></a> on <?php echo $date->format('F d, Y'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                
                    <?php echo $post['p_content']; ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php 
                        vote_sys($post['p_id']); ?>
                    </div>
                </div>
            </div>

    


            <?php add_post_comment(); ?>
            <div class="row" style="margin-bottom: 20px;">
                <h2>Comentarii</h2>
                <?php get_comments($post['p_id']); ?>
            </div>
            <div class="row">
                <h2>Spune-ti parerea!</h2>
                
                <form action="" method="POST" role="form">
                    <?php if(!isset($_SESSION['username'])) {
                        ?>
                        <div class="form-group">
                             <label>Nume</label>
                             <input class="form-control" name="c_user">
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-info">
                           Comentezi ca <?php echo $_SESSION['username']; $value = $_SESSION['username'];?>
                           <input type="hidden" class="form-control" name="c_user" value="<?php echo $value; ?>">
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label>Text area</label>
                        <textarea class="form-control" rows="3" name="c_content"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" style="display: none" class="form-control" name="p_id" value="<?php echo $post['p_id']; ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-default" name="comment" value="y">Comenteaza</button>
                </form>
            </div>
        </div>
    </article>

    <hr>

    <?php front_footer();?>

</body>

</html>
