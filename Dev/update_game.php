<?php
require 'dbconn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gameID = $_POST['GameID'];
    $gameTitle = $_POST['GameTitle'];
    $genre = $_POST['Genre'];
    $dateReleased = $_POST['DateReleased'];
    $platform = $_POST['Platform'];
    $developerID = $_POST['DeveloperID'];

    try {
        $sql = "UPDATE game 
                SET GameTitle = :title, 
                    Genre = :genre, 
                    DateReleased = :released, 
                    Platform = :platform, 
                    DeveloperID = :devID 
                WHERE GameID = :gameID";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title'    => $gameTitle,
            ':genre'    => $genre,
            ':released' => $dateReleased,
            ':platform' => $platform,
            ':devID'    => $developerID,
            ':gameID'   => $gameID
        ]);

        $message = "Game updated successfully! Rows affected: " . $stmt->rowCount();
    } catch (PDOException $e) {
        $message = "Error updating game records: " . $e->getMessage();
    }
}
?>
