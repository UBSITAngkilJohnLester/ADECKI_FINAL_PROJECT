<?php
session_start();
include "dbconn.php";

if (isset($_POST['login_btn'])) {
    $role     = $_POST['role'];
    $name     = trim($_POST['name']);
    $password = $_POST['password'];

    if ($role == "Developer") {
        $stmt = $pdo->prepare("SELECT DeveloperID, DeveloperName, Password FROM developer WHERE DeveloperName = ?");
        $stmt->execute([$name]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['Password'])) {
            $_SESSION["ROLE"]         = "Developer";
            $_SESSION["DEVELOPER_ID"] = $row['DeveloperID'];
            $_SESSION["NAME"]         = $row['DeveloperName'];
            header("location:Dev/index.php");
            exit();
        }
    } else if ($role == "Tester") {
        $stmt = $pdo->prepare("SELECT TesterID, TesterUsername, Password FROM tester WHERE TesterUsername = ?");
        $stmt->execute([$name]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['Password'])) {
            $_SESSION["ROLE"]      = "Tester";
            $_SESSION["TESTER_ID"] = $row['TesterID'];
            $_SESSION["NAME"]      = $row['TesterUsername'];
            header("location:Tester/index.php");
            exit();
        }
    }

    echo "<script>alert('Wrong name or password');</script>";
}
?>
