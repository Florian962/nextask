<?php

    include 'core/init.php';
    /*var_dump($_SESSION['user_id']);*/

    /* geef userdata voor juiste session ID */
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    /*if($getFromU->loggedIn() === false)  {
        header('Location: php/welcome.php');
    }*/

    $getFromU->update('users', $user_id, array('username' => 'florienew', 'email' => 'florienew@gmail?com'));


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <title>NEXTASK | Home</title>
</head>
<body>
    <nav>
        <ul class="nav">	
            <li class="nav__link"><a href="#"><img class="nav__link--logo" src="assets/images/logo.png" alt=""></a></li>
            <li class="nav__link nav__link1"><a href="#">Home</a></li>
            <li class="nav__link nav__link2"><a href="#">My profile</a></li>
            <li class="nav__link nav__link3"><a href="php/logout.php">Log out</a></li>
        </ul>
    </nav>
    <main class="homepage">
        <section class="addlist">

            <h2>Add a list.</h2>
            <?php
                if(isset($listerror)) {
                    echo '<div class="listerror"><p>'.$listerror.'</p></div>';
                }
            ?>

            <form autocomplete="off" method="post" class="addlist__form">
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->username ?></span>, type a title for your new list.</label>
                    <input type="text" id="listtitle" name="listtitle">
                </div>

                <input class="addlist__form--submit" name="addlist" type="submit" value="Add list">
            </form>
        </section>
        </section>
    <main>
    <footer>

    </footer>
</body>
</html>
