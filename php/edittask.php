<?php

    require_once '../core/init.php';
    require_once '../core/classes/User.php';
    require_once '../core/classes/List.php';
    require_once '../core/classes/Task.php';
    require_once '../core/classes/Comment.php';

    $getFromU = new User();
    $todolist = new Todolist();
    $task     = new Task();
    $comment  = new Comment();
    
     /* Get user data. */
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);

    /* Get list data. */
    $listBy = $user_id;
    $list_id = $_GET['list_id'];
    $list = $todolist->listData($list_id);

    /* Get task data */
    $task_id = $_GET['task_id'];

    $tasks = $comment->getTaskToComment($user_id, $listBy, $list_id, $task_id);

    //var_dump($task_id);
    //var_dump($list_id);
    //var_dump($comments);

    if(isset($_POST['changetask'])) {
        $taskTitle = checkInput($_POST['tasktask']);
        $taskImage = $_FILES['taskImage'];
        $fileRoot = '';
        $taskTitle = ucfirst($taskTitle);
        $duration  = checkInput($_POST['taskduration']);
        $deadline  = checkInput($_POST['taskdeadline']);

        $taskerror = '';

        //var_dump($list_id);

        //var_dump($list);
        //var_dump($deadline);
        //$taskImage = $getFromU->checkInput($_POST['taskImage']);
        //var_dump($deadline);
        //var_dump($_FILES['file'']);

        /* Check if task and duration is not empty. */
        if(!empty($task) AND !empty($duration)) {

            /* Check the length of task. */
            if(strlen($taskTitle) > 40) {
                $taskerror = "The task is too long.";
            }
            /* Check if task is already in list. */
            else if ($task->checkTask($taskTitle) === true) {
                $taskerror = "This task is already in the list.";
            }
            /* Check if deadline is in future. */
            else if(!empty($deadline)) {
                if( strtotime($deadline) < time() ) {
                    $taskerror = "Fill in a deadline that's in the future!";
                }
            }
            else if(!empty($taskImage)) {
                $fileRoot = uploadImage($taskImage);
                if ($fileRoot instanceof Exception) {
                    $taskerror = $fileRoot->getMessage();
                }
            }                 

        }
        else {
            $taskerror = "You forgot to fill in the task or the duration. 😅";
        }
         /* Wanneer geen errors, dan pas toevoegen taak in DB. */
         if($taskerror === '') {
            $task->updateTask('tasks', $task_id, array('task' => $taskTitle, 'duration' => $duration , 'deadline' => $deadline, 'taskImage' => $fileRoot, 'taskIn' => $list_id, 'taskStatus' => 'TO DO', 'taskActive' => 1));
        }
    }

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

            
            <h2>Edit the task.</h2>
            <?php
                /* Display comment error */
                if(isset($taskerror)) {
                    echo '<div class="listerror"><p>'.$taskerror.'</p></div>';
                }
            ?>

            <form enctype="multipart/form-data" autocomplete="off" method="post" class="addlist__form">
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->username ?></span>, change the task of the list. *</label>
                    <input type="text" id="listtitle" name="tasktask">
                </div>
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Change the duration. *</label>
                    <input class="input__duration" type="number" min="1" max="100" id="listtitle" name="taskduration">
                </div>
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="taskdeadline">And the deadline.</label>
                    <input type="date" min="01-01-2018" id="taskdeadline" name="taskdeadline" class="mindate">
                </div>

                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="taskImage">Do you want another file?</label>
                    <input type="file" id="taskImage" name="taskImage" class="taskImage">
                </div>

                <input class="addlist__form--submit" name="changetask" type="submit" value="Change task">
            </form>
        </section>
        <section class="lists">
                <article class="list">
                    <h3 class="task__title"><a href="list.php?list_id=<?php echo $list->list_id ?>"><?php echo $list->listtitle ?></a></h3>
                    <a href="#" class="list__delete" data-list="<?php echo $list->list_id ?>"><img src="<?php echo constant('BASE_URL'); ?>assets/images/bin.png" alt="bin" class="bin"></a>
                        <div class="task__block">
                            <?php foreach($tasks as $task): ?>
                                    <?php
                                        $deadline = $task->deadline;
                                        $dateToday = date("Y-m-d"); 
                                        /* SOURCE: https://stackoverflow.com/questions/676824/how-to-calculate-the-difference-between-two-dates-using-php */
                                        $diff = strtotime($deadline) - strtotime($dateToday);
                                        $years = floor($diff / (365*60*60*24));
                                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                    ?>
                                    <div class="task__block--hover task__block--bottom">
                                        <a href="edittask.php?task_id=<?= $task->task_id ?>&list_id=<?= $list_id ?>" class="task__block--edit"><img src="<?= BASE_URL ?>assets/images/edit.png" alt="Edit" class="taskbin"></a>
                                        <p class="task__block--task fat-text"><?= $task->task ?></p>
                                        <p class="task__block--duration"><?= $task->duration ?> hours</p>

                                        <?php if($task->deadline != 0): ?>
                                            <p class="task__block--deadline"><?= $task->deadline ?></p>

                                            <?php if($diff <0): ?>
                                                <p class="task__block--time danger">Deadline expired!</p>
                                            <?php elseif($days < 20): ?>
                                                <p class="task__block--time"><?= $days ?> days remaining.</p>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <a href="#" class="task__block--status" data-task="<?= $task->task_id ?>"><?= $task->taskStatus ?></a>
                                        <a href="list.php?list_id=<?= $task->list_id ?>" class="task__delete" data-task="<?= $task->task_id ?>"><img src="<?= BASE_URL ?>assets/images/bin.png" alt="bin" class="taskbin"></a>
                                    </div>
                                        <?php if(!empty($task->taskImage)): ?>
                                            <?php 
                                                $task->taskImage = substr($task->taskImage ,29); 
                                                
                                            ?>

                                            <img class="taskImageDisplay" src="<?= BASE_URL . 'users/' . $task->taskImage ?>" alt="">
                                            
                                        <?php endif; ?>
                                    
                                <?php endforeach; ?>

                            <div class="task__block--comments">
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