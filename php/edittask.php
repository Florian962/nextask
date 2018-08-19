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

    //var_dump($task_id);
    //var_dump($list_id);
    //var_dump($comments);

    if(isset($_POST['addtask'])) {
        $task = $getFromU->checkInput($_POST['tasktask']);
        $taskImage = '';
        $task = ucfirst($task);
        $duration = $getFromU->checkInput($_POST['taskduration']);
        $deadline = $getFromU->checkInput($_POST['taskdeadline']);

        //var_dump($list_id);

        //var_dump($list);
        //var_dump($deadline);
        //$taskImage = $getFromU->checkInput($_POST['taskImage']);
        //var_dump($deadline);
        //var_dump($_FILES['file'']);

        /* Check if task and duration is not empty. */
        if(!empty($task) AND !empty($duration)) {

            /* Check the length of task. */
            if(strlen($task) > 40) {
                $taskerror = "The task is too long.";
            }
            /* Check if task is already in list. */
            else if ($getFromT->checkTask($task) === true) {
                $taskerror = "This task is already in the list.";
            }
            /* Check if deadline is in future. */
            else if(!empty($deadline)) {
                if( strtotime($deadline) < time() ) {
                    $taskerror = "Fill in a deadline that's in the future!";
                }

                else {
                    if(!empty($_FILES['file']['name'][0])) {
                        $fileRoot = $getFromT->uploadImage($_FILES['file']);                    
                    }
                    $getFromL->updateTask('tasks', $task_id, array('task' => $task, 'duration' => $duration , 'deadline' => $deadline/*, `taskImage` => $fileRoot*/));
                }
            }
            else {

                if(!empty($_FILES['file']['name'][0])) {
                    $fileRoot = $getFromT->uploadImage($_FILES['file']);      
                }        
                $getFromL->updateTask('tasks', $task_id, array('task' => $task, 'duration' => $duration , 'deadline' => $deadline/*, `taskImage` => $fileRoot*/));
            }
           
        }
        else {
            $taskerror = "You forgot to fill in the task or the duration. 😅";
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
            <li class="nav__link nav__link2"><a href="#">My profile</a></li>
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

            <form autocomplete="off" method="post" class="addlist__form">
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
                    <input type="file" id="taskImage" name="file" class="taskImage">
                </div>

                <input class="addlist__form--submit" name="addtask" type="submit" value="Add task">
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