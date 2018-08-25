<?php

include_once 'ValueObjects/User.php';

class AuthenticationService {

    protected $db;
    protected $user;

    public function __contruct() {
        $this->db = Database::getInstance();

        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
    }

     /* Function that checks if user is logged in or not. */
    public function loggedIn() {
        return (isset($_SESSION['user'])) ? true : false;
    }

    public function getLoggedInUser() {
        return $this->user;
    }

    

}