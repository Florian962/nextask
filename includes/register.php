<?php
    require_once '../core/classes/userService.php';

    if(isset($_POST['register'])){
        $us = new UserService();

        $username = $_POST['username-new'];
        $email    = $_POST['email-new'];

        $password = $_POST['password-new'];
        $passwordrepeat = $_POST['password-repeat'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $registererror    = "";
        /*var_dump($username);*/
        if(empty($username) or empty($email) or empty($password)) {
            $registererror = "All fields are required.";
        }
        else {
            $username = checkInput($username);
            $username = ucfirst($username);
            $email    = checkInput($email);
            $password = checkInput($password);
            $passwordrepeat = checkInput($passwordrepeat);

            if(!filter_var($email)){
                $registererror = "Invalid email format.";
            }
            else if (strlen($username) > 40){
                $registererror = "Your username is too long.";
            }
            else if (strlen($password) < 5){
                $registererror = "Your password is too short.";
            }
            else if ($password !== $passwordrepeat) {
                $registererror = "The passwords are not identical.";
            }
            else {
                if($us->checkEmail($email) === true){
                    $registererror = "The email is already in use.";
                }
                else {
                    $us->register($username, $email, $password, $hash);
                    var_dump("haha");
                    //header("Location: ../index.php");
                }
            } 
        }
    }
?>