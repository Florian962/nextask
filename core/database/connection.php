<?php
    $conn = 'mysql:host=185.182.57.42; dbname=floriob261_nextask';
    $user = 'floriob261_florian';
    $pass = 'xnHhJmq4';

    try {
        $pdo = new PDO($conn, $user, $pass);
    }
    catch(PDOException $e) {
        echo 'Connection error!' . $e->getMessage();
    }
?>