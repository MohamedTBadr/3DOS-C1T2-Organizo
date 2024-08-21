<?php

include("connection.php");
$error="";

if(isset($_SESSION['user_id']) && isset($_GET['sid']) && isset($_GET['ts']))
{
//    header("Location: index.php");
    $sprint_id = $_GET['sid'];
    $assignedby = $_SESSION['user_id'];
    $ts = $_GET['ts'];

// $project_id=$_SESSION['project_id']; //lma el leader ykhtar el project


    $select = "SELECT * FROM `category`";
    $runJoin = mysqli_query($connect, $select);


    $select = "SELECT * FROM `priority`";
    $runSelect = mysqli_query($connect, $select);


    $select = "SELECT * FROM `task`   WHERE `sprint_id` = $sprint_id";
    $run = mysqli_query($connect, $select);

    $select = "SELECT * FROM `sprint` WHERE `sprint_id` = $sprint_id";
    $run = mysqli_query($connect, $select);

    $dataProj = mysqli_fetch_assoc($run);
    $project_id = $dataProj['project_id'];


    $Select = "SELECT * FROM `project_member` JOIN `user` ON `project_member`. `user_id` = `user`.`user_id` WHERE `project_id`= $project_id ";
    $runS = mysqli_query($connect, $Select);
    $fetch = mysqli_fetch_assoc($run);
    if (isset($_POST['submit'])) {
        $name =mysqli_real_escape_string($connect,$_POST['task_name']);
        // $status=$_POST['task_status'];
        $description = mysqli_real_escape_string($connect,$_POST['description']);
        $assignie =mysqli_real_escape_string($connect,$_POST['assignie']);
        $category = $_POST['category'];
        $hidden = $_POST['visibility'];
        $priority = $_POST['priority'];
        $start_date = $_POST['start_date'];
        $start = strtotime($start_date);
        $end_date = $_POST['end_date'];
        $end = strtotime($end_date);
        $current_date = date('Y-m-d');
        // echo $current_date;
        // $project= $fetch['project_id'];
        $diff = ($end - $start) / (60 * 60 * 24);
        if (empty($name) || empty($start_date) || empty($end_date)) {
            
                  $error="Please fill in the required data!";
        } elseif ($start > $current_date) {
           $error="We are past that point, invalid start date!";

        } elseif ($diff <= 7 or $diff >= 30) {
            $error="Please select dates between 7 and 30 days!";
        } else {
            $start = date("Y-m-d", $start);
            $end = date("Y-m-d", $end);
            $hidden = "unarchive";


            $insert = "INSERT INTO `task` VALUES (NULL, '$name', '$ts', '$start','$end', '$description','$hidden', 'default','$sprint_id','$priority','$category',$assignie, $assignedby)";
            $run_insert = mysqli_query($connect, $insert);
            if($run_insert)
                header("location: tasks.php?sid=$sprint_id");
        }

    }
}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
    <title>
        New Password Page
    </title>
    <link rel="stylesheet" type="text/css" href="css/add-task.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
        .warning {
            display: none;
            color: red;
        }
        .warning.visible {
            display: block;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="wrapper">
            <!-- hoto link page eltasks hna -->
          
            <a href="tasks.php?sid=<?php echo $sprint_id?>" class="close"><i class="fa-solid fa-x "></i></a>
            
            <div class="from-wraapper mt-2 Sign-in">
                <form action="" method="post">
                    <h2>Add Task</h2>
                    <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                    <?php if ($error) { echo $error; } ?>
                </div>

                    <div class="input-group">
                        <input type="text" id="task_name" name="task_name" required>
                        <label for="" id="task-name">Task name</label>
                    </div>


                    <div class="dropdown">
                        <label for="category" class="">Category:</label>
                        <select name="category" id="category">
                            <?php foreach($runJoin as $data){?>
                            <option value="<?php echo $data['category_id']?>">
                                <?php echo $data['category_name']?>
                            </option>
                            <?php } ?>
                        </select>

                        <br>

                        <label for="priority">Priority :</label>
                        <select name="priority" id="priority">
                            <?php foreach($runSelect as $data){?>
                            <option value="<?php echo $data['priority_id']?>">
                                <?php echo $data['priority_name']?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
            </div>

            <div class="input-group mb-2">
                <input type="description" id="description" name="description" required>
                <label for="" id="description">Description</label>
            </div>

            <div class="date d-flex mt-3">
                <div class="input-group w-50 me-2">
                    <input type="date" id="start_id" name="start_date" required>
                    <label for="">Start Date</label>
                </div>
    
                <div class="input-group w-50">
                    <input type="date" id="end_id" name="end_date" required>
                    <label for="">End Date</label>
    
                </div>
            </div>


            <div class="dropdown">
                <label for="">Assigned To:</label>
                <select name="assignie">
                    <?php foreach($runS as $data2){?>
                    <option value="<?php echo $data2['user_id']?>">
                        <?php echo $data2['first_name']." ".$data2['last_name']?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <!--         
            <input type="radio" id="archive" name="visibility" value="archive">
            <label>Archive</label>
    
            <input type="radio" id="unarchive" name="visibility" value="unarchive">
            <label>UnArchive</label> -->

        
            <!-- new  -->
            <div class="form-check form-check-inline my-3 ">
                <input class="form-check-input" type="radio" name="visibility" value="archive" id="inlineRadio1" value="archive">
                <label class="form-check-label" for="inlineRadio1">Archive</label>
            </div>
            <!-- end first  -->
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visibility" value="unarchive" id="inlineRadio2" value="unarchive">
                <label class="form-check-label" for="inlineRadio2">unarchive</label>
            </div>

            <!-- end new  -->
            <!-- <div class="input-group">
                <input type="text" required>
                <label for="">Assigned to</label>
            </div> -->

            <!-- <div class="input-group">
                <input type="text" required>
                <label for="">Assigned from</label>
            </div> -->

            <a href="tasks.php" class="">

                <button type="submit" name="submit" class="btn btn-outline-primary
                ">Add Task</button>
            </a>
        </div>
        </form>
    </div>



    <!-- <script src="/js/card.js"></script> -->
</body>



</html>
