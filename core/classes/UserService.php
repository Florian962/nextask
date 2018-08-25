<?php
    require_once 'AuthenticationService.php';

    class UserService {

        protected $db;
    
        public function __construct() {
            $this->db = Database::getInstance();
        }

        /* Function that checks if email is already in db. */
        function checkEmail ($email) {
            $stmt = $this->db->getPDO()->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
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

        public function register ($username, $email, $password, $hash) {
            $stmt = $this->db->getPDO()->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (:username, :email, :password)");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            $stmt->execute();

            
            $as = new AuthenticationService();
            $as->login($email, $password);
        }

    }