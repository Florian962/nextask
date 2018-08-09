<?php

    if(isset($_POST['register'])){
        $username = $_POST['username-new'];
        $email    = $_POST['email-new'];
        $password = $_POST['password-new'];
        $registererror    = "";
        /*var_dump($username);*/
        if(empty($username) or empty($email) or empty($password)) {
            $registererror = "All fields are required.";
        }
        else {
            $username = $getFromU->checkInput($username);
            $email    = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email)){
                $registererror = "Invalid email format.";
            }
            else if (strlen($username) > 40){
                $registererror = "Your username is too long.";
            }
            else if (strlen($password) < 5){
                $registererror = "Your password is too short.";
            }
            else {
                if($getFromU->checkEmail($email) === true){
                    $registererror = "The email is already in use.";
                }
                else {
                    $getFromU->register($username, $email, $password);
                    header("Location: ../index.php");
                }
            }
        }
    }
?>