<?php
// SARAH
include "connection.php";


$select="SELECT * FROM `task` WHERE `hidden` = 'archive' ";
$runSelect=mysqli_query($connect, $select);

if(isset($_GET['visible'])) { 
$task_id = $_GET['visible']; 
$update= "UPDATE `task` SET `hidden` = 'unarchive' WHERE `task_id` = $task_id";
$runq=mysqli_query($connect, $update); 
header('location:archive_taskss.php');
}