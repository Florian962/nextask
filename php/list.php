<?php

    require_once '../core/init.php';
    require_once '../core/classes/User.php';
    require_once '../core/classes/List.php';
    require_once '../core/classes/Task.php';
    
    $getFromU = new User();
    /* Get user data. */   
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);

    $todolist = new Todolist();
    /* Get list data. */
    $listBy = $user_id;
    $list_id = $_GET['list_id'];
    $list = $todolist->listData($list_id);

    
    
    /* Check if add task btn is clicked. */
    if(isset($_POST['addtask'])) {
        $taskTitle  = checkInput($_POST['tasktask']);
        $taskTitle  = ucfirst($taskTitle);
        $taskImage = $_FILES['taskImage'];
        $fileRoot = '';
        $duration  = checkInput($_POST['taskduration']);
        $deadline  = checkInput($_POST['taskdeadline']);

        $taskerror = '';

        $task = new Task();

        /* Check if task and duration is not empty. */
        if(!empty($taskTitle) AND !empty($duration)) {
            /* Check the length of task. */
            if(strlen($taskTitle) > 40) {
                $taskerror = "The task is too long.";
            }
            /* Check if task is already in list. */
            else if ($task->checkTask($taskTitle) === true) {
                $taskerror = "This task is already in the list.";
            }
            /* Check if deadline is in future. */
            if(!empty($deadline)) {
                if( strtotime($deadline) < time() ) {
                    $taskerror = "Fill in a deadline that's in the future!";
                }
            }
            var_dump($taskImage['name']);
            if(!empty($taskImage['name'])) {
                $fileRoot = uploadImage($taskImage);
                //var_dump($fileRoot);
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
            //$taskerror ="geen errors";
            
            $task->createTask('tasks', array('task' => $taskTitle, 'duration' => $duration , 'deadline' => $deadline, 'taskImage' => $fileRoot, 'taskIn' => $list_id, 'taskStatus' => 'TO DO', 'taskActive' => 1));
        }
    }

    /* Display tasks. */
    $tasks = $todolist->getTodoListTasks($user_id, $listBy, $list_id);
    
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

    <title>NEXTASK | List</title>
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

            
            <h2>Add tasks to your list.</h2>
            <?php
            /* Display taskerror */
                if(isset($taskerror)) {
                    echo '<div class="listerror"><p>'.$taskerror.'</p></div>';
                }
            ?>

            <form enctype="multipart/form-data" autocomplete="off" method="post" class="addlist__form">
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Hi <span class="fat-text"><?=$user->username ?></span>, type a task for your new list. *</label>
                    <input type="text" id="listtitle" name="tasktask">
                </div>
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="listtitle">Fill in the duration of the task (in hours). *</label>
                    <input class="input__duration" type="number" min="1" max="100" id="listtitle" name="taskduration">
                </div>
                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="taskdeadline">And the deadline.</label>
                    <input type="date" min="01-01-2018" id="taskdeadline" name="taskdeadline" class="mindate">
                </div>

                <div class="addlist__form--fields addlist__form--listtitle">
                    <label for="taskImage">If you want, you can add a file.</label>
                    <input type="file" id="taskImage" name="taskImage" class="taskImage">
                </div>

                <input class="addlist__form--submit" name="addtask" type="submit" value="Add task">
            </form>
        </section>
        <section class="lists">
                <article class="list">
                    <h3 class="task__title"><a href="list.php?list_id=<?php echo $list->list_id ?>"><?php echo $list->listtitle ?></a></h3>
                    <a href="../index.php" class="list__delete" data-list="<?php echo $list->list_id ?>"><img src="<?php echo constant('BASE_URL'); ?>assets/images/bin.png" alt="bin" class="bin"></a>
                        <div class="task__block">

                            <?php foreach ($tasks as $task):?>
                                <?php 
                                    $deadline = $task->deadline;
                                    $dateToday = date("Y-m-d"); 
                                    /* SOURCE: https://stackoverflow.com/questions/676824/how-to-calculate-the-difference-between-two-dates-using-php */
                                    $diff = strtotime($deadline) - strtotime($dateToday);
                                    $years = floor($diff / (365*60*60*24));
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                ?>
                                
                                <div class="task__block--hover">
                                    <a href="edittask.php?task_id=<?= $task->task_id ?>&list_id=<?= $list_id ?>" class="task__block--edit"><img src="<?= BASE_URL ?>assets/images/edit.png" alt="Edit" class="taskbin"></a>
                                    <a class="task__block--task fat-text underline" href="<?= BASE_URL ?>php/task.php?task_id=<?= $task->task_id ?>&list_id=<?= $list_id ?>"><?= $task->task ?></a>
                                    <a class="task__block--duration" href="<?= BASE_URL ?>php/task.php?task_id=<?= $task->task_id ?>&list_id=<?= $list_id ?>"><?= $task->duration ?> hours</a>
                                    
                                    <?php if($task->deadline != 0): ?>
                                        <a class="task__block--deadline" href="<?= BASE_URL ?>php/task.php?task_id=<?= $task->task_id ?>&list_id=<?= $list_id ?>"><?= $task->deadline ?></a>
                                        <?php if ($diff <0): ?>
                                            <p class="task__block--time danger">Deadline expired!</p>
                                        <?php elseif($days < 20): ?>
                                            <p class="task__block--time"><?= $days ?> days remaining.</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                
                                    <a href="" class="task__block--status" data-task="<?= $task->task_id ?>"><?= $task->taskStatus ?></a>
                                    <a href="#" class="task__delete" data-task="<?= $task->task_id ?>"><img src="<?= BASE_URL ?>assets/images/bin.png" alt="bin" class="taskbin"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>                  
                </article>        
          
        </section>
    <main>
    <footer>

    </footer>
    <script src="../assets/js/delete.js" ></script>
    <script src="../assets/js/status.js" ></script>
    <script src="../assets/js/mindate.js"></script>
</body>
</html>