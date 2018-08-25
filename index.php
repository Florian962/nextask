<?php

    include_once 'core/init.php';
    require_once 'core/classes/ListService.php';
    require_once 'core/classes/ValueObjects/List.php';

    $ls = new listService();
    
    /* Get all the TodoLists for the logged in user. */
    $lists = $ls->getLists($user->getUserId());

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
<<<<<<< HEAD
                $ls->createList(array('listtitle' => $listtitle, 'listBy' => $user->getUserId(), 'listPostedOn' => date('Y-m-d H:i'), 'listActive' => 1));
                //????header('Location: php/list.php?list_id='$list_id'');
=======
                $getFromU->create('lists', array('listtitle' => $listtitle, 'listBy' => $user_id, 'listPostedOn' => date('Y-m-d H:i'), 'listActive' => 1));
                
>>>>>>> parent of dea531c... Add db class properties
            }
        }
        else {
            $listerror = "Please fill in a title for your list.";
        }
    }

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
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->getUsername() ?></span>, type a title for your new list.</label>
                    <input type="text" id="listtitle" name="listtitle">
                </div>

                <input class="addlist__form--submit" name="addlist" type="submit" value="Add list">
            </form>
        </section>
        <section class="lists">
            <?php foreach ($lists as $list): ?>
                    <article class="list">
                        <a href="/php/list.php?list_id=<?php echo $list->getTodoListId(); ?>" class="list__title"><h3><?= $list->getTodoListName(); ?></h3></a>
                        <a href="#" class="list__delete" data-list="<?php echo $list->getTodoListId(); ?>"><img src="/assets/images/bin.png" alt="bin" class="bin"></a>
                    </article>
                <?php endforeach; ?>
        </section>
    <main>
    <footer>

    </footer>
    <script src="assets/js/delete.js"></script>
</body>
</html>
