<?php
session_start();
include "dbconn.php";

$error = "";

if (isset($_POST['register_btn'])) {
    $role     = $_POST['role'];
    $password = $_POST['password'];

    if ($password == "") {
        $error = "Enter a password.";
    } else if ($role == "Developer") {
        $name   = trim($_POST['dev_name']);
        $studio = trim($_POST['dev_studio']);
        $engine = trim($_POST['dev_engine']);

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

                echo "<script>alert('Registered! You can log in now.'); window.location='index.php';</script>";
                exit();
            }
        }
    } else if ($role == "Tester") {
        $username = trim($_POST['tester_username']);
        $gender   = $_POST['gender'];
        $hours    = $_POST['playtime'];
        $age      = (int)$_POST['age'];
        $genre    = trim($_POST['genre']);

        if ($username == "" || $hours === "" || $hours < 0 || $hours > 838 || $age < 1 || $genre == "") {
            $error = "Fill in all tester fields.";
        } else {
            // the column is a TIME type, so 3 hours is saved as 3:00:00
            $playtime = (int)$hours . ":00:00";

            $stmt = $pdo->prepare("SELECT TesterID FROM tester WHERE TesterUsername = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $error = "That tester username is already taken.";
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO tester (TesterUsername, Gender, Playtime, Age, GenrePreferences, Password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $gender, $playtime, $age, $genre, $hash]);

                echo "<script>alert('Registered! You can log in now.'); window.location='index.php';</script>";
                exit();
            }
        }
    } else {
        $error = "Pick a role.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if ($error != "") echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <table cellpadding="5">
            <tr>
                <td>Role</td>
                <td>
                    <select name="role" id="role" onchange="toggleFields()" required>
                        <option value="">-- Select role --</option>
                        <option value="Developer">Developer</option>
                        <option value="Tester">Tester</option>
                    </select>
                </td>
            </tr>

            <!-- Developer fields -->
            <tbody id="devFields" style="display:none;">
                <tr>
                    <td>Developer Name</td>
                    <td><input type="text" name="dev_name" placeholder="e.g. Juan Dela Cruz" maxlength="50"></td>
                </tr>
                <tr>
                    <td>Studio</td>
                    <td><input type="text" name="dev_studio" placeholder="e.g. Pixel Vault" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Game Engine</td>
                    <td><input type="text" name="dev_engine" placeholder="e.g. Godot" maxlength="20"></td>
                </tr>
            </tbody>

            <!-- Tester fields -->
            <tbody id="testerFields" style="display:none;">
                <tr>
                    <td>Tester Username</td>
                    <td><input type="text" name="tester_username" placeholder="e.g. juan_plays" maxlength="100"></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <select name="gender">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Playtime</td>
                    <td><input type="text" name="playtime" placeholder="e.g. 3 (hours) per week"></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input type="text" name="age" placeholder="e.g. 18"></td>
                </tr>
                <tr>
                    <td>Genre Preference</td>
                    <td><input type="text" name="genre" placeholder="e.g. RPG" maxlength="20"></td>
                </tr>
            </tbody>

            <!-- Password (both roles) -->
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" placeholder="Enter password" required></td>
            </tr>

            <tr>
                <td></td>
                <td><button type="submit" name="register_btn">Register</button></td>
            </tr>
        </table>
    </form>

    <script>
        function toggleFields() {
            var role = document.getElementById("role").value;
            document.getElementById("devFields").style.display = (role == "Developer") ? "table-row-group" : "none";
            document.getElementById("testerFields").style.display = (role == "Tester") ? "table-row-group" : "none";
        }
    </script>
</body>
</html>