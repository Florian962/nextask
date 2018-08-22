<?php

    include '../core/init.php';
    
    /* Get user data. */
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    if($getFromU->loggedIn() === false)  {
        header('Location: php/welcome.php');
    }

    /* Check if edit profile btn is clicked. */
    if(isset($_POST['editprofile'])) {
        $task = $getFromU->checkInput($_POST['']);
        $taskImage = '';
        $task = ucfirst($task);
        $duration = $getFromU->checkInput($_POST['']);
        $deadline = $getFromU->checkInput($_POST['']);

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
                    $getFromL->create('tasks', array('task' => $task, 'duration' => $duration , 'deadline' => $deadline/*, `taskImage` => $fileRoot*/,'taskIn' => $list_id,'taskStatus' => 'TO DO','taskActive' => 1));
                }
            }
            else {
                if(!empty($_FILES['file']['name'][0])) {
                    $fileRoot = $getFromT->uploadImage($_FILES['file']);      
                }          
                $getFromL->create('tasks', array('task' => $task, 'duration' => $duration , 'deadline' => $deadline/*, `taskImage` => $fileRoot*/, 'taskIn' => $list_id,'taskStatus' => 'TO DO', 'taskActive' => 1));
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

    <title>NEXTASK | Profile</title>
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

            
            <h2>Change your profile.</h2>
            <?php
            /* Display profileerror */
                if(isset($profileerror)) {
                    echo '<div class="listerror"><p>'.$profileerror.'</p></div>';
                }
            ?>

            <form autocomplete="off" method="post" class="addlist__form">
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
                    <input type="file" id="taskImage" name="file" class="taskImage">
                </div>

                <input class="addlist__form--submit" name="addtask" type="submit" value="Add task">
            </form>
        </section>
        <section class="profile">
                          
        </section>
    <main>
    <footer>

    </footer>
    <script src="../assets/js/delete.js" ></script>
    <script src="../assets/js/status.js" ></script>
    <script src="../assets/js/mindate.js"></script>
    <script src="../assets/js/edit.js"   ></script>
</body>
</html>