<?php
    class User {
        protected $pdo;

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function checkInput($var) {
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripcslashes($var);
            return $var;
        }

        /* LOG IN FUNCTION */
        public function login($email, $password) {
            /*$password = md5($password);*/
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `email` = :email AND `password` = :password");
            
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
            $stmt->execute();
            
            $user  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if($count > 0) {
                $_SESSION['user_id'] = $user->user_id;
                header('Location: ../index.php');
            }
            else {
                return false;
            }
        }

        /* LOG OUT FUNCTION */
        public function logout() {
            $_SESSION = array();
            session_destroy();
            header('Location: ../php/welcome.php');
        }

        /* Checkt of de email al in de db staat. */
        public function checkEmail ($email) {
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

        /* CHECK IF LOGGED IN FUNCTION */
        public function loggedIn () {
            /* als er een session is returnt de functie true en anders fout. */
            return (isset($_SESSION['user_id'])) ? true : false;
        }

        /* REGISTER FUNCTION */
        public function register ($username, $email, $password) {
            $stmt = $this->pdo->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (:username, :email, :password)");
            $stmt->bindParam(":username", $email, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
            $stmt->execute();

            /* Geeft laatst ingevoerde user id. */
            $user_id = $this->pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
        }

        /* USERDATA FUNCTION  */
        public function userData($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        /* CREATE FUNCTION */
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

        /* UPDATE FUNCTION */
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




    }
?>