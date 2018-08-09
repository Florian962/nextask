<?php

    if(isset($_POST['login']) && !empty($_POST['login'])){
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        var_dump($password);
        if(!empty($email) or !empty($password)) {
            $email    = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email format.";
            }
            else {
                if($getFromU->login($email, $password) === false){
                    $error = "The email or password is incorrect.";
                }
            }
        }
        else {
            $error = "Please enter email and password.";
        }
    }
?>