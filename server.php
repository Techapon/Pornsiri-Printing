<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pornsiri";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "เป็นเรื่องแล้วไง!!: " . $e->getMessage();
    }
?>
