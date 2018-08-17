<?php

    include '../core/init.php';
    
    $user_id = $_SESSION['user_id'];
    $listBy = $user_id;
    $user = $getFromU->userData($user_id);
    if($getFromU->loggedIn() === false)  {
        header('Location: php/welcome.php');
    }

    $list_id = $_GET['list_id'];
    //var_dump($list_id);
    $list = $getFromL->listData($list_id);
    //var_dump($list);

    if(isset($_POST['addtask'])) {
        $task = $getFromU->checkInput($_POST['tasktask']);
        $taskImage = '';
        $task = ucfirst($task);
        
        $duration = $getFromU->checkInput($_POST['taskduration']);
        $deadline = $getFromU->checkInput($_POST['taskdeadline']);
        //$taskImage    = $getFromU->checkInput($_POST['taskImage']);
        //var_dump($deadline);
        //var_dump($_FILES['file'']);

        if(!empty($task) AND !empty($duration)) {
            if(strlen($task) > 40) {
                $taskerror = "The task is too long.";
            }

            else if(!empty($deadline)) {
                if( strtotime($deadline) < time() ) {
                    $taskerror = "Fill in a deadline that's in the future!";
                }

                else {
                    if(!empty($_FILES['file']['name'][0])) {
                        $fileRoot = $getFromT->uploadImage($_FILES['file']);                    
                    }
                    $getFromL->create('tasks', array('task' => $task, 'duration' => $duration , 'deadline' => $deadline, `taskImage` => $fileRoot,'taskIn' => $list_id,'taskStatus' => 'TO DO','taskActive' => 1));
                }
            }
            else {
                if(!empty($_FILES['file']['name'][0])) {
                    $fileRoot = $getFromT->uploadImage($_FILES['file']);      
                }          
                $getFromL->create('tasks', array('task' => $task, 'duration' => $duration , 'deadline' => $deadline, `taskImage` => $fileRoot, 'taskIn' => $list_id,'taskStatus' => 'TO DO', 'taskActive' => 1));
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
        <section class="lists">
                <article class="list">
                    <h3 class="task__title"><a href="list.php?list_id=<?php echo $list->list_id ?>"><?php echo $list->listtitle ?></a></h3>
                    <a href="../index.php" class="list__delete" data-list="<?php echo $list->list_id ?>"><img src="<?php echo constant('BASE_URL'); ?>assets/images/bin.png" alt="bin" class="bin"></a>
                        <div class="task__block">
                            <?php
                                $getFromT->tasks($user_id, $listBy, $list_id);
                            ?>
                        </div>                  
                </article>        
          
        </section>
    <main>
    <footer>

    </footer>
    <script src="../assets/js/delete.js"></script>
    <script src="../assets/js/status.js"></script>
    <script src="../assets/js/mindate.js"></script>
</body>
</html>