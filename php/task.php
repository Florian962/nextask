<?php

    include '../core/init.php';
    
     /* Get user data. */
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    if($getFromU->loggedIn() === false)  {
        header('Location: php/welcome.php');
    }

    /* Get list data. */
    $listBy = $user_id;
    $list_id = $_GET['list_id'];
    $list = $getFromL->listData($list_id);

    /* Get task data */
    $task_id = $_GET['task_id'];

    /* Get comment data */
    $comments = $getFromT->comments($task_id);

    //var_dump($list_id);
    //var_dump($comments);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="../assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="../assets/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <title>NEXTASK | Task</title>
</head>
<body>
    <nav>
        <ul class="nav">	
            <li class="nav__link"><a href="../index.php"><img class="nav__link--logo" src="../assets/images/logo.png" alt=""></a></li>
            <li class="nav__link nav__link1"><a href="../index.php">Home</a></li>
            <li class="nav__link nav__link2"><a href="profile.php">My profile</a></li>
            <li class="nav__link nav__link3"><a href="logout.php">Log out</a></li>
        </ul>
    </nav>
    <main class="homepage">
        <section class="addlist">

            
            <h2>Add a comment to this task.</h2>
            <?php
                /* Display comment error */
                if(isset($commenterror)) {
                    echo '<div class="listerror"><p>'.$taskerror.'</p></div>';
                }
            ?>

            <form autocomplete="off" method="post" class="addlist__form">
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->username ?></span>, type a comment on this task.</label>
                    <input data-list="<?php echo $list_id ?>" data-task="<?php echo $task_id ?>" class="commentText" type="text" id="listtitle" name="comment">
                </div>

                <input id="postComment" class="addlist__form--submit" name="addcomment" type="submit" value="Add comment">
            </form>
        </section>
        <section class="lists">
                <article class="list">
                    <h3 class="task__title"><a href="list.php?list_id=<?php echo $list->list_id ?>"><?php echo $list->listtitle ?></a></h3>
                    <a href="#" class="list__delete" data-list="<?php echo $list->list_id ?>"><img src="<?php echo constant('BASE_URL'); ?>assets/images/bin.png" alt="bin" class="bin"></a>
                        <div class="task__block">
                            <?php
                                /* Display the tasks */
                                $getFromC->taskToComment($user_id, $listBy, $list_id, $task_id);
                            ?>
                            <div class="task__block--comments">

                                <?php
                                    /* Display the comments */
                                    foreach ($comments as $comment) {
                                        echo '
                                        <div class="comments__comment">
                                            <img src="../assets/images/profileIcon.png" class="comments__comment--profileIcon" alt="profileIcon">
                                            <p>'.$comment->comment.'</p>
                                            <a href="#" class="comment__delete" data-comment="'.$comment->comment_id.'"><img src="../assets/images/bin2.png" alt="bin" class="commentbin"></img></a>

                                        </div>
                                        
                                        ';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>            
                </article>        
          
        </section>
    <main>
    <footer>

    </footer>
    <script src="../assets/js/comment.js"></script>
    <script src="../assets/js/delete.js"></script>
    <script src="../assets/js/status.js"></script>
</body>
</html>