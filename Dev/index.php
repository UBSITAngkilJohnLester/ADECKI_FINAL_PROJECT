<?php
	session_start();
	require_once "../dbconn.php";

	// Only logged-in developers may see this page (login.php sets these session keys)
	if (($_SESSION['ROLE'] ?? '') !== 'Developer' || !isset($_SESSION['DEVELOPER_ID'])) {
		header("Location: ../index.php");
		exit;
	}

	function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

	$role        = $_SESSION['ROLE'];
	$username    = $_SESSION['NAME'];
	$isDeveloper = true;

	$games   = $pdo->query("SELECT * FROM game")->fetchAll();
	$reviews = $pdo->query("SELECT * FROM review")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Indie Haus</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="dev_style.css">
</head>
<body class="dashboard">

	<nav class="navbar">
		<div class="brand">INDIE HAUS</div>
		<a class="nav-logout" href="logout.php">Logout</a>
	</nav>

	<header class="welcome">
		<h1>Welcome, <?= e(strtoupper($role)) ?></h1>
		<p class="who"><?= e($username) ?></p>
	</header>

	<main class="panel">
		<section class="section">
			<div class="section-head">
				<h2>Games</h2>
				<?php if ($isDeveloper): ?>
					<a class="btn sm" href="insertr_game.php">Add Game</a>
				<?php endif; ?>
			</div>
			<div class="table-wrap">
			<table class="data">
				<thead>
					<tr>
						<th>Game Title</th><th>Genre</th><th>Date Released</th><th>Platform</th>
						<?php if ($isDeveloper): ?><th>Action</th><?php endif; ?>
					</tr>
				</thead>
				<tbody>
				<?php if (!$games): ?>
					<tr><td colspan="<?= $isDeveloper ? 5 : 4 ?>" class="empty">No games yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($games as $row): ?>
					<tr>
						<td><?= e($row['GameTitle']) ?></td>
						<td><?= e($row['Genre']) ?></td>
						<td><?= e($row['DateReleased']) ?></td>
						<td><?= e($row['Platform']) ?></td>
						<?php if ($isDeveloper): ?>
						<td><a class="btn sm" href="update_game.php?id=<?= (int)$row['GameID'] ?>">Edit</a>
							<a class="btn sm" href="delete_game.php?id=<?= (int)$row['GameID'] ?>">Delete</a></td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</section>

		<section class="section">
			<div class="section-head"><h2>Reviews</h2></div>
			<div class="table-wrap">
			<table class="data">
				<thead>
					<tr><th>Tester ID</th><th>Rating</th><th>Feedback</th><th>Playtime</th><th>Bug Report</th></tr>
				</thead>
				<tbody>
				<?php if (!$reviews): ?>
					<tr><td colspan="5" class="empty">No reviews yet.</td></tr>
				<?php endif; ?>
				<?php foreach ($reviews as $row): ?>
					<tr>
						<td><?= e($row['TesterID']) ?></td>
						<td><?= e($row['rating']) ?></td>
						<td><?= e($row['feedback']) ?></td>
						<td><?= e($row['playtime']) ?></td>
						<td><?= e($row['Bugreport']) ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</section>
	</main>
</body>
</html>
