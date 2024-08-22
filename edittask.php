<?php
include("connection.php");
// $task_id=$_SESSION['task_id'];
// $select="SELECT * FROM `task` WHERE `task_id` = '$task_id'";
// $run= mysqli_query($connect, $select);
$error="";
if(!isset($_SESSION['user_id']))
    header ("Location: index.php");

$task_name='';
$task_status='';
$task_start='';
$task_end='';
$desc='';
$edit=false;
if(isset($_GET['task_id'])){
    // $edit= true;
    $id= $_GET['task_id'];
    // $id=7;
    $select1="SELECT * FROM `task` WHERE `task_id` = '$id'";
    $run_select1= mysqli_query($connect,$select1);
    $fetch= mysqli_fetch_assoc($run_select1);
    $task_name=$fetch['task_name'];
    $task_status=$fetch['task_status'];
    $task_start=$fetch['start_date'];
    $task_end=$fetch['end_date'];
    $desc=$fetch['description'];

    if(isset($_POST['edit'])){
        $dateUnchanged = false;
        $name= mysqli_real_escape_string($connect,$_POST['task_name']);
        $status=$_POST['task_status'];
        $description=mysqli_real_escape_string($connect,$_POST['description']);
        $start_date= $_POST['start_date'];
        if($task_start == $start_date)
            $dateUnchanged = true;
        $start= strtotime($start_date);
        $end_date=$_POST['end_date']; 
        $end= strtotime($end_date);
        $current_date= time();

        $diff= ($end - $start) / (60*60*24);
        if(empty($name) || empty($start_date) || empty($end_date)){
            $error="Please fill in the required data!";
        }
        elseif($start <= $current_date && !$dateUnchanged){
            $error="We are past that point, invalid start date!";
           
        
        }
        elseif($diff <7 or $diff >30){
            $error="Please select dates between 7 and 30 days!";
          
        }else{
           
            $start=date("Y-m-d",$start);
            $end=date("Y-m-d",$end);
    
            $update= "UPDATE `task` SET `task_name`= '$name',`task_status`= '$status', `start_date`= '$start', `end_date`= '$end', `description`= '$description' WHERE `task_id` = '$id'";
            $run_update= mysqli_query($connect, $update);
            header("location:task_details.php?task_id=$id");

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
        Edit Task
    </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="css/edittask.css">
</head>

<body>
    <div class="container-main">
        <div class="wrapper">
        <a href="task_details.php?task_id=<?php echo $id?>" class="close"><i class="fa-solid fa-x "></i></a>
            <!-- hoto link page eltasks hna -->
            <!-- <a href="" class="close"><i class="fa-solid fa-x "></i></a> -->

            <div class="from-wraapper  Sign-in">
                <form action="" method="post">
                    <h2>Edit task</h2>
                    <div class="warning <?php if(!empty($error)) echo 'visible' ?>">
                        <?php if (!empty($error)) echo $error ?>
                    </div>

                    <div class="input-group">
                        <input type="text" id="task_name" name="task_name" value="<?php echo $task_name ?>" required>
                        <label for="">Name</label>
                    </div>


                    <!-- new  -->
                     <div class="choose">
                    <div class="form-check form-check-inline my-3 ">
                        <input class="form-check-input" type="radio" name="task_status" id="inlineRadio1"
                            value="1" <?php if($task_status == 1) echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio1">On track</label>
                    </div>
                    <!-- end first  -->
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="task_status" id="inlineRadio2"
                            value="2" <?php if($task_status == 2) echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio2">At risk</label>
                    </div>
                    <!-- end second  -->
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="task_status" id="inlineRadio3"
                            value="3" <?php if($task_status == 3) echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio2">Done</label>
                    </div>
                    </div>

                    <!--         
        <div class="input-group">
            <input type="text" id="task_status" name="task_status"value="<?php echo $task_status ?>" required>
            <label for="">Status</label>
        </div> -->

                    <div class="input-group">
                        <input type="description" id="description" name="description" value="<?php echo $desc ?>"
                            required>
                        <label for="">Description</label>
                    </div>
                    <div class="date d-flex mt-3">
                        <div class="input-group w-50 me-2">
                            <input type="date" id="start_id" name="start_date" value="<?php echo $task_start ?>"
                                >
                            <label for="">start date</label>
                        </div>
                        <div class="input-group w-50">
                            <input type="date" id="end_id" name="end_date" value="<?php echo $task_end ?>" >
                            <label for="">End date</label>
                        </div>
                    </div>


                    <button type="submit" name="edit" class="btn btn-outline-primary">Edit</button>
                   
                    <!-- <div class="signUp-link">
            <p> <a href="#" class="signUpBtn-link"></a> </p>
        </div> -->
                </form>
            </div>
        </div>
    </div>
</body>

</html>
