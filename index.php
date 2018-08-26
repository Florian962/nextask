<?php

    include 'core/init.php';
    include 'core/classes/List.php';
    include 'core/classes/User.php';

    $getFromU = new User();
    $todolist = new TodoList();
    
    /* Get user data. */
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);

    
    /* Get list data. */
    $listBy = $user_id;

    /* Check if add list btn is clicked. */
    if(isset($_POST['addlist'])) {
        $listtitle = checkInput($_POST['listtitle']);
        $listtitle = ucfirst($listtitle).'.';

        /* Check if list title is not empty. */
        if(!empty($listtitle)) {
            /* Check length of task. */
            if(strlen($listtitle) > 50) {
                $listerror = "Fill in a title with less than 50 characters.";
            }
            else {
                $todolist->createList('lists', array('listtitle' => $listtitle, 'listBy' => $user_id, 'listPostedOn' => date('Y-m-d H:i'), 'listActive' => 1));
                
            }
        }
        else {
            $listerror = "Please fill in a title for your list.";
        }
    }

    //var_dump($_SESSION['user_id']);*/
    //$getFromU->delete('lists', array('list_id' => '6'));
    //header('Location: php/list.php?list_id='..'');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <title>NEXTASK | Home</title>
</head>
<body>
    <nav>
        <ul class="nav">	
            <li class="nav__link"><a href="index.php"><img class="nav__link--logo" src="assets/images/logo.png" alt=""></a></li>
            <li class="nav__link nav__link1"><a href="index.php">Home</a></li>
            <li class="nav__link nav__link2"><a href="php/profile.php">My profile</a></li>
            <li class="nav__link nav__link3"><a href="php/logout.php">Log out</a></li>
        </ul>
    </nav>
    <main class="homepage">
        <section class="addlist">

            
            <h2>Add a list.</h2>
            <?php
                /* Display list error. */
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
        <section class="lists">
                    <?php
                        /* Display lists. */
                        $todolist->getLists($user_id, $listBy);
                    ?>      
          
        </section>
    <main>
    <footer>

    </footer>
    <script src="assets/js/delete.js"></script>
</body>
</html>
