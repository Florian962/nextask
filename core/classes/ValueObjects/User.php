<?php

class User {

    /* In deze class zitten alle properties voor de authenticion */
    protected $user_id;
    protected $username;
    protected $email;
    protected $password;
    protected $loggedIn = false;

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /* zet logged in op waar */
    public function setLoggedIn()
    {
        $this->loggedIn = true;
    }
    /* zet logged in op niet waar */
    public function setLoggedOut()
    {
        $this->loggedIn = false;;

        return $this;
    }

    public function fetchUserFromDb($fetchData) {
        $this->setUserId($fetchData['user_id']);
        $this->setUsername($fetchData['username']);
        $this->setEmail($fetchData['email']);
        $this->setPassword($fetchData['password']);
    }
}