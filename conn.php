<?php
	# Made by MarioErmando

	error_reporting(E_ALL ^ E_NOTICE);

	$db = new mysqli("localhost", "root", "", "plazaFame");
	if(mysqli_connect_errno())
		die("Can't connect to the database.<br><pre>".$db->connect_error);

	$salt = "4[M5H)z)lFuP2AQ1,C,TH4IT1{MqfyxrTQ]kFAT.O/";
	$isPost = ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;

	$getUserSQL = mysqli_query($db, "SELECT * FROM users WHERE userName='".safe($_COOKIE['userName'])."' AND passWord='".safe($_COOKIE['passWord'])."'");
	$userRow = mysqli_fetch_array($getUserSQL);

	$userAlreadyRegisteredSQL = mysqli_query($db, "SELECT * FROM users WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
	$userAlreadyRegistered = mysqli_num_rows($getUserSQL) ? true : false;

	$loggedIn = mysqli_num_rows($getUserSQL) ? true : false;

	if(!$loggedIn){
		setcookie("userName", "", time()-3600);
		setcookie("passWord", "", time()-3600);
	}else{
		mysqli_query($db, "UPDATE users SET ip = '".$_SERVER['REMOTE_ADDR']."' WHERE id='".$userRow['id']."'");
	}

	# Functions
	function safe($input) {
		global $db;
		$valid_input = mysqli_real_escape_string($db, trim(stripcslashes(htmlspecialchars($input ,ENT_QUOTES, "UTF-8"))));
		return $valid_input;
	}

	function getUserRow($user){
		global $db;
		$getUserSQL = mysqli_query($db, "SELECT * FROM users WHERE userName='".safe($user)."'");
		$userRow = mysqli_fetch_array($getUserSQL);
		return $userRow;
	}

?>