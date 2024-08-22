<?php
$localhost= "localhost";
$username= "root";
$password= "";
$database= "conference";

$connect=mysqli_connect($localhost,$username,$password,$database);

session_start();
ob_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location:index.php");
}

$link=$_SERVER['REQUEST_URI'];
// echo $link;
$url=explode('/', $link);
array_shift($url);
// var_dump($url);
$end=end($url);
$searchSprints=false;
$searchTasks=false;
$searchArcTasks=false;
$searchprojects=false;

if(isset($_POST['search_btn'])){
    $text=$_POST['text'];
    if($end=="ViewSprints.php"){
        $searchSprints=true;}
elseif($end=="tasks.php"){
        $searchTasks=true;
    }elseif($end=="archive_taskss.php"){
        $searchArcTasks=true;
}elseif($end=="projects.php"){
    $searchprojects=true;}
}
?>