<?php
require 'dbconn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewID = $_POST['ReviewID'];
    $rating = $_POST['Rating'];
    $feedback = $_POST['Feedback'];
    $playtime = $_POST['Playtime'];
    $gameID = $_POST['GameID'];
    $testerID = $_POST['TesterID'];
    $bugReport = $_POST['BugReport'];
    try {
        $sql = "UPDATE review 
                SET
                    ReviewID = :RevID, 
                    Rating = :Rating,
                    Feedback = :Feedback, 
                    Playtime = :Playtime,
                    GameID = :GameID,
                    TesterID = :TestID,
                    BugReport = :BugReport,      
                WHERE ReviewID = :ReviewID";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':reviewID'    => $developerName,
            ':rating'    => $developerStudio,
            ':feedback'    => $Feedback,
            ':playtime' => $Playtime,
            ':gameID'    => $GameID,
            ':testID'    => $TesterID,
            ':BugReport'    => $BugReport,
        ]);

        $message = "Review records updated successfully! Rows affected: " . $stmt->rowCount();
    } catch (PDOException $e) {
        $message = "Error updating review records: " . $e->getMessage();
    }
}
?>