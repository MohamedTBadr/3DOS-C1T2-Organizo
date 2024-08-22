<?php
include("connection.php");

$msg = '';
$done="";
if(!isset($_GET['sid'], $_SESSION['user_id']))
{
    header("Location: index.php");
}

$sprint_id=$_GET['sid'];
$select="SELECT * FROM `sprint` WHERE `sprint_id` = '$sprint_id'";
$run= mysqli_query($connect, $select);
if(mysqli_num_rows($run) == 0)
    header("Location: index.php");
else
{
    $sprint_name='';
    $sprint_start='';
    $sprint_end='';
    $edit= false;

    // if(isset($_GET['sprint_id'])){
    //     $edit= true;
    //     $id= $_GET['sprint_id'];
    $id= $sprint_id;
    $select1="SELECT * FROM `sprint` WHERE `sprint_id` = '$id'";
    $run_select1= mysqli_query($connect,$select1);
    $fetch= mysqli_fetch_assoc($run_select1);
    $sprint_name=$fetch['sprint_name'];
    $sprint_start=$fetch['start_date'];
    $sprint_end=$fetch['end_date'];
    $pid = $fetch['project_id'];

    if(isset($_POST['edit']))
    {
        $dateUnchanged = false;
        $name= mysqli_real_escape_string($connect, $_POST['sprint_name']);

        $start_date= $_POST['start_date'];
        if($sprint_start == $start_date)
            $dateUnchanged = true;
        $start= strtotime($start_date);
        $end_date=$_POST['end_date'];
        $end= strtotime($end_date);
        $current_date= time();
       
        $diff= ($end - $start) / (60*60*24);
        if(empty($name) || empty($start_date) || empty($end_date))
        {
            $msg = " Please fill in the required data!";
        }
        elseif($start <= $current_date && !$dateUnchanged) 
        {
            $msg = "We are past that point, invalid start date!
                 ";
        }
        elseif( ($end < $current_date) )
        {
            $msg = "We are past that point, invalid end date
           ";
        }
        elseif($diff <7 or $diff >30) 
        {
            $msg = "Please select dates between 7 and 30 days!
                 ";
        }
        else
        {
            $done = "Edited Successfully";
            $start=date("Y-m-d",$start);
            $end=date("Y-m-d",$end);

            $update= "UPDATE `sprint` SET `sprint_name`= '$name', `start_date`= '$start', `end_date`= '$end' WHERE `sprint_id` = '$id'";
            $run_update= mysqli_query($connect, $update);
            header("refresh:2;url=ViewSprints.php?pid=$pid");
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sprint Form</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/editsprints.css">
</head>
<body>
   <div class="main-container">
    <div class="main">
        <form method="post">
            <h2>Edit sprint</h2>
            <div class="warning <?php if(!empty($msg)) echo 'visible' ?>">
                        <?php if (!empty($msg)) echo $msg ?>
                    </div>
                    <div class="done <?php if(!empty($done)) echo 'visible' ?>">
                        <?php if (!empty($done)) echo $done ?>
                    </div>
            <label for="sprint-name">Sprint name</label>
            <input type="text" id="sprint-name" name="sprint_name" value="<?php echo $sprint_name?>">
            
            <label for="start-date">Start Date</label>
            <input type="date" id="start-date" name="start_date" value="<?php echo $sprint_start?>">
            
            <label for="end-date">End Date</label>
            <input type="date" id="end-date" name="end_date" value="<?php echo $sprint_end?>">
            
            <div class="button-container">
                <button type="submit" name="edit">Submit</button>
                <button type="button" onclick="window.location.href='ViewSprints.php?pid=<?php echo $pid ?>';">Cancel</button>
            </div>
        </form>
    </div>
   </div>
</body>
</html>
