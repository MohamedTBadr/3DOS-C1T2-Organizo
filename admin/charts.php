<?php
include "connection.php";

// Query 1: Active users (tasks, comments, chats)
$query1 = "SELECT 
    u.user_id, 
    CONCAT(u.first_name, ' ', u.last_name) AS username,
    COUNT(DISTINCT t.task_id) AS task,
    COUNT(DISTINCT c.comment_id) AS comments_count,
    COUNT(DISTINCT ch.chat_id) AS chats_count
FROM 
    user u
LEFT JOIN task t ON u.user_id = t.assign_by OR u.user_id = t.assignie
LEFT JOIN comment c ON u.user_id = c.user_id
LEFT JOIN chats ch ON u.user_id = ch.from_user OR u.user_id = ch.to_user
GROUP BY u.user_id
HAVING 
    COUNT(DISTINCT t.task_id) > 0
    OR COUNT(DISTINCT c.comment_id) > 0
    OR COUNT(DISTINCT ch.chat_id) > 0";
$result1 = mysqli_query($connect, $query1);

$usernames = [];
$taskCounts = [];
$commentCounts = [];
$chatCounts = [];

while ($row = mysqli_fetch_assoc($result1)) {
    $usernames[] = $row['username'];
    $taskCounts[] = $row['task'];
    $commentCounts[] = $row['comments_count'];
    $chatCounts[] = $row['chats_count'];
}

// Query 2: User signups by month (for the donut chart)
$query2 = "SELECT DATE_FORMAT(join_date, '%Y-%m') AS month, COUNT(*) AS user_count 
        FROM user 
        GROUP BY month 
        ORDER BY month";
$result2 = $connect->query($query2);

$months = [];
$userCounts = [];

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $months[] = $row['month'];
        $userCounts[] = $row['user_count'];
    }
}

/// Query to count the number of users in each plan
$query = "SELECT `plan`.`plan_type`, COUNT(user_id) as `user_count` FROM `subscription` 
JOIN `plan` ON `subscription`.`plan_id` = `plan`.`plan_id`
GROUP BY `plan`.`plan_type`";
$result = mysqli_query($connect, $query);

$plans = [];
$user_counts = [];

// Fetch results from the query
while ($row = mysqli_fetch_assoc($result)) {
$plans[] = $row['plan_type'];        // xValues (plan types)
$user_counts[] = $row['user_count'];  // yValues (number of users)
}

// Query 4: Role-based user distribution
$query4 = "SELECT r.role_name, COUNT(u.user_id) as user_count
          FROM `user` u
          JOIN `role` r ON u.role_id = r.role_id
          GROUP BY r.role_name";
$result4 = mysqli_query($connect, $query4);

$roles = [];
$roleUserCounts = [];

while ($row = mysqli_fetch_assoc($result4)) {
    $roles[] = $row['role_name'];
    $roleUserCounts[] = $row['user_count'];
}

mysqli_close($connect);
$data = [
    'usernames' => $usernames,
    'taskCounts' => $taskCounts,
    'commentCounts' => $commentCounts,
    'chatCounts' => $chatCounts,
    'months' => $months,
    'userCounts' => $userCounts,
    'plans' => $plans,
    'user_counts' => $user_counts,
    'roles' => $roles,
    'roleUserCounts' => $roleUserCounts
];

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
