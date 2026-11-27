<?php
	session_start();
	date_default_timezone_set('Asia/Manila');
	require_once "../dbconn.php";

	if (($_SESSION['ROLE'] ?? '') !== 'Developer' || !isset($_SESSION['DEVELOPER_ID'])) {
		header("Location: ../index.php");
		exit;
	}

	$genres    = ['Adventure','Action','Metroid','RPG','Racing','Strategy','Sim','Horror','Puzzle','Sports'];
	$platforms = ['PC','Xbox','PlayStation','Handheld Game Console','Mobile'];
	$message = "";

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
		$title    = trim($_POST['gametitle'] ?? '');
		$genre    = $_POST['genre'] ?? '';
		$platform = $_POST['platform'] ?? '';
		$devID    = $_SESSION['DEVELOPER_ID'];

		if ($title === '' || !in_array($genre, $genres, true) || !in_array($platform, $platforms, true)) {
			$message = "Please fill in every field.";
		} else {
			try {
				$stmt = $pdo->prepare("INSERT INTO game (GameTitle, Genre, DateReleased, Platform, DeveloperID)
				                       VALUES (:title, :genre, :released, :platform, :dev)");
				$stmt->execute([
					':title'    => $title,
					':genre'    => $genre,
					':released' => date('Y-m-d'),
					':platform' => $platform,
					':dev'      => $devID,
				]);
				header("Location: index.php");
				exit;
			} catch (PDOException $e) {
				$message = "Could not save the game: " . $e->getMessage();
			}
		}
	}
	function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Game</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="dev_style.css">
</head>
<body>
	<main class="card">
		<h1>Post a Game</h1>
		<?php if ($message): ?><p class="message error"><?= e($message) ?></p><?php endif; ?>
		<form method="post">
			<div class="row">
				<label for="gametitle">Game Title</label>
				<input type="text" id="gametitle" name="gametitle" value="<?= e($_POST['gametitle'] ?? '') ?>" required>
			</div>
			<div class="row">
				<label for="genre">Game Genre</label>
				<select id="genre" name="genre" required>
					<option value="" selected disabled>Select a Genre</option>
					<?php foreach ($genres as $g): ?>
						<option value="<?= e($g) ?>"><?= e($g) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="row">
				<label for="platform">Platform</label>
				<select id="platform" name="platform" required>
					<option value="" selected disabled>Select a Platform</option>
					<?php foreach ($platforms as $p): ?>
						<option value="<?= e($p) ?>"><?= e($p) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="row">
                <label for="DateReleased">Released</label>
                <input type="date" id="DateReleased" name="DateReleased" min="<?= date('Y-m-d') ?>" value="<?= e($game['DateReleased']) ?>" required>
            </div>
			<div class="actions">
				<button type="submit" name="post">Post</button>
				<a href="index.php" class="btn alt">Cancel</a>
			</div>
		</form>
	</main>
</body>
</html>