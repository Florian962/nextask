<?php
    include '../core/init.php';
    include '../includes/login.php';
    include '../includes/register.php';
    
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="Images/logo.png">
    <link type="text/css" rel="stylesheet" href="../assets/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <title>NEXTASK | Welcome.</title>
</head>
<body>

    <nav>
        <ul class="nav">	
            <li class="nav__link"><a href="#"><img class="nav__link--logo" src="../assets/images/logo.png" alt=""></a></li>
            <li class="nav__link nav__link1"><a href="#">Enterprise</a></li>
            <li class="nav__link nav__link2"><a href="#">New features</a></li>
            <li class="nav__link nav__link3"><a href="#">Contact</a></li>
        </ul>
    </nav>
    <main class="welcomescreen">
        <section class="register">

            <h1>Welcome to Nextask.</h1>
            <h2>Register.</h2>        

            <form class="register__form">
                <div class="register__form--fields register__form--email-new">
                    <label for="email-new">Email</label>
                    <input type="email" id="email-new" name="email-new">
                </div>
                <div class="register__form--fields register__form--username">
                    <label for="username-new">Username</label>
                    <input type="text" id="username-new" name="username">
                </div>
                <div class="register__form--fields register__form--password">
                    <label for="password-new">Password</label>
                    <input type="password" id="password-new" name="password">
                </div>
                <div class="register__form--fields register__form--repeatpassword">
                    <label for="repeatpassword">Repeat password</label>
                    <input type="password" id="repeatpassword" name="repeatpassword">
                </div>
                
                <input class="register__form--submit" type="submit" value="sign in">
                
            </form>
            
        </section>
        <section class="login">

            <h1>Your to do app.</h1>
            <h2>log in.</h2>
            <?php
                if(isset($error)) {
                    echo '<div class="error"><p>'.$error.'</p></div>';
                }
            ?>

            <form autocomplete="off" method="post" class="login__form">
                <div class="login__form--fields login__form--email">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="login__form--fields login__form--password">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <input class="login__form--submit" name="login" type="submit" value="login">
                <div class="whitespace">

                </div>
            </form>
        </section>
    <main>
    <footer>

    </footer>
</body>
</html>