<?php
$localhost= "localhost";
$username= "root";
$password= "";
$database= "conference";

$connect=mysqli_connect($localhost,$username,$password,$database);

session_start();
ob_start(); // CRUCIAL For reals

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: login_admin.php");
}
error_reporting(0);
?>