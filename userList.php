<?php
	require("conn.php");
?>
	<h1>PlazaFame - User list</h1>
	<a href="index.php">Go back</a><br>
	<p>Ordered by points count</p>
	<table>
		<tr>
			<td><strong>Username</strong></td>
			<td><strong>Points</strong></td>
		</tr>
<?php
	$getUsers = mysqli_query($db, "SELECT * FROM users ORDER BY pts DESC");

	while($user = mysqli_fetch_array($getUsers)) {
		echo "<tr><td>".$user['userName']."</td><td>".$user['pts']." pts</td></tr>";
	}
?>
	</table>