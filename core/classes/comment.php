<?php
     //met extends krijgen de taken info uit de user list
    class Comment extends Task {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        
        

    }
?>