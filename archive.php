<?php
// SARAH
include "connection.php";
if(isset($_GET['hide']))
{
    $task_id = $_GET['hide'];
    $select="SELECT * FROM `task` WHERE `hidden` = 'unarchive' AND `task_id` = '$task_id' ";
    $runSelect=mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($runSelect);
    $sprint_id = $data['sprint_id'];

    $sid = $sprint_id;
    $update= "UPDATE `task` SET `hidden` = 'archive' WHERE `task_id` = $task_id";
    $runq=mysqli_query($connect, $update);
    header("refresh:1; tasks.php?sid=$sprint_id");
}
else
    header("Location: index.php");
