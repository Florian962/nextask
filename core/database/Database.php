<?php

class Database {
    private static $instance;
    private $pdo;
    private $host = 'localhost';
    private $database = 'nextask';
    private $user = 'root';
    private $password = 'root';

    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->database,
                $this->user, $this->password);
        }
        catch(PDOException $e) {
            echo 'Connection error!' . $e->getMessage();
        }
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPDO() {
        return $this->pdo;
    }
}