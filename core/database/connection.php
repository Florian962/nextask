<?php
    $conn = 'mysql:host=localhost; dbname=nextask';
    $user = 'root';
    $pass = 'root';

    try {
        $pdo = new PDO($conn, $user, $pass);
    }
    catch(PDOException $e) {
        echo 'Connection error!' . $e->getMessage();
    }
?>