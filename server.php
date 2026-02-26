<?php
    
    $servername = "localhost";
    $dbname = "pornsiri";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e) {
        echo "Connecting Error : " . $e->getMessage();
    }
?>