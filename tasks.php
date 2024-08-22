<?php
// include("connection.php");
include ('nav.php');

if(!isset($_SESSION['user_id'], $_GET['sid']))
    header ("Location: index.php");

if(isset($_GET['sid'])) {
    $sprint_id = $_GET['sid'];
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id'];
    $select1 = "SELECT * FROM `task` 
JOIN `category` ON `task`.`category_id` = `category`.`category_id`
JOIN `priority` ON `task`.`priority_id` = `priority`.`priority_id`
WHERE `task`.`sprint_id` = '$sprint_id' AND `task_status`= 1 AND `task`.`hidden` = 'unarchive'";
    $Run1 = mysqli_query($connect, $select1);

    $select2 = "SELECT * FROM `task` 
JOIN `category` ON `task`.`category_id` = `category`.`category_id`
JOIN `priority` ON `task`.`priority_id` = `priority`.`priority_id`
WHERE `task`.`sprint_id` = '$sprint_id' AND `task_status`= 2 AND `task`.`hidden` = 'unarchive'";
    $Run2 = mysqli_query($connect, $select2);

    $select3 = "SELECT * FROM `task` 
JOIN `category` ON `task`.`category_id` = `category`.`category_id`
JOIN `priority` ON `task`.`priority_id` = `priority`.`priority_id`
WHERE `task`.`sprint_id` = '$sprint_id' AND `task_status`= 3 AND `task`.`hidden` = 'unarchive'";
    $Run3 = mysqli_query($connect, $select3);

    if (isset($_POST['details'])) {
        $update = "UPDATE task SET view= 'seen' WHERE task_id = '$task_id'";
        $run_update = mysqli_query($connect, $update);
    }

    if (isset($_GET['deletee'])) {
        $id = mysqli_real_escape_string($connect, $_GET['deletee']);
        $delete = "DELETE FROM task WHERE task_id = '$id' And `sprint_id`= $sprint_id";
    
        $run_delete = mysqli_query($connect, $delete);
    
        if (!$run_delete) {
            die('Delete query failed: ' . mysqli_error($connect));
        } else {
            header("Location: tasks.php?sid=$sprint_id");           
        }
    }

    // if (isset($_POST['submit'])) {
    //     $comment = $_POST['comment'];
    //     $task_id = $_POST['task_id'];
    //     $insert = "INSERT INTO `comment` VALUES (NULL, NULL, '$comment', '$user_id', '$task_id')";
    //     $run_insert = mysqli_query($connect, $insert);
    // }
    if (isset($_POST['submit'])) {
        $comment = mysqli_real_escape_string($connect, $_POST['comment']);
        $task_id = $_POST['task_id'];
        $image = $_FILES['image']['name'];
        
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], "./img/" . $image);
            $insert = "INSERT INTO comment VALUES (NULL, '$image', '$comment', '$user_id', '$task_id')";
            $run_insert = mysqli_query($connect, $insert);
        }
        elseif (empty($image)) {
            // move_uploaded_file($_FILES['image']['tmp_name'], "./img/" . $image);
            $insert = "INSERT INTO comment VALUES (NULL, null, '$comment', '$user_id', '$task_id')";
            $run_insert = mysqli_query($connect, $insert);
        }
        
    }
    
    
}
$select="SELECT * FROM task";
$run_select=mysqli_query($connect,$select);
if(isset($_POST['search'])){
    $text=mysqli_real_escape_string($connect,$_POST['text']);
    $select_search="SELECT * FROM task WHERE (task_name LIKE '%$text%') and `sprint_id` = $sprint_id and `task`.`hidden` = 'unarchive' ";
    $run_select_search=mysqli_query($connect,$select_search);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <!-- font awesome -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="haha">
    <?php if(isset($_POST['search'])){?>
            <div class="card2">
            <?php foreach ($run_select_search as $data){ ?>
                <a href="task_details.php?task_id=<?php echo $data['task_id']?>"><?php echo $data['task_name'], "<br>";?>
            </a>
            </div>
                <?php } ?>
            <?php }else{ ?>
        <div class="column">
            <div class="head d-flex justify-content-between w-75 m-auto mb-3">
                <h2>On-Track</h2>
                <a href="add-task.php?sid=<?php echo $sprint_id ?>&ts=1" type="button" class="btn btn-outline-secondary">+ add task</a>
            </div>
            <?php foreach ($Run1 as $key) { ?>
            <div class="card">
                    <div class="first">
                        <div class="form-control">
                            <p class="text-muted">Task Name :-</p>
                            <h5><?php echo $key['task_name']; ?></h5>
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
                    <form class="mt-2" method="post" enctype="multipart/form-data" >
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea  class="form-control w-75" style="border:solid 1px black;" name="comment" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Comment</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                            <input class="" type="file" id="formFile" value="<?php echo $image ?>"name="image">
                       
                        </div>
                    </form>
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT comment, first_name, last_name FROM comment
                                             JOIN `user` ON `comment`.`user_id` =`user`.`user_id`
                                             WHERE `comment`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong> <?php echo $fetch_comment['comment']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="task_details.php?task_id=<?php echo $key['task_id'] ?>">Details
                        </a>
                        <br>
                        <?php 
 if($role_id==1){
    ?>
 <a  id="delete" class="btn btn-1 btn-outline-secondary" href="archive.php?hide=<?php echo $key ['task_id']?>"><i class="fa-solid fa-box-archive"></i></a>
 <a id="edit" class="btn btn-1 btn-outline-secondary" href="tasks.php?deletee=<?php echo $key['task_id']; ?>&sid=<?php echo $key['sprint_id']; ?>"><i class="fa-solid fa-trash"></i></a>
<?php } else {}?>
                    </div>
                </div>
                <?php } ?>
        </div>
        <div class="column">
            <div class="head d-flex justify-content-between w-75 m-auto mb-3">
                <h2>At-Risk</h2>
                <a href="add-task.php?sid=<?php echo $sprint_id ?>&ts=2" type="button" class="btn btn-outline-secondary">+ add task</a>
            </div>
            <?php foreach ($Run2 as $key) { ?>
            <div class="card">
                    <div class="first">
                        <div class="form-control">
                            <p class="text-muted">Task Name</p>
                            <h5><?php echo $key['task_name']; ?></h5>
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
                    <form class="mt-2" method="post" enctype="multipart/form-data" >
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea  class="form-control w-75" style="border:solid 1px black;" name="comment" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Comment</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                            <input class="" type="file" id="formFile" value="<?php echo $image ?>"name="image">
                       
                        </div>
                    </form>
                    
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT comment, first_name, last_name FROM comment
                                             JOIN `user` ON `comment`.`user_id` =`user`.`user_id`
                                             WHERE `comment`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong> <?php echo $fetch_comment['comment']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="task_details.php?task_id=<?php echo $key['task_id'] ?>">Details
                        </a>
                        <br>
                        <?php 
 if($role_id==1){
    ?>
  <a  id="delete" class="btn btn-1 btn-outline-secondary" href="archive.php?hide=<?php echo $key ['task_id']?>"><i class="fa-solid fa-box-archive"></i></a>
  <a id="edit" class="btn btn-1 btn-outline-secondary" href="tasks.php?deletee=<?php echo $key['task_id']; ?>&sid=<?php echo $key['sprint_id']; ?>"><i class="fa-solid fa-trash"></i></a>
<?php } else {}?>

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
                            <h5><?php echo $key['task_name']; ?></h5>
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
                    <form class="mt-2" method="post" enctype="multipart/form-data" >
                        <div class="form-floating comm d-flex justify-content-around">
                            <textarea  class="form-control w-75" style="border:solid 1px black;" name="comment" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your Comment</label>
                            <input type="hidden" name="task_id" value="<?php echo $key['task_id']?>">
                            <button type="submit" name="submit" class="btn-outline-primary s"><i class="fa-regular fa-comment"></i></button>
                            <input class="" type="file" id="formFile" value="<?php echo $image ?>"name="image">
                       
                        </div>
                    </form>
                    <div class="second">
                        <div class="comments">
                            <?php
                            $cid = $key['task_id'];
                            $commentQuery = "SELECT comment, first_name, last_name FROM comment
                                             JOIN `user` ON `comment`.`user_id` =`user`.`user_id`
                                             WHERE `comment`.`task_id` = '$cid'";
                            $run_comment = mysqli_query($connect, $commentQuery);
                            while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
                                <p><strong><?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?></strong> <?php echo $fetch_comment['comment']; ?></p>
                            <?php } ?>
                        </div>
                        <a id="delete" class="btn btn-1 btn-outline-secondary" href="task_details.php?task_id=<?php echo $key['task_id'] ?>">Details
                        </a>
                        <br>
                        <?php 
 if($role_id==1){
    ?>
  <a  id="delete" class="btn btn-1 btn-outline-secondary" href="archive.php?hide=<?php echo $key ['task_id']?>"><i class="fa-solid fa-box-archive"></i></a>
  <a id="edit" class="btn btn-1 btn-outline-secondary" href="tasks.php?deletee=<?php echo $key['task_id']; ?>&sid=<?php echo $key['sprint_id']; ?>"><i class="fa-solid fa-trash"></i></a>
<?php } else {}?>

                    </div>
                </div>
                <?php } ?>
                <?php } ?>
        </div>
    </div>
    <style>
      .action-buttons {
    display: flex;
    gap: 10px; /* Adjust the gap between buttons as needed */
}

#delete, #edit {
    display: inline-block; /* Ensures the anchors behave like inline elements */
    margin: 0; /* Removes default margins */
    padding: 0.375rem 0.75rem; /* Adjust padding as needed */
    border: 1px solid transparent; /* Default border */
    border-radius: 0.25rem; /* Default border radius */
    text-align: center; /* Centers text within the buttons */
    text-decoration: none; /* Removes default underline */
}

#delete {
    background-color: #f8f9fa; /* Default background color for 'Delete' */
    color: #6c757d; /* Default text color for 'Delete' */
    border-color: #6c757d; /* Border color for 'Delete' */
}

#edit {
    background-color: #f8f9fa; /* Default background color for 'Edit' */
    color: #6c757d; /* Default text color for 'Edit' */
    border-color: #6c757d; /* Border color for 'Edit' */
}

#delete:hover, #edit:hover {
    background-color: #e2e6ea; /* Background color on hover */
    color: #343a40; /* Text color on hover */
    border-color: #dae0e5; /* Border color on hover */
}

    </style>
    <!-- js link -->
    <script src="js/card.js"></script>
    <!-- bootstrap js link -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
