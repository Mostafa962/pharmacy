<?php 
require_once('env.php');
//if user Try To access System pages before he login,return him to login page
if (!User::isLoggedIn()) {
	header("Location:login.php");
}
$systemPages = new Template();
$systemPages->SystemPages();
