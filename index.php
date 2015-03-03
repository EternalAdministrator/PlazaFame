<?php
	require("conn.php");
	if(!$loggedIn){
?>
	<h1>PlazaFame</h1>
	<a href="login.php">Login</a>, or, <a href="register.php">Register</a>.
<?php }else{ ?>
	<h1>Hello, <?php echo $userRow["userName"] ?>.</h1>
	<h3>You have <?php echo $userRow["pts"] ?> points.</h3>
	<a href="givePts.php">Give points to someone</a>
<?php
	}
?>