<?php
// SARAH
// include("connection.php");
include("nav.php");

if(!isset($_SESSION['user_id']))
{
    header ("Location: index.php");
}


// Initialize $RunOne
$RunOne = [];


    $select = "SELECT u1.`first_name` AS assign_by_first_name, u1.`last_name` AS assign_by_last_name, 
                      u2.`first_name` AS assignie_first_name, u2.`last_name` AS assignie_last_name, 
                      `task_name`, `task_status`, `task`.`start_date`, `task`.`end_date`, `description`, `hidden`,
                     `sprint`.`sprint_id`, `task`.`priority_id`, `task`.`category_id`, `task`.`task_id` ,
                     `category`.`category_id`,`category_name`,
                     `sprint`.`sprint_id`,`sprint_name`,`sprint`.`start_date`,`sprint`.`end_date`,`project`.`project_id`,`project`.`project_name`,`priority`.`priority_id`,`priority_name`
               FROM `task`
               JOIN `category` ON `task`.`category_id` = `category`.`category_id`
               JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
               JOIN `priority` ON `task`.`priority_id` = `priority`.`priority_id`
               JOIN `user` AS u1 ON `task`.`assign_by` = u1.`user_id`
               JOIN `user` AS u2 ON `task`.`assignie` = u2.`user_id`
            --    JOIN `sprint` ON `project`.`sprint_id`=`sprint`.`sprint`
               JOIN `project` ON `project`.`project_id`=`sprint`.`project_id`
               WHERE `hidden` = 'archive' ";

    $RunOne = mysqli_query($connect, $select);
   

if(isset($_POST['search'])){
    $text=$_POST['text'];
    $select_search="SELECT u1.`first_name` AS assign_by_first_name, u1.`last_name` AS assign_by_last_name, 
                      u2.`first_name` AS assignie_first_name, u2.`last_name` AS assignie_last_name, 
                      `task_name`, `task_status`, `task`.`start_date`, `task`.`end_date`, `description`, `hidden`,
                     `sprint`.`sprint_id`, `task`.`priority_id`, `task`.`category_id`, `task`.`task_id` ,
                     `category`.`category_id`,`category_name`,
                     `sprint`.`sprint_id`,`sprint_name`,`sprint`.`start_date`,`sprint`.`end_date`,`project`.`project_id`,`project`.`project_name`,`priority`.`priority_id`,`priority_name`
               FROM `task`
               JOIN `category` ON `task`.`category_id` = `category`.`category_id`
               JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
               JOIN `priority` ON `task`.`priority_id` = `priority`.`priority_id`
               JOIN `user` AS u1 ON `task`.`assign_by` = u1.`user_id`
               JOIN `user` AS u2 ON `task`.`assignie` = u2.`user_id`
                 JOIN `project` ON `project`.`project_id`=`sprint`.`project_id`
               WHERE `hidden` = 'archive' AND (task_name LIKE '%$text%')";
    $run_select_search=mysqli_query($connect,$select_search);
        
}
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unhide Page</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/unhide.css">
</head>
<body>
    <?php if(isset($run_select_search)){ ?>
        <div class="yarab">
            <div class="heading d-flex justify-content-center align-items-center mt-3">
                <i class="fa-solid fa-box-archive me-3"></i>
                <!-- <p text-muted>Task Name:</p> -->
                <h1 >Archived</h1>
            </div>

            <div class="haha">
                <!-- start card  -->
                <?php if ($run_select_search && mysqli_num_rows($run_select_search) > 0) { ?>
                    <?php foreach ($run_select_search as $key){ ?>
                        <div class="card">
                            <div class="first">
                                <div class="profile">
                                    <p class=text-muted>Task Name:</p>
                                    <h5><?php echo $key['task_name']; ?></h5>
                                </div>
                                <br>
                                <div class="category" name="category">
                                    <h4><?php echo $key['category_name']; ?></h4>
                                </div>
                                <div class="flags">
                                    <i id="setPriority" class="fa-solid fa-flag" style="color: #399918;"></i>
                                    <div class="priorities" id="priorityShow">
                                        <?php if ($key['priority_id'] == 1) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
                                        <?php } elseif($key['priority_id'] == 2) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i>
                                        <?php } elseif($key['priority_id'] == 3) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <p class="prjname">Project Name:<?php echo $key['project_name'];?></p>
                            <br>
                            <div class="profile">
                                <div class="asign">
                                    <p text-muted>Sprint</p>
                                    <h5><?php echo $key['sprint_name']; ?></h5>
                                </div>
                                <div class="ms-auto">
                                    <img src="img/about-left-image.png">
                                </div>
                                <div class="asign">
                                    <p text-muted>Assigned to</p>
                                    <h5><?php echo $key['assignie_first_name']." ".$key['assignie_last_name']; ?></h5>
                                </div>
                            </div>
                            <br>
                            <a id="delete" class="button" href="unarchive.php?visible=<?php echo $key['task_id'] ?>">Unhide</a>
                        </div> <!-- end card -->
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="yarab">
            <div class="heading d-flex justify-content-center align-items-center mt-3">
                <i class="fa-solid fa-box-archive me-3"></i>
                <h2 class="h3">Archived</h2>
            </div>

            <div class="haha">
                <!-- start card  -->
                <?php if ($RunOne && mysqli_num_rows($RunOne) > 0) { ?>
                    <?php foreach ($RunOne as $key){ ?>
                        <div class="card">
                            <div class="first">
                                <div class="profile">
                                    <p class=text-muted>Task Name:</p>
                                    <h5><?php echo $key['task_name']; ?></h5>
                                </div>
                                <br>
                                <div class="category" name="category">
                                    <h4><?php echo $key['category_name']; ?></h4>
                                </div>
                                <div class="flags">
                                    <i id="setPriority" class="fa-solid fa-flag" style="color: #399918;"></i>
                                    <div class="priorities" id="priorityShow">
                                        <?php if ($key['priority_id'] == 1) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
                                        <?php } elseif($key['priority_id'] == 2) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i>
                                        <?php } elseif($key['priority_id'] == 3) { ?>
                                            <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <p class="prjname">Project Name:<?php echo $key['project_name'];?></p>
                            <br>
                            <div class="profile">
                                <div class="asign">
                                    <p text-muted>Sprint</p>
                                    <h5><?php echo $key['sprint_name']; ?></h5>
                                </div>
                                <div class="ms-auto">
                                    <img src="img/about-left-image.png">
                                </div>
                                <div class="asign">
                                    <p text-muted>Assigned to</p>
                                    <h5><?php echo $key['assignie_first_name']." ".$key['assignie_last_name']; ?></h5>
                                </div>
                            </div>
                            <br>
                            <a id="delete" class="button" href="unarchive.php?visible=<?php echo $key['task_id'] ?>">Unhide</a>
                        </div> <!-- end card -->
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!-- js link -->
    <script src="js/card.js"></script>
    <!-- bootstrap js link -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
