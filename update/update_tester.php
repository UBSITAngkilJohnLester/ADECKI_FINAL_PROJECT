<?php
require 'dbconn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testerID = $_POST['TesterID'];
    $testerUsername = $_POST['TesterUsername'];
    $gender = $_POST['Gender'];
    $playtime = $_POST['Playtime'];
    $age = $_POST['Age'];
    $genrePreferences = $_POST['GenrePreferences'];
    try {
        $sql = "UPDATE game 
                SET
                    TesterUsername = :TestName, 
                    Gender = :Gender, 
                    Playtime = :Playtime,
                    Age = :Age,
                    GenrePreferences = :GenPrefer,      
                WHERE TesterID = :TestID";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':testname'    => $developerName,
            ':gender'    => $developerStudio,
            ':playtime' => $gameEngine,
            ':age'    => $age,
            ':genprefer'    => $genrePreferences,
            ':TestID'    => $testerID,
        ]);

        $message = "Tester records updated successfully! Rows affected: " . $stmt->rowCount();
    } catch (PDOException $e) {
        $message = "Error updating tester records: " . $e->getMessage();
    }
}
?>