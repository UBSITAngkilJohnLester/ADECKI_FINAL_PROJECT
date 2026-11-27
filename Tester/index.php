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
							<a href="edit_game/index.php"> Review </a>
						</td>
					</tr>
				<?php
					endforeach;
				?>	
			</table>


			<hr>
			
	
			</table>
		</form>
	</body>
</html>