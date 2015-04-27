<?php



	require_once('bitdb.php');
	$addr = "http://localhost/minicms";

function admin_head($title ='') {

	?>
	<meta charset="UTF-8"> 
	<title> <?php echo "BITCMS - " . $title; ?> </title>
	<link rel="stylesheet" type="text/css" href="../components/bootstrap/css/bootstrap.css"?>
	<link rel="stylesheet" href="css/sb-admin-2.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="../components/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../components/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../components/metisMenu/metisMenu.css">
	<script type="text/javascript" src="../components/metisMenu/metisMenu.js"></script>
	<script type="text/javascript" src="js/sb-admin-2.js"></script>
	<script type="text/javascript" src="../components/bootstrap/js/bootstrap.js"></script>



	<?php
}

function admin_check_login() {
	global $bitdb;
	global $addr;
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
		$u_username = $bitdb->real_escape_string($_SESSION['username']);
		$u_password = $bitdb->real_escape_string($_SESSION['password']);
		$u_type = $bitdb->real_escape_string($_SESSION['type']);

		$q = "SELECT COUNT(*) AS logged_in FROM `users` WHERE `u_username` = '{$u_username}' AND `u_password`='{$u_password}' AND `u_type` = '{$u_type}'";
		$u = $bitdb->query($q);
		if($u) {
			$u = $u->fetch_assoc();
			if($u['logged_in'] == 1 && $_SESSION['type'] == 'admin') {

			} else {
				header("Location: " . $addr . "/login.php");
			} 
		} else {
			header("Location: " . $addr . "/login.php");
		} 
	} else {
		header("Location: " . $addr . "/login.php");
	} 
}

//posts

function add_new_post() {
	global $bitdb;

	if(isset($_POST['publish'])) {
		$p_title = $bitdb->real_escape_string($_POST['p_title']);
		$p_content = $bitdb->real_escape_string($_POST['p_content']);
		// $p_author = $bitdb->real_escape_string($_SESSION['username']);
		$p_author = 'test';
		$p_slug = $bitdb->real_escape_string(slug($p_title));
		$p_type = 'post';
		$p_date = date("Y-m-d H:i:s");


		$insert_post = "
			INSERT INTO `posts`(`p_title`, `p_content`, `p_author`, `p_slug`, `p_type`, `p_date`)
			VALUES('{$p_title}', '{$p_content}', '{$p_author}', '{$p_slug}', '{$p_type}',NOW())
		";

		if($bitdb->query($insert_post)) {
			return true;
		} else {
			return false;
		}
	}
}

function update_post() {
	global $bitdb;

	if(isset($_POST['update'])) {
		$p_title = $bitdb->real_escape_string($_POST['p_title']);
		$p_content = $bitdb->real_escape_string($_POST['p_content']);
		$p_id = $bitdb->real_escape_string($_POST['p_id']);
		$update_post = "
				UPDATE `posts`
				SET `p_title` = '{$p_title}',
					`p_content` = '{$p_content}'
				WHERE `p_id` = $p_id
		";

		if($bitdb->query($update_post)) {
			return true;
		} else {
			return false;
		}
	}
}

function admin_list_posts() {
	global $bitdb;
	global $addr;

	$get_admin_posts = "
		SELECT * FROM `posts`
	";

	$result_set = $bitdb->query($get_admin_posts);
	echo "
		<table id='posts_table'>
		<thead>
            <tr>
                <th>Titlu</th>
                <th>Autor</th>
                <th>Actiune</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Titlu</th>
                <th>Autor</th>
                <th>Actiune</th>
            </tr>
        </tfoot>

	";
	while($post = $result_set->fetch_assoc()) {
		$p_content = substr($post['p_content'], 0,50);
		echo "<tr>
				<td><a target='_blank' href='".$addr."/post/".$post['p_slug']."'>{$post['p_title']}</a></td>
				<td>{$post['p_author']}</td>
				<td><a href='post_edit.php?id=".$post['p_id']."'>Editeaza</a> | <a href='?action=delete&id=".$post['p_id']."'>Sterge</a></td>
			</tr>";
	}

	echo "</table>";
}

function get_post_data($id = 0) {
	global $bitdb;

	$post = "SELECT * FROM `posts` WHERE `p_id` = {$id}";
	$result = $bitdb->query($post);
	return $result->fetch_assoc();
}

function delete_post($id = 0) {
	global $bitdb;

	$delete_post = "DELETE FROM `posts`
					WHERE `p_id` = {$id}";
	if($bitdb->query($delete_post)) {
		return true;
	} else {
		return false;
	}
}


function admin_list_comments() {
	global $bitdb;

	$q = "SELECT `comments`.`c_user` AS user,
				 `comments`.`c_content` AS content,
				 `comments`.`c_date` AS date,
				 `comments`.`c_id` as id,
				 `posts`.`p_title` AS title,
				 `posts`.`p_slug` AS slug
		  FROM `comments`, `posts`
		  WHERE `comments`.`p_id` = `posts`.`p_id`";

	$comments = $bitdb->query($q);
	if($comments) {
		while($comment = $comments->fetch_assoc()) {
			?>
				<blockquote>
					<p><?php echo $comment['content']; ?></p>
					<footer>By <?php echo $comment['user']; ?> | <?php echo $comment['date']; ?> | on <a href="<?php echo $addr ."/post/". $comment['slug']; ?>"><?php echo $comment['title']; ?></a> <a class="pull-right text-danger" href="?delete=<?php echo $comment['id']; ?>">Sterge</a></footer>
				</blockquote>
			<?php
		}
	}
}

function delete_comment($id) {
	global $bitdb;
	$id = $bitdb->real_escape_string($id);
	$q = "DELETE FROM `comments` 
		  WHERE `c_id` = {$id}";
    if($bitdb->query($q)) {
    	success_alert("Comentariul a fost sters");
    } else {
    	danger_alert("Comentariul nu a fost sters");
    }
}

function admin_list_users() {
	global $bitdb;
	?>
	<table class="table">
				<thead>
					<tr>
						<th>Username</th>
						<th>Rol</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
	<?php
	$q = "SELECT * FROM `users`";
	$users = $bitdb->query($q);
	if($users) {
		while($user = $users->fetch_assoc()) {
			?>
			
					<tr>
			          <th scope="row"><?php echo $user['u_username']; ?></th>
			          <td><?php echo $user['u_type']; ?></td>
			          <td><a href="?delete=<?php echo $user['u_id']; ?>">Delete</a></td>
			        </tr>
			<?php
		}
	}
	?>
		</tbody>
	</table>
	<?php
}

function delete_user($id) {
	global $bitdb;

	$d = "DELETE FROM `users`
		  WHERE `u_id` = {$id}";
	if($bitdb->query($d)) {
		success_alert("Userul a fost sters");
	} else {
		danger_alert("Userul nu a putut fi sters");
	}
}

function get_comments_number() {
	global $bitdb;

	$c = "SELECT COUNT(*) AS NR FROM `comments`";

	$result = $bitdb->query($c);
	if($result) {
		$result = $result->fetch_assoc();
		$result = $result['NR'];
		echo $result;
	} else {
		echo "eroare";
	}
}

function get_posts_number() {
	global $bitdb;

	$c = "SELECT COUNT(*) AS NR FROM `posts`";

	$result = $bitdb->query($c);
	if($result) {
		$result = $result->fetch_assoc();
		$result = $result['NR'];
		echo $result;
	} else {
		echo "eroare";
	}
}


//----- end posts works ----- //






// ---- Front Start ---- //


function front_head($title="") {
	global $addr;
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo "BITCMS - ". $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $addr;?>/components/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $addr;?>/css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $addr;?>/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

	<?php
}

function front_menu() {
	global $addr;
	?>
	    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $addr; ?>">BIT CMS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo $addr; ?>">Home</a>
                    </li>
                    <?php check_login(); ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<?php
}



function front_list_posts_paginated() {
	global $bitdb;
	global $addr;
	$posts_per_page = 10;
	$sql1 = "SELECT COUNT(*) as 'NR' FROM `posts`";
	$row1 = $bitdb->query($sql1);
	if($row1) {

		$row1 = $row1->fetch_assoc();
		$rows = $row1['NR'];


		$totalpages = ceil($rows / $posts_per_page);


		if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		   $currentpage = (int) $_GET['currentpage'];
		} else {
		   $currentpage = 1;
		}

		if($currentpage > $totalpages) {
		   $currentpage = $totalpages;
		} 

		if($currentpage < 1) {
		   $currentpage = 1;
		} 

		$offset = ($currentpage - 1) * $posts_per_page;


		$get_posts = "SELECT * FROM `posts` LIMIT $offset, $posts_per_page";

		$result_set = $bitdb->query($get_posts);

		while($post = $result_set->fetch_assoc()) {
			$date = new DateTime($post['p_date']);
			?>
				<div class="post-preview">
	                <a href="<?php echo $addr; ?>/post/<?php echo $post['p_slug']; ?>">
	                    <h2 class="post-title">
	                        <?php echo $post['p_title']; ?>
	                    </h2>
	                </a>
	                <p class="post-meta">Posted by <a href="#"><?php echo $post['p_author']; ?></a> on <?php echo $date->format('F d, Y'); ?></p>
	            </div>
	            <hr>


			<?php
		}
		$range = 3;

		if ($currentpage > 1) {
		   echo " <a href='{$addr}/page/1'><<</a> ";
		   $prevpage = $currentpage - 1;
		   echo " <a href='{$addr}/page/{$prevpage}'><</a> ";
		} 


		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
		   if (($x > 0) && ($x <= $totalpages)) {
		      if ($x == $currentpage) {
		         echo " [<b>$x</b>] ";
		      } else {

		         echo " <a href='{$addr}/page/$x'>$x</a> ";
		      }
		   } 
		}
		                 
	      
		if ($currentpage != $totalpages) {
		   $nextpage = $currentpage + 1;
		   echo " <a href='{$addr}/page/{$nextpage}'>></a> ";
		   echo " <a href='{$addr}/page/{$totalpages}'>>></a> ";
		}

	}
}


function get_front_single_post() {
	global $bitdb;

	if(isset($_GET['slug'])) {
		$slug = $bitdb->real_escape_string($_GET['slug']);

		$post_q = "SELECT * FROM `posts` WHERE `p_slug` = '{$slug}'";

		$post = $bitdb->query($post_q);
		if($post) {
			$postz = $post->fetch_assoc();
			if($post->num_rows != 0) {
				$postz['error'] = 0;
			} else {
				$postz['error'] = 1;
			}
		} else {
			$postz['error'] = 1;
		}
	} else {
		$postz['error'] = 1;
	}
	return $postz;
}

function add_post_comment() {
	global $bitdb;
	if(isset($_POST['comment'])) {
		$c_user = $bitdb->real_escape_string($_POST['c_user']);
		$c_content = $bitdb->real_escape_string($_POST['c_content']);
		$p_id = $bitdb->real_escape_string($_POST['p_id']);

		$add_c = "INSERT INTO `comments`(`c_user`, `c_content`,`c_date`, `p_id`)
				  VALUES('{$c_user}','{$c_content}',NOW(), {$p_id})";
		if($bitdb->query($add_c)) {
			?>
			<div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <p>Comentariul dvs. a fost adaugat!</p>
	        </div>
			<?php
		} else {
			?>
				<div class="alert alert-warning alert-dismissable">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            S-a produs o eroare. Ne cerem scuze!
		        </div>
			<?php
		}
	} 
}

function get_comments($p_id) {
	global $bitdb;

	$query = "SELECT * FROM `comments` WHERE `p_id` = $p_id ORDER BY `c_date` DESC";

	$comms = $bitdb->query($query);

	while($comment = $comms->fetch_assoc()) {
		$date = new DateTime($comment['c_date']);
		?>
			<div class="panel panel-default" style="margin-bottom: 20px;">
	            <div class="panel-heading">
	                <?php echo $comment['c_user']; ?>
	            </div>
	            <div class="panel-body">
	               <p><?php echo $comment['c_content']; ?></p>
	            </div>
	            <div class="panel-footer">
	                <?php echo $date->format('F d, Y \l\a H:i'); ?>
	            </div>
	        </div>
		<?php
	}

}

function vote_form($p_id) {
	$user = "";
	global $bitdb;
	if(isset($_SESSION['logged_in']) && isset($_SESSION['username'])) {	
		$user = $bitdb->real_escape_string($_SESSION['username']);
		$selvote = "SELECT COUNT(*) as NRV, `v_count` FROM `votes` WHERE `v_user` = '{$user}' AND `p_id` = '{$p_id}'";
		$vot = $bitdb->query($selvote);
		if($vot) {
			$vot = $vot->fetch_assoc();
			if($vot['NRV'] == 1) {
				info_alert("Ai votat deja acest articol. Votul tau: " . $vot['v_count']);
			} else {
				get_html_vote_form($p_id);
			}
		}
	} else if(isset($_SESSION['votes'][$p_id])) {           //(isset($_COOKIE['user']) && isset($_COOKIE['user_vot'])) {
		info_alert("Ai votat deja acest articol. Votul tau: " . $_SESSION['votes'][$p_id]);
	} else {
		get_html_vote_form($p_id);
	}
	?>
		
	<?php
}

function get_html_vote_form($p_id) {
	?>
		<form action="" method="POST">
	        <label>Voteaza articolul</label>
	        <select name="v_count" class="form-control">
	            <option value="0">0</option>
	            <option value="1">1</option>
	            <option value="2">2</option>
	            <option value="3">3</option>
	            <option value="4">4</option>
	            <option value="5">5</option>
	        </select>
	        <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
	        <button type="submit" class="btn btn-primary btn-xs" name="vote" value="y">Voteaza</button>
	    </form>
	<?php 
}

function add_vote() {
	global $bitdb;
	global $addr;

	if(isset($_POST['vote'])) {
		$v_count = $bitdb->real_escape_string($_POST['v_count']);
		$p_id    = $bitdb->real_escape_string($_POST['p_id']);
		$v_user   = "vizitator";
		if(!isset($_SESSION['logged_in'])) { //daca nu e logat adaug si un cookie sa tin minte 
			// setcookie("user", $v_user, time() + (86400*30), "/". $_GET['slug']);
			// setcookie("user_vot", $v_count, time() + (86400 * 30), "/". $_GET['slug']);

			$votes = null;
			if(isset($_SESSION['votes'])) {
				$votes = $_SESSION['votes'];
			}
			// $vot['p_id'] = $p_id;
			// $vot['count'] = $v_count;
			
			$votes[$p_id] = $v_count;
			$_SESSION['votes'] = $votes;



		} else {
			$v_user = $bitdb->real_escape_string($_SESSION['username']);
		}
		
		$v = "INSERT INTO `votes`(`v_user`,`v_count`,`p_id`)
			  VALUES('{$v_user}',{$v_count},{$p_id})";
		if($bitdb->query($v)) {
			success_alert("Votul tau a fost inregistrat cu succes");
		} else {
			danger_alert("A aparut o eroare la inregistrarea votului. Te rugam sa reincerci");
		}

		
	}
}

function vote_sys($p_id) {
	global $addr;
	add_vote();
	vote_form($p_id);
}
function front_footer() {
	global $addr;
	?>
	    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="<?php echo $addr;?>/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $addr;?>/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $addr;?>/js/clean-blog.min.js"></script>
	<?php
}


function list_users_option() {
	global $bitdb;

	$q = "SELECT `u_id`,`u_username` FROM `users`";

	$set = $bitdb->query($q);
	if($set) {
		while($u = $set->fetch_assoc()) {
			echo "<option value='{$u['u_id']}'>{$u['u_username']}</option>";
		}

	} else {
		echo "error";
	}
}

function change_u_type() {
	global $bitdb;
	if(isset($_POST['change_u_type'])) {
		$user_id = $bitdb->real_escape_string($_POST['user']);
		$type = $bitdb->real_escape_string($_POST['type']);

		$u = "UPDATE `users`
				SET `u_type` = '{$type}'
				WHERE `u_id` = {$user_id}";
		if($bitdb->query($u)) {
			success_alert("Rolul userului cu id = {$user_id} a fost actualizat la {$type}");
		} else {
			danger_alert("Modificarea nu s-a realizat cu succes");
		}
	}
}

// ---- Front End ---- //




// ---- Users Start ---- //

function user_register() {
	global $bitdb;
	require_once("recaptchalib.php");

	$secretKey = "6Lc30AUTAAAAAIaYGjzB8h4a-3M3XCjQxvfHtMUL";


	if(isset($_POST['register_action'])) {
		if(isset($_POST['username'])) {
			if(isset($_POST['email'])) {
				if(isset($_POST['password'])) {
					if(isset($_POST['g-recaptcha-response'])) {
						$captcha = $_POST['g-recaptcha-response'];
						$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
						if(!$response['success']) {
							danger_alert("We think you're a spammer");
						} else {
							if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
							  danger_alert("Invalid email format");
							} else {
								$username = $bitdb->real_escape_string($_POST['username']);
								if(!user_exists($username)) {
									
									$email = $bitdb->real_escape_string($_POST['email']);
									$password = $bitdb->real_escape_string($_POST['password']);
									$password = md5($password);
									$verification_string = generateRandomString(5);
									$insert = "INSERT INTO `users`(`u_username`, `u_password`,`u_email`,`u_type`,`u_verif_code`,`u_verified`)
											   VALUES('{$username}','{$password}','{$email}','member','{$verification_string}', 0)";
									$link = $addr . "login.php?action=confirm_user&user=".$username."&verification_key=".$verification_key;

									if($bitdb->query($insert)) {
										success_alert("An email has been sent to specified address! Please check it and confirm your registration");
									

										$to = $email;
										$subject = "BIT CMS - Cont nou";
										$headers = "FROM: it@lse.org.ro \r\n";
										$headers .= "MIME-Version: 1.0\r\n";
										$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
										$headers .= "Reply-To: it@lse.org.ro \r\n".
												   "X-Mailer: PHP/" .phpversion();

										$message = "
											<div class='header'>
												<h1>BIT CMS - Cont nou</h1>
												<h2>Activare cont</h2>
											</div>
											<div class='content'>
												Pentru activarea contului te rugam acceseaza linkul: {$link}
											</div>

										";



									} else {
										danger_alert("Something bad happen");
									}


								} else {
									danger_alert("Username already exists");
								}
							}
						}
					} else {
						danger_alert("Spam verification not provided");
					}

				} else {
					danger_alert("Password not provided");
				}

			} else {
				danger_alert("Email not provided");
			}

		} else {
			danger_alert("Username not provided");
		}
	}
}



function login_actions() {
	global $bitdb;
	$secretKey = "6Lc30AUTAAAAAIaYGjzB8h4a-3M3XCjQxvfHtMUL";
	if(isset($_GET['action']) && $_GET['action'] == "confirm_user") {
		if(isset($_GET['user']) && isset($_GET['verification_key'])) {
			$username = $bitdb->real_escape_string($_GET['user']);
			$verification_key = $bitdb->real_escape_string($_GET['verification_key']);


			$update = "UPDATE `users`
					   SET `u_verified` = 1,
					   WHERE `u_username` = '{$username}' AND `u_verif_code` = '{$verification_key}'";
			$result = $bitdb->query($update);
			$affected = $result->num_rows;
			if($affected == 1) {
				succes_alert("Your succesfully verified your account. You may now proceed with login");
			} else {
				danger_alert("You shouldn't be here");
			}
		} else {
			danger_alert("You souldn't be here");
		}
	} else if(isset($_POST['login_action'])) {
		if(isset($_POST['username'])) {
			$username = $bitdb->real_escape_string($_POST['username']);
			if(isset($_POST['password'])) {
				$password = $bitdb->real_escape_string($_POST['password']);
				if(isset($_POST['g-recaptcha-response'])) {
						$captcha = $_POST['g-recaptcha-response'];
						$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
						if(!$response['success']) {
							danger_alert("We think you're a spammer");
						} else {
							$password = md5($password);

							$u_p = "SELECT * FROM `users` WHERE `u_username` = '{$username}' AND `u_password` = '{$password}' AND `u_verified` = 1";
							$result = $bitdb->query($u_p);
							if($result->num_rows == 1) {
								$user = $result->fetch_assoc();
								// session_destroy();
								// session_start();
								$_SESSION['username'] = $user['u_username'];
								$_SESSION['password'] = $user['u_password'];
								$_SESSION['type']     = $user['u_type'];
								$_SESSION['logged_in']= 1;
								success_alert("Ai fost logat");
							} else {
								danger_alert("There are some problems. Please contact the admin");
							}
						}

				}
			}
		}
	}
}

function check_login() {
	global $bitdb;
	global $addr;
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
		$u_username = $bitdb->real_escape_string($_SESSION['username']);
		$u_password = $bitdb->real_escape_string($_SESSION['password']);
		$u_type = $bitdb->real_escape_string($_SESSION['type']);

		$q = "SELECT COUNT(*) AS logged_in FROM `users` WHERE `u_username` = '{$u_username}' AND `u_password`='{$u_password}' AND `u_type` = '{$u_type}'";
		$u = $bitdb->query($q);
		if($u) {
			$u = $u->fetch_assoc();
			if($u['logged_in'] == 1 && $_SESSION['type'] == 'admin') {
				?>
				<li>
                    <a href="<?php echo $addr; ?>/bit-admin/">Admin</a>
                </li>
                <li>
                	<a href="<?php echo $addr; ?>/logout.php">Logout</a>
                </li>
                <?php
			} else {
				?>
					<li>
                        <a href="<?php echo $addr; ?>/mypanel.php">Logged In as <?php echo $_SESSION['username']; ?></a>
                    </li>
				<?php
			} 
		} else {
			header("Location: " . $addr . "/login.php");
		}
		?>
			<li>
	        	<a href="<?php echo $addr; ?>/logout.php">Logout</a>
	        </li>
		<?php
	} else {
		?>
		<li>
	        <a href="<?php echo $addr; ?>/login.php">Login</a>
	    </li>
	    <li>
	        <a href="<?php echo $addr; ?>/register.php">Register</a>
	    </li>

		<?php
	}	
}



function user_exists($user) {
	global $bitdb;

	$u = "SELECT COUNT(*) AS NR FROM `users` WHERE `u_username`= '{$user}'";

	$nr = $bitdb->query($u);
	$nr = $nr->fetch_assoc();
	$nr = $nr['NR'];

	if($nr != 0) {
		return true;
	} else {
		return false;
	}
}



// ---- Users End ---- //

















// ---- UTILS ---- //

//source  http://snipplr.com/view/2809/convert-string-to-slug/
function slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}

function g_recaptcha() {
	?>
	<div class="g-recaptcha" data-sitekey="6Lc30AUTAAAAAHZ-xVbNBlhbiSacnWyqP8H680Rf"></div>
	<?php
}

function danger_alert($message) {
	?>
	<div class="alert alert-danger">
        <?php echo $message; ?>
    </div>
	<?php
}

function success_alert($message) {
	?>
	<div class="alert alert-success">
       <?php echo $message; ?>
    </div>
	<?php
}

function info_alert($message) {
	?>
	<div class="alert alert-info">
        <?php echo $message; ?>
    </div>
	<?php
}


//from http://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


//=====||=====\\

function setup() {
	global $bitdb;

	$comments = "CREATE TABLE IF NOT EXISTS `comments` (
					`c_id` int(4) NOT NULL AUTO_INCREMENT,
				  `c_user` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
				  `c_content` text COLLATE utf8_romanian_ci,
				  `c_date` datetime NOT NULL,
				  `p_id` int(4) NOT NULL,
				  PRIMARY KEY(`c_id`)
				) DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;";

	$posts = "CREATE TABLE IF NOT EXISTS `posts` (
				`p_id` int(4) NOT NULL AUTO_INCREMENT,
				  `p_title` varchar(256) COLLATE utf8_romanian_ci DEFAULT NULL,
				  `p_content` text COLLATE utf8_romanian_ci NOT NULL,
				  `p_author` varchar(200) COLLATE utf8_romanian_ci NOT NULL,
				  `p_slug` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
				  `p_type` varchar(20) COLLATE utf8_romanian_ci NOT NULL,
				  `p_date` datetime NOT NULL,
				  PRIMARY KEY(`p_id`)
				) DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;";

	$users = "CREATE TABLE IF NOT EXISTS `users` (
			`u_id` int(3) NOT NULL AUTO_INCREMENT,
			  `u_username` varchar(200) COLLATE utf8_romanian_ci NOT NULL,
			  `u_password` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
			  `u_email` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
			  `u_type` varchar(20) COLLATE utf8_romanian_ci NOT NULL,
			  `u_verif_code` varchar(500) COLLATE utf8_romanian_ci,
			  `u_verified` int(1) NOT NULL,
			  PRIMARY KEY(`u_id`)
			) DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;
			";
	$votes = "CREATE TABLE IF NOT EXISTS `votes` (
			`v_id` int(5) NOT NULL AUTO_INCREMENT,
			  `v_user` varchar(20) COLLATE utf8_romanian_ci NOT NULL,
			  `v_count` int(1) NOT NULL,
			  `p_id` int(5) NOT NULL,
			  PRIMARY KEY(`v_id`)
			) DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;
			";


	$add_user = "INSERT INTO `users`(`u_username`,`u_password`,`u_email`,`u_type`,`u_verified`)
				 VALUES('admin','21232f297a57a5a743894a0e4a801fc3','admin@localhost.local','admin',1);";


    if($bitdb->query($comments)) {
    	if($bitdb->query($posts)) {
    		if($bitdb->query($users)) {
    			if($bitdb->query($votes)) {
    				success_alert("Totul a fost instalat cu succes");
    				if($bitdb->query($add_user)) {
    					success_alert("Userul default a fost adaugat cu succes! <br/> USER: admin <br/> PASS: admin");
    				}
    			} else {
    				danger_alert("Tabelul votes nu a putut fi creat!");
    				printf($bitdb->connect_errno);
    			}
    		} else {
    			danger_alert("Tabelul users nu a putut fi creat!");
    			printf($bitdb->connect_errno);
    		}
    	} else {
    		danger_alert("Tabelul posts nu a putut fi creat!");
    		printf($bitdb->connect_errno);
    	}
    } else {
    	danger_alert("Tabelul comments nu a putut fi creat!");
    	printf($bitdb->connect_errno);
    }



}


























?>