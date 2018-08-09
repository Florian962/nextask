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
    }
?>