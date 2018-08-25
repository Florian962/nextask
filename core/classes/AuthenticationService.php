<?php

require_once 'ValueObjects/User.php';

class AuthenticationService {

    protected $db;

    protected $user;

    public function __construct() {
        $this->db = Database::getInstance();

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
    }

    /* Function to login. */
    public function login($email, $password) {
            
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(":email", $email);
        $result = $stmt->execute();
        $checkUser = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($checkUser);
        //var_dump($password);
        if(!empty($checkUser)){
            //var_dump(password_verify($password, $checkUser['password']));
            if(password_verify($password, $checkUser['password']) ){
                $this->user = new User();
                $this->user->fetchUserFromDb($checkUser);
                $this->user->setLoggedIn();       
                
                $_SESSION['user'] = $this->user;

                header('Location: ../index.php');    
            }
            else {
                return false;
            }    
        }
    }

    /* Function to logout. */
    public function logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: ../php/welcome.php');
    }

    /* Function that checks if user is logged in or not. */
    public function loggedIn() {
        return (isset($_SESSION['user'])) ? true : false;
    }

    public function getLoggedInUser() {
        return $this->user;
    }

}