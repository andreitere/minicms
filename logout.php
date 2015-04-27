<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['logged_in']);
unset($_SESSION['type']);
var_dump($_SESSION);
session_destroy();
var_dump($_SESSION);

require_once("bit-admin/inc/functions.php");
header("Location: " . $addr );

?>