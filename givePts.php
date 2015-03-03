<?php
	require("conn.php");
?>
	<h1>PlazaFame - Giving points</h1>
	<a href="index.php">Go back</a><br>
<?php
	if($userRow['pts'] == "0")
		die("You don't have any more points to give. Wait for the weekly replenish or have someone give points to you.");

	if($isPost){
		do{
			if(!$_POST['userName'] || !$_POST['pts'] || !is_numeric($_POST['pts'])){
				echo("<p style='color:red'><strong>Fill the forms first.</strong></p>");
				break;
			}

			if(preg_match('/[^\w-]+/i', $_POST['userName']) || strlen($_POST['userName']) < 3 || strlen($_POST['userName']) > 15){
				echo("<p style='color:red'><strong>The username must be alphanumeric and must be between 3-15 characters.</strong></p>");
				break;
			}

			if($_POST['userName'] == $userRow['userName']){
				echo("<p style='color:red'><strong>You can't give points to yourself.</strong></p>");
				break;
			}

			if(getUserRow($_POST['userName'])['userName'] != $_POST['userName']){
				echo("<p style='color:red'><strong>This user is not yet registered in PlazaFame.<br><a href='userList.php'>See a list of users</a></strong></p>");
				break;
			}

			if(strlen($_POST['pts']) > $userRow['pts']){
				echo("<p style='color:red'><strong>You can't give more points than you have.</strong></p>");
				break;
			}

			if(strlen($_POST['pts']) < 0){
				echo("<p style='color:red'><strong>You can't give negative points. :)</strong></p>");
				break;
			}

			# everything seems ok, give teh points
			$givePtsSQL = mysqli_query($db, "UPDATE users
				SET pts = (pts + "+$_POST['pts']+")
				WHERE userName = '"+$_POST['userName']+"'");

			$removePtsFromGiverSQL = mysqli_query($db, "UPDATE users
				SET pts = (pts - "+$_POST['pts']+")
				WHERE userName = '"+$userRow['userName']+"'");

			if(!$givePtsSQL || $removePtsFromGiverSQL){
				echo("<p style='color:red'><strong>An error occured while giving points. Please try again later.</strong><br><pre>".mysqli_error($db)."</pre></p>");
				break;
			}

			echo("<p><strong><h2 style='color:lime'>Success.</h2>You have successfully given <u>"+$_POST['pts']+" points</u> to <u>"+$_POST['userName']+"</u>.</strong></p>");
		} while (0);
	}
?>
	<form action method="POST">
		<table>
			<tr>
				<td><label for="userName">To: </label></td>
				<td><input type="text" name="userName" id="userName" placeholder="Username"></td>
			</tr>
			<tr>
				<td><label for="pts">Points: </label></td>
				<td><input type="number" name="pts" id="pts" min="1" max="<?php echo $userRow['pts'] ?>" value="1"></td>
			</tr>
				<td></td>
				<td><input type="submit" value="Give"></td>
			</tr>
		</table>
	</form>