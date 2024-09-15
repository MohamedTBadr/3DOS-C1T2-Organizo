<?php
include "connection.php"; // Adjust to your connection file

$project_id = $_GET['project_id'];  // Get project_id from query string

// Query to count tasks based on status for the specific project
$tasks = "SELECT task_status, `status`, COUNT(*) as count 
          FROM task 
          JOIN `task_status` ON `task`.`task_status`=`task_status`.`status_id`
          JOIN sprint ON sprint.sprint_id = task.sprint_id
          WHERE sprint.project_id = $project_id
          GROUP BY task_status";

$runTask = mysqli_query($connect, $tasks);

$data = [];

// Populate the $data array with task status and counts
while ($row = mysqli_fetch_assoc($runTask)) {   
    $data[$row['status']] = $row['count'];
}

// Return the data as JSON
echo json_encode($data);
?>

