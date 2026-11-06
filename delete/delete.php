<?php

include ("dbconn.php");

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = (int) $_GET['id'];
    $type = $_GET['type'];
} else {
    die("No id or type was provided.");
}

if ($type == "review") {
    $queries = [
        "DELETE FROM review WHERE reviewID = :id"
    ];
} elseif ($type == "feedback") {
    
    $queries = [
        "UPDATE review SET feedback = '' WHERE reviewID = :id"
    ];
} elseif ($type == "tester") {
    $queries = [
        "DELETE FROM review WHERE TesterID = :id",
        "DELETE FROM tester WHERE TesterID = :id"
    ];
} elseif ($type == "game") {
    $queries = [
        "DELETE FROM review WHERE GameID = :id",
        "DELETE FROM game WHERE GameID = :id"
    ];
} elseif ($type == "developer") {
    $queries = [
        "DELETE FROM review WHERE GameID IN (SELECT GameID FROM game WHERE DeveloperID = :id)",
        "DELETE FROM game WHERE DeveloperID = :id",
        "DELETE FROM developer WHERE DeveloperID = :id"
    ];
} else {
    die("Invalid type.");
}

try {
    $pdo->beginTransaction();

    foreach ($queries as $sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    $pdo->commit();
    header("Location: index.php?deleted=" . urlencode($type));
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error in deleting " . htmlspecialchars($type) . ": " . htmlspecialchars($e->getMessage());
}

?>