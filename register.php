<?php
	require("conn.php");
?>
	<h1>PlazaFame - Register</h1>
	<a href="index.php">Go back</a><br>
<?php
	if($loggedIn || $userAlreadyRegistered)
		die("<p style='color:red'><strong>You're already registered!</strong></p>");

	if($isPost){
		do{
			if(!$_POST['userName'] || !$_POST['passWord'] || !$_POST['confirmPassWord']){
				echo("<p style='color:red'><strong>Fill the forms first.</strong></p>");
				break;
			}

			if(preg_match('/[^\w-]+/i', $_POST['userName']) || strlen($_POST['userName']) < 3 || strlen($_POST['userName']) > 15){
				echo("<p style='color:red'><strong>Your username must be alphanumeric and must be between 3-15 characters.</strong></p>");
				break;
			}

			if(getUserRow($_POST['userName'])['userName'] == $_POST['userName']){
				echo("<p style='color:red'><strong>An account with the same username is already registered.</strong></p>");
				break;
			}

			if(strlen($_POST['passWord']) > 50){
				echo("<p style='color:red'><strong>Your password is too long.</strong></p>");
				break;
			}

			if($_POST['passWord'] != $_POST['confirmPassWord']){
				echo("<p style='color:red'><strong>Your passwords do not match.</strong></p>");
				break;
			}

			# everything seems ok, register teh user
			$registerSQL = mysqli_query($db, "INSERT INTO users
				(userName, passWord, uniqueHash, ip)
				VALUES (
						'".$_POST['userName']."',
						'".hash('sha256', $salt.$_POST['passWord'])."',
						'".hash('sha256', $salt.$_POST['userName'])."',
						'".$_SERVER['REMOTE_ADDR']."'
						)");

			if(!$registerSQL){
				echo("<p style='color:red'><strong>An error occured while registering. Please try again later.</strong><br><pre>".mysqli_error($db)."</pre></p>");
				break;
			}

			die("<p><strong><h2 style='color:lime'>Success.</h2>You have successfully registered to PlazaFame.<br><a href='login.php'>Please click here to login.</a></strong></p>");
		} while (0);
	}
?>
	<form action method="POST">
		<table>
			<tr>
				<td><label for="userName">Username: </label></td>
				<td><input type="text" name="userName" id="userName" placeholder="Username"></td>
			</tr>
			<tr>
				<td><label for="passWord">Password: </label></td>
				<td><input type="password" name="passWord" id="passWord" placeholder="Password"></td>
			</tr>
			<tr>
				<td><label for="confirmPassWord">Confirm: </label></td>
				<td><input type="password" name="confirmPassWord" id="confirmPassWord" placeholder="Confirm password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Register"></td>
			</tr>
		</table>
	</form>