<?php
session_start();
include "dbconn.php";

$error = "";
$role  = $_POST['role'] ?? "";

function old($key) {
    return htmlspecialchars($_POST[$key] ?? "");
}

if (isset($_POST['register_btn'])) {
    $password = $_POST['password'] ?? "";

    if ($password == "") {
        $error = "Enter a password.";
    } else if ($role == "Developer") {
        $name   = trim($_POST['dev_name'] ?? "");
        $studio = trim($_POST['dev_studio'] ?? "");
        $engine = trim($_POST['dev_engine'] ?? "");

        if ($name == "" || $studio == "" || $engine == "") {
            $error = "Fill in all developer fields.";
        } else {
            $stmt = $pdo->prepare("SELECT DeveloperID FROM developer WHERE DeveloperName = ?");
            $stmt->execute([$name]);

            if ($stmt->fetch()) {
                $error = "That developer name is already taken.";
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO developer (DeveloperName, DeveloperStudio, GameEngine, Password) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $studio, $engine, $hash]);

                $_SESSION['register_success'] = "Registered! You can log in now.";
                header("Location: index.php");
                exit();
            }
        }
    } else if ($role == "Tester") {
        $username = trim($_POST['tester_username'] ?? "");
        $gender   = $_POST['gender'] ?? "";
        $genre    = trim($_POST['genre'] ?? "");
        // these return false if the input is not a whole number in range
        $hours    = filter_var($_POST['playtime'] ?? "", FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 168]]);
        $age      = filter_var($_POST['age'] ?? "", FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 120]]);

        if ($username == "" || $genre == "" || !in_array($gender, ["M", "F", "O"])) {
            $error = "Fill in all tester fields.";
        } else if ($hours === false) {
            $error = "Playtime must be a whole number of hours from 0 to 168.";
        } else if ($age === false) {
            $error = "Age must be a whole number from 1 to 120.";
        } else {
      
            $playtime = $hours . ":00:00";

            $stmt = $pdo->prepare("SELECT TesterID FROM tester WHERE TesterUsername = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $error = "That tester username is already taken.";
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO tester (TesterUsername, Gender, Playtime, Age, GenrePreferences, Password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $gender, $playtime, $age, $genre, $hash]);

                $_SESSION['register_success'] = "Registered! You can log in now.";
                header("Location: index.php");
                exit();
            }
        }
    } else {
        $error = "Pick a role.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Indie Haus - Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card">
        <h1>Register</h1>

        <?php if ($error != ""): ?>
            <p class="message error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="register.php">
            <div class="row">
                <label for="role">Role</label>
                <select name="role" id="role" onchange="toggleFields()" required>
                    <option value="" selected disabled>-- Select --</option>
                    <option value="Developer" <?= $role == "Developer" ? "selected" : "" ?>>Developer</option>
                    <option value="Tester" <?= $role == "Tester" ? "selected" : "" ?>>Tester</option>
                </select>
            </div>

            <fieldset id="devFields" hidden disabled>
                <div class="row">
                    <label for="dev_name">Name</label>
                    <input type="text" id="dev_name" name="dev_name" value="<?= old('dev_name') ?>" placeholder="e.g. Juan Dela Cruz" maxlength="50" required>
                </div>
                <div class="row">
                    <label for="dev_studio">Studio</label>
                    <input type="text" id="dev_studio" name="dev_studio" value="<?= old('dev_studio') ?>" placeholder="e.g. Pixel Vault" maxlength="30" required>
                </div>
                <div class="row">
                    <label for="dev_engine">Game Engine</label>
                    <input type="text" id="dev_engine" name="dev_engine" value="<?= old('dev_engine') ?>" placeholder="e.g. Godot" maxlength="20" required>
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
            </fieldset>

            <fieldset id="testerFields" hidden disabled>
                <div class="row">
                    <label for="tester_username">Username</label>
                    <input type="text" id="tester_username" name="tester_username" value="<?= old('tester_username') ?>" placeholder="e.g. juan_plays" maxlength="100" required>
                </div>
                <div class="row">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <?php foreach (["M" => "Male", "F" => "Female", "O" => "Other"] as $value => $text): ?>
                            <option value="<?= $value ?>" <?= ($_POST['gender'] ?? "") == $value ? "selected" : "" ?>><?= $text ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <label for="playtime">Playtime</label>
                    <input type="number" id="playtime" name="playtime" value="<?= old('playtime') ?>" placeholder="Hours per week" min="0" max="168" required>
                </div>
                <div class="row">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?= old('age') ?>" placeholder="e.g. 18" min="1" max="120" required>
                </div>
                <div class="row">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="<?= old('genre') ?>" placeholder="e.g. RPG" maxlength="20" required>
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
            </fieldset>

            

            <div class="actions">
                <a href="index.php">Back</a>
                <button type="submit" name="register_btn">Register</button>
            </div>
        </form>
    </main>

    <script>
 
        function toggleFields() {
            var role = document.getElementById("role").value;
            var groups = { devFields: "Developer", testerFields: "Tester" };

            for (var id in groups) {
                var box = document.getElementById(id);
                box.hidden = box.disabled = (role != groups[id]);
            }
        }
        toggleFields();
    </script>
</body>
</html>