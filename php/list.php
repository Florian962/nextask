<?php

    include '../core/init.php';
    
    $user_id = $_SESSION['user_id'];
    $listBy = $user_id;
    $user = $getFromU->userData($user_id);

    $list_id = $_GET['list_id'];
    //var_dump($list_id);
    $list = $getFromL->listData($list_id);
    //var_dump($list);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="../assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="../assets/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <title>NEXTASK | List</title>
</head>
<body>
    <nav>
        <ul class="nav">	
            <li class="nav__link"><a href="../index.php"><img class="nav__link--logo" src="../assets/images/logo.png" alt=""></a></li>
            <li class="nav__link nav__link1"><a href="../index.php">Home</a></li>
            <li class="nav__link nav__link2"><a href="#">My profile</a></li>
            <li class="nav__link nav__link3"><a href="logout.php">Log out</a></li>
        </ul>
    </nav>
    <main class="homepage">
        <section class="addlist">

            
            <h2>Add tasks to your list.</h2>
            <?php
                if(isset($taskerror)) {
                    echo '<div class="listerror"><p>'.$taskerror.'</p></div>';
                }
            ?>

            <form autocomplete="off" method="post" class="addlist__form">
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->username ?></span>, type a task for your new list.</label>
                    <input type="text" id="listtitle" name="listtitle">
                </div>

                <input class="addlist__form--submit" name="addlist" type="submit" value="Add task">
            </form>
        </section>
        <section class="lists">
                <article class="list">
                    <h3 class="list__title2"><?php echo $list->listtitle ?></h3>
                    <a href="#" class="list__delete" data-list="<?php echo $list->list_id ?>"><img src="<?php echo constant('BASE_URL'); ?>assets/images/bin.png" alt="bin" class="bin"></a>
                    <a href="#" class="list__tasks">
                        <ul class="list__block">
                                <li class="list__block--task fat-text">Task</li>
                                <li class="list__block--duration">2h & 20min</li>
                                <li class="list__block--deadline">08/09/18</li>
                        </ul> 
                    </a>                 
                </article>        
          
        </section>
    <main>
    <footer>

    </footer>
</body>
</html>