<?php
session_start();
include "dbconn.php";

if (!isset($_POST['login_btn'])) {
    header("Location: index.php");
    exit();
}

$role     = $_POST['role'] ?? "";
$name     = trim($_POST['name'] ?? "");
$password = $_POST['password'] ?? "";

if ($role == "Developer") {
    $stmt = $pdo->prepare("SELECT DeveloperID, DeveloperName, Password FROM developer WHERE DeveloperName = ?");
    $stmt->execute([$name]);
    $row = $stmt->fetch();

    if ($row && password_verify($password, $row['Password'])) {
        session_regenerate_id(true);
        $_SESSION["ROLE"]         = "Developer";
        $_SESSION["DEVELOPER_ID"] = $row['DeveloperID'];
        $_SESSION["NAME"]         = $row['DeveloperName'];
        header("Location: Dev/index.php");
        exit();
    }
} else if ($role == "Tester") {
    $stmt = $pdo->prepare("SELECT TesterID, TesterUsername, Password FROM tester WHERE TesterUsername = ?");
    $stmt->execute([$name]);
    $row = $stmt->fetch();

    if ($row && password_verify($password, $row['Password'])) {
        session_regenerate_id(true);
        $_SESSION["ROLE"]      = "Tester";
        $_SESSION["TESTER_ID"] = $row['TesterID'];
        $_SESSION["NAME"]      = $row['TesterUsername'];
        header("Location: Tester/index.php");
        exit();
    }
}

$_SESSION['login_error'] = "Wrong name or password.";
header("Location: index.php");
exit();