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
	<body>
		<hr>
		=========================DEVELOPER==============================
		<form method="post">
	<hr>
	<table border="3">
		<tr>
			<th>Developer Name</th>
			<th>Developer Studio</th>
			<th>Game Engine</th>
		</tr>

		<?php
		$fetch = "SELECT * FROM developer";
		$prep = $pdo->prepare($fetch);
		$prep->execute();
		$rows = $prep->fetchAll();

		foreach ($rows as $row):
		?>
				
					<tr>
						<td><?php echo $row['DeveloperName']; ?></td>
						<td><?php echo $row['DeveloperStudio']; ?></td>
						<td><?php echo $row['GameEngine']; ?></td>
					</tr>
				<?php
					endforeach;
				?>	
			</table>

			<hr>
			=========================GAME==============================


			<hr>

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
							<a href="edit_game/index.php"> Edit </a>
						</td>
					</tr>
				<?php
					endforeach;
				?>	
			</table>


			<hr>
			=========================REVIEW==============================
			<hr>

				<table border="3">
			<tr>
				<th>Rating</th>
				<th>Feedback</th>
				<th>Playtime</th>
				<th>Bugreport</th>
				<th>Action</th>
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
							<td>
								<a href="edit_review/index.php"> Edit </a>
							</td>
						</tr>
					<?php
						endforeach;
					?>	
				</table>

			<hr>
			=========================TESTER==============================

			<hr>

			<table border="3">
		<tr>
			<th>Tester Username</th>
			<th>Gender</th>
			<th>Playtime</th>
			<th>Age</th>
			<th>Genre Preferences</th>
		</tr>

		<?php
		$fetch = "SELECT * FROM tester";
		$prep = $pdo->prepare($fetch);
		$prep->execute();
		$rows = $prep->fetchAll();

		foreach ($rows as $row):
		?>
				
					<tr>
						<td><?php echo $row['TesterUsername']; ?> </td>
						<td><?php echo $row['Gender']; ?> </td>
						<td><?php echo $row['Playtime']; ?></td>
						<td><?php echo $row['Age']; ?> </td>
						<td><?php echo $row['GenrePreferences']; ?> </td>
					</tr>
				<?php
					endforeach;
				?>	
			</table>
		</form>
	</body>
</html>