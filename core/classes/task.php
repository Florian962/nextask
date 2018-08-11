<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        protected $pdo;

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        

    }
?>