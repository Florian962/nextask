<?php
    class User {
        /* nu kunnen alle klassen ook aan deze PDO die deze klasse extenden */
        protected $pdo;

        /* zo kan deze klasse aan de db. */
        function __construct($pdo){
            $this->pdo = $pdo;
        }
               
        /* Function that checks if email is already in db. */
        function checkEmail ($email) {
            $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            }
            else {
                return false;
            }
        }

        public function loggedIn () {
            /* als er een session is returnt de functie true en anders fout. */
            return (isset($_SESSION['user_id'])) ? true : false;
        }

        /* Function that returns user data.  */
        public function userData($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        /* Function to register. */
        public function register ($username, $email, $hash) {
            $stmt = $this->pdo->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (:username, :email, :password)");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            $stmt->execute();

            /* Geeft laatst ingevoerde user id. */
            $user_id = $this->pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
        }

        /* Function to create table in db. */
        public function create($table, $fields = array()) {
            $columns = implode(',', array_keys($fields));
            $values  = ':'.implode(', :', array_keys($fields));
            $sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            /*var_dump($sql);*/
            if($stmt = $this->pdo->prepare($sql)){
                foreach ($fields as $key => $data) {
                    $stmt->bindValue(':'.$key, $data);
                }  
                $stmt->execute();
                return $this->pdo->lastInsertId();
            }
        }

        /* Function to update table in db. */
        public function update($table, $user_id, $fields = array()) {
            $columns = '';
            $i       = 1; /* om velden te tellen*/

            foreach ($fields as $name => $value) {
                $columns .= "`{$name}` = :{$name}";
                if($i < count($fields)) {
                    $columns .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
            if($stmt = $this->pdo->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    $stmt->bindValue(':'.$key, $value); 
                }
                /*var_dump($sql);*/
                $stmt->execute();
            }
        }

        /* Function to delete in db. */
        public function delete($table, $array) {
            $sql   = "DELETE FROM `{$table}`";
            $where = " WHERE ";

            foreach ($array as $name => $value) {
                $sql .= "{$where} `{$name}` = :{$name}";
                $where = " AND ";
            }

            if($stmt = $this->pdo->prepare($sql)) {
                foreach ($array as $name => $value) {
                    $stmt->bindValue(':'.$name, $value);
                }

                $stmt->execute();
            }
        }
    }
?>