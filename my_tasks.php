<?php
include("nav.php");
// include("nav.php");
// if(isset($_GET['sprint_id'])){
//     $sprint_id=$_GET['sprint_id'];
// }

if(!isset($_SESSION['user_id']))
    header ("Location: index.php");

$user_id=$_SESSION['user_id'];

$select1 = "SELECT * FROM `task` 
JOIN category ON `task`.`category_id` = `category`.`category_id`
JOIN priority ON `task`.`priority_id` = `priority`.`priority_id`
JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
WHERE `task_status`= 1 AND `task`.`hidden` = 'unarchive' AND `task`.`assignie`='$user_id'";
$Run1 = mysqli_query($connect, $select1);

$select2 = "SELECT * FROM `task` 
JOIN category ON `task`.`category_id` = `category`.`category_id`
JOIN priority ON `task`.`priority_id` = `priority`.`priority_id`
JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
WHERE `task_status`= 2 AND `task`.`hidden` = 'unarchive' AND `task`.`assignie`='$user_id'";
$Run2 = mysqli_query($connect, $select2);

$select3 = "SELECT * FROM `task` 
JOIN category ON `task`.`category_id` = `category`.`category_id`
JOIN priority ON `task`.`priority_id` = `priority`.`priority_id`
JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
WHERE `task_status`= 3 AND `task`.`hidden` = 'unarchive'  AND `task`.`assignie`='$user_id'";
$Run3 = mysqli_query($connect, $select3);

if (isset($_POST['details'])) {
    $update = "UPDATE task SET view= 'seen' WHERE task_id = '$task_id'";
    $run_update = mysqli_query($connect, $update);
}

if (isset($_GET['deletee'])) {
    $id = $_GET['deletee'];
    $delete = "DELETE FROM task WHERE task_id = '$id'";
    $run_delete = mysqli_query($connect, $delete);
    if (!$run_delete) {
        die('Delete query failed: ' . mysqli_error($connect));
    } else {
        header("location:my_tasks.php");
    }
}
if(isset($_GET['done'])){
    $id_task=$_GET['done'];
    $updatestatus="UPDATE `task` SET `task_status` = 3 WHERE `task_id` = $id_task";
        $runUpdatee=mysqli_query($connect, $updatestatus);
        header("location:my_tasks.php");
}

if (isset($_POST['submit'])) {
    $comment = mysqli_real_escape_string($connect, $_POST['comment']);
    $task_id=$_POST['task_id'];
    $insert = "INSERT INTO `task_notes` VALUES (NULL, $user_id,'$task_id','$comment')";
    $run_insert = mysqli_query($connect, $insert);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="haha">
        <div class="column">
            <div class="head d-flex justify-content-between w-75 m-auto mb-3">
                <h2>On-Track</h2>
            </div>
            <?php foreach ($Run1 as $key) { ?>
            <div class="card">
                    <div class="first">
                        <div class="form-control">
                            <p class="text-muted">Task Name</p>
                            <h5>
                            <a href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>" >
                                <?php echo $key['task_name']; ?> </a></h5>
           
                        </div>
                        <div class="form-control">
                            <p class="text-muted">Sprint Name</p>
                            <h5>
                            <a href="tasks.php?sid=<?php echo $key['sprint_id'] ?>" >
                                <?php echo $key['sprint_name']; ?></a></h5>
                        </div>
                        
                        <div class="category">
                            <h3><?php echo $key['category_name']; ?></h3>
                        </div>
                        <div class="flags">
                        <?php if ($key['priority_id'] == 1) { ?>
                            <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
                            <?php } elseif ($key['priority_id'] == 2) { ?>
                                <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i> 
                                <?php } else { ?>
                                    <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i></i>
                                    <?php } ?>
                        </div>
                    </div>
                    <form class="mt-2" method="post">
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea class="form-control w-75" style="border:solid 1px black;" name="comment"  placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Note</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button style="top:79%; widyh:10%; height:45%;" type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                        </div>
                    </form>
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT note, first_name, last_name FROM task_notes
                                             JOIN `user` ON `task_notes`.`user_id` =`user`.`user_id`
                                             WHERE `task_notes`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong>: <?php echo $fetch_comment['note']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>">Details</a>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="my_tasks.php?done=<?php echo $key['task_id'] ?>"><button><i class='bx bx-check'></i>Done</button></a>
                    </div>
                </div>
                <?php } ?>
        </div>
        <div class="column">
            <div class="head d-flex justify-content-between w-75 m-auto mb-3">
                <h2>At-Risk</h2>
            </div>
            <?php foreach ($Run2 as $key) { ?>
            <div class="card">
                    <div class="first">
                    <div class="form-control">
                            <p class="text-muted">Task Name</p>
                            <h5>
                            <a href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>" >
                                <?php echo $key['task_name']; ?> </a></h5>
           
                        </div>
                        <div class="form-control">
                            <p class="text-muted">Sprint Name</p>
                            <h5>
                            <a href="tasks.php?sid=<?php echo $key['sprint_id'] ?>" >
                                <?php echo $key['sprint_name']; ?></a></h5>
                        </div>
                        <div class="category">
                            <h3><?php echo $key['category_name']; ?></h3>
                        </div>
                        <div class="flags">
                        <?php if ($key['priority_id'] == 1) { ?>
                            <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
                            <?php } elseif ($key['priority_id'] == 2) { ?>
                                <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i> 
                                <?php } else { ?>
                                    <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i></i>
                                    <?php } ?>
                        </div>
                    </div>
                    <form class="mt-2" method="post">
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea class="form-control w-75" style="border:solid 1px black;" name="comment"  placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Note</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button style="top:79%; widyh:10%; height:45%;" type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                        </div>
                    </form>
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT note, first_name, last_name FROM task_notes
                                             JOIN `user` ON `task_notes`.`user_id` =`user`.`user_id`
                                             WHERE `task_notes`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong>: <?php echo $fetch_comment['note']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>">Details</a>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="my_tasks.php?done=<?php echo $key['task_id'] ?>"><button><i class='bx bx-check'></i>Done</button></a>
                    </div>
                </div>
                <?php } ?>
        </div>
        <div class="column">
            <div class="head d-flex justify-content-between w-75 m-auto mb-3">
                <h2>Done</h2>
            </div>
            <?php foreach ($Run3 as $key) { ?>
            <div class="card">
                    <div class="first">
                    <div class="form-control">
                            <p class="text-muted">Task Name</p>
                            <h5>
                            <a href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>" >
                                <?php echo $key['task_name']; ?> </a></h5>
           
                        </div>
                        <div class="form-control">
                            <p class="text-muted">Sprint Name</p>
                            <h5>
                            <a href="tasks.php?sid=<?php echo $key['sprint_id'] ?>" >
                                <?php echo $key['sprint_name']; ?></a></h5>
                        </div>
                        <div class="category">
                            <h3><?php echo $key['category_name']; ?></h3>
                        </div>
                        <div class="flags">
                        <?php if ($key['priority_id'] == 1) { ?>
                            <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
                            <?php } elseif ($key['priority_id'] == 2) { ?>
                                <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i> 
                                <?php } else { ?>
                                    <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i></i>
                                    <?php } ?>
                        </div>
                    </div>
                    <form class="mt-2" method="post">
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea class="form-control w-75" style="border:solid 1px black;" name="comment"  placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Note</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button style="top:79%; widyh:10%; height:45%;" type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                        </div>
                    </form>
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT note, first_name, last_name FROM task_notes
                                             JOIN `user` ON `task_notes`.`user_id` =`user`.`user_id`
                                             WHERE `task_notes`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong>: <?php echo $fetch_comment['note']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="mytask-details.php?task_id=<?php echo $key['task_id'] ?>">Details</a>
                       
                    </div>
                </div>
                <?php } ?>
        </div>
    </div>
    <style>
        .btn-1{
            /* background-color:red; */
            font-size:15px;
            margin-left:130px;
        }
    </style>
    <!-- js link -->
    <script src="js/card.js"></script>
    <!-- bootstrap js link -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
