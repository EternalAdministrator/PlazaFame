<?php
	require("conn.php");

	$header = "<h1>PlazaFame - Login</h1><a href=\"index.php\">Go back</a><br>";

	if($loggedIn)
		die("<p style='color:red'><strong>You're already logged in!</strong></p>");

	if($isPost){
		do{
			if(!$_POST['userName'] || !$_POST['passWord']){
				echo($header."<p style='color:red'><strong>Fill the forms first.</strong></p>");
				break;
			}

			if(preg_match('/[^\w-]+/i', $_POST['userName']) || strlen($_POST['userName']) < 3 || strlen($_POST['userName']) > 15){
				echo($header."<p style='color:red'><strong>Your username must be alphanumeric and must be between 3-15 characters.</strong></p>");
				break;
			}

			if(strlen($_POST['passWord']) > 50){
				echo($header."<p style='color:red'><strong>Your password is too long.</strong></p>");
				break;
			}

			if(getUserRow($_POST['userName'])['userName'] != $_POST['userName'] || getUserRow($_POST['userName'])['passWord'] != hash('sha256', $salt.$_POST['passWord'])){
				echo($header."<p style='color:red'><strong>Your username and/or password is incorrect.</strong></p>");
				break;
			}

			# everything seems ok, register the cookies and inform the user
			$cookieExpire = time() + 60 * 60 * 24 * 30;
			setcookie("userName", $_POST['userName'], $cookieExpire, "/");
			setcookie("passWord", hash('sha256', $salt.$_POST['passWord']), $cookieExpire, "/");

			die($header."<p><strong><h2 style='color:lime'>Success.</h2>You have successfully logged in.<br>You'll be redirected in 5 seconds...</strong></p><meta http-equiv=\"refresh\" content=\"5; url=index.php\" />");
		} while (0);
	}else{
		echo $header;
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
				<td></td>
				<td><input type="submit" value="Login"></td>
			</tr>
		</table>
	</form>