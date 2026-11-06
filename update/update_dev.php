<?php
require 'dbconn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $developerID = $_POST['DeveloperID'];
    $developerName = $_POST['DeveloperName'];
    $developerStudio = $_POST['DeveloperStudio'];
    $gameEngine = $_POST['GameEngine'];
    try {
        $sql = "UPDATE game 
                SET
                    DeveloperName = :DevName, 
                    DeveloperStudio = :DevStudio, 
                    GameEngine = :GameEngine,      
                WHERE DeveloperID = :DevID";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':devname'    => $developerName,
            ':devstudio'    => $developerStudio,
            ':gameengine' => $gameEngine,
            ':devID'    => $developerID,
        ]);

        $message = "Developer records updated successfully! Rows affected: " . $stmt->rowCount();
    } catch (PDOException $e) {
        $message = "Error updating developer records: " . $e->getMessage();
    }
}
?>