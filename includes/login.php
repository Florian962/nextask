<?php
    //$as = new AuthenticationService();

    if(isset($_POST['login']) && !empty($_POST['login'])){
        $email    = $_POST['email'];
        $password = $_POST['password'];

        /*var_dump($password);*/
        if(!empty($email) or !empty($password)) {
            $email    = checkInput($email);
            $password = checkInput($password);
            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email format.";
            }
            else {
                
                if($as->login($email, $password) === false){
                    $error = "The email or password is incorrect.";
                }
            }
        }
        else {
            $error = "Please enter email and password.";
        }
    }
?>