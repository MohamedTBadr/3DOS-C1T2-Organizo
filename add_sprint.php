<?php
// test.php
include("connection.php");

if (isset($_POST['add_spr'])) {
    $sprint_name = mysqli_real_escape_string($connect, $_POST['sprint_name']);
    $start_date = mysqli_real_escape_string($connect, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($connect, $_POST['end_date']);
    $pid =mysqli_real_escape_string($connect,$_POST['pid']);

    $AddSprStmt = "INSERT INTO `sprint` (`sprint_name`, `start_date`, `end_date`, `project_id`) VALUES ('$sprint_name', '$start_date', '$end_date', '$pid')";
    $ExecAddSpr = mysqli_query($connect, $AddSprStmt);

    if ($ExecAddSpr) {
        echo "Sprint successfully added";
    } else {
        echo "Error adding sprint.";
    }

}
?>
