<?php 
require_once('env.php');
//if user Try To access login page while he is already logined,return him to his page
if (User::isLoggedIn()) {
	header("Location:home.php");
}
if (isset($_POST['login'])) {
	$position = $_POST['position'];
	$unameOrEmail = $_POST['unameORemail'];
	$pass = md5($_POST['password']);
	User::authenticate($unameOrEmail,$pass,$position);
}
$loginPage = new Template();
$loginPage->loginPage();
