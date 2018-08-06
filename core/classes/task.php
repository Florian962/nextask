<?php
    class Task extends User {
        //zo krijgen de taken info uit de user class
        protected $pdo;

        function __construct($pdo){
            $this->pdo = $pdo;
        }
    }
?>