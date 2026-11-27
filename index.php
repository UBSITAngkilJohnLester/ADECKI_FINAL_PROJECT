<?php
session_start();

// messages are shown once, then cleared
$error   = $_SESSION['login_error'] ?? "";
$success = $_SESSION['register_success'] ?? "";
unset($_SESSION['login_error'], $_SESSION['register_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Indie Haus - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card">
        <h1>Indie Haus</h1>

        <?php if ($error != ""): ?>
            <p class="message error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success != ""): ?>
            <p class="message success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="field">
                <select name="role" aria-label="Role" required>
                    <option value="">-- Select role --</option>
                    <option value="Developer">Developer</option>
                    <option value="Tester">Tester</option>
                </select>
            </div>
            <div class="field">
                <input type="text" name="name" placeholder="Name" aria-label="Name" required>
            </div>
            <div class="field">
                <input type="password" name="password" placeholder="Password" aria-label="Password" required>
            </div>
            <div class="actions">
                <a href="register.php">Register</a>
                <button type="submit" name="login_btn">Login</button>
            </div>
        </form>
    </main>
</body>
</html>