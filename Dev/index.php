<?php
	require_once "../dbconn.php";
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
		<tr>
			<a href="insert_game.php">Add Game</a>
			<a href="logout.php">Logout</a>
		</tr>
		<br>
	<body>
			<hr>
			=========================GAME==============================


			

			<table border="3">
		<tr>
			<th>Game Title</th>
			<th>Genre</th>
			<th>Date Realease</th>
			<th>Platform</th>
			<th>Action</th>
		</tr>

		<?php
		$fetch = "SELECT * FROM game";
		$prep = $pdo->prepare($fetch);
		$prep->execute();
		$rows = $prep->fetchAll();

		foreach ($rows as $row):
		?>
				
					<tr>
						<td><?php echo $row['GameTitle']; ?></td>
						<td><?php echo $row['Genre']; ?></td>
						<td><?php echo $row['DateReleased']; ?></td>
						<td><?php echo $row['Platform']; ?></td>
						<td>
							<a href="update_game.php"> Edit </a>
						</td>
					</tr>
				<?php
					endforeach;
				?>	
			</table>


			<hr>
			=========================REVIEW==============================
			

				<table border="3">
			<tr>
				<th>Rating</th>
				<th>Feedback</th>
				<th>Playtime</th>
				<th>Bugreport</th>
			</tr>

			<?php
			$fetch = "SELECT * FROM review";
			$prep = $pdo->prepare($fetch);
			$prep->execute();
			$rows = $prep->fetchAll();

			foreach ($rows as $row):
			?>
					
						<tr>
							<td><?php echo $row['rating']; ?></td>
							<td><?php echo $row['feedback']; ?></td>
							<td><?php echo $row['playtime']; ?></td>
							<td><?php echo $row['Bugreport']; ?></td>
						</tr>
					<?php
						endforeach;
					?>	
				</table>

			<hr>
	</body>
</html>