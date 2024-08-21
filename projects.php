<?php
include 'nav.php';
$msg = '';
$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['all', 'done', 'not_done']) ? $_GET['filter'] : 'all';

if (isset($_SESSION['user_id'])) {
    $logged_user_id = $_SESSION['user_id'];

    $allProjectsStmt = "
        SELECT `project`.`project_id`, `project`.`project_name`
        FROM `project`
        INNER JOIN `project_member` ON `project`.`project_id` = `project_member`.`project_id`
        WHERE `project_member`.`user_id` = $logged_user_id
    ";
    $ExecAllProjects = mysqli_query($connect, $allProjectsStmt);

    $totalTasksStmt = "
        SELECT `project`.`project_id`, COUNT(`task`.`task_id`) AS total_tasks
        FROM `project`
        LEFT JOIN `sprint` ON `project`.`project_id` = `sprint`.`project_id`
        LEFT JOIN `task` ON `sprint`.`sprint_id` = `task`.`sprint_id`
        GROUP BY `project`.`project_id`
    ";
    $ExecTotalTasks = mysqli_query($connect, $totalTasksStmt);

    $completedTasksStmt = "
        SELECT `project`.`project_id`, COUNT(`task`.`task_id`) AS completed_tasks
        FROM `task`
        LEFT JOIN `sprint` ON `task`.`sprint_id` = `sprint`.`sprint_id`
        JOIN `project` ON `sprint`.`project_id` = `project`.`project_id`
        WHERE `task`.`task_status` = '3'
        GROUP BY `project`.`project_id`
    ";
    $ExecCompletedTasks = mysqli_query($connect, $completedTasksStmt);

    $lastSprintStmt = "
        SELECT `project`.`project_id`, MAX(`sprint`.`end_date`) AS project_deadline
        FROM `project`
        LEFT JOIN `sprint` ON `project`.`project_id` = `sprint`.`project_id`
        GROUP BY `project`.`project_id`
    ";
    $ExecLastSprint = mysqli_query($connect, $lastSprintStmt);

    $allProjects = [];
    while ($row = mysqli_fetch_assoc($ExecAllProjects)) {
        $allProjects[$row['project_id']] = $row;
    }

    $totalTasks = [];
    while ($row = mysqli_fetch_assoc($ExecTotalTasks)) {
        $totalTasks[$row['project_id']] = $row['total_tasks'];
    }

    $completedTasks = [];
    while ($row = mysqli_fetch_assoc($ExecCompletedTasks)) {
        $completedTasks[$row['project_id']] = $row['completed_tasks'];
    }

    $lastSprints = [];
    while ($row = mysqli_fetch_assoc($ExecLastSprint)) {
        $lastSprints[$row['project_id']] = $row['project_deadline'];
    }

    $projects = [];

    foreach ($allProjects as $projectId => $project) {
        $total = isset($totalTasks[$projectId]) ? $totalTasks[$projectId] : 0;
        $completed = isset($completedTasks[$projectId]) ? $completedTasks[$projectId] : 0;
        $completionPercentage = $total > 0 ? round(($completed / $total) * 100) : 0;

        $teamMembersStmt = "
            SELECT `image`, `first_name`
            FROM `project_member`
            JOIN `user` ON `project_member`.`user_id` = `user`.`user_id`
            WHERE `project_member`.`project_id` = $projectId
        ";
        $ExecTeamMembers = mysqli_query($connect, $teamMembersStmt);
        $teamMembers = [];
        while ($row = mysqli_fetch_assoc($ExecTeamMembers)) {
            $teamMembers[] = $row;
        }

        $projectDeadline = isset($lastSprints[$projectId]) ? $lastSprints[$projectId] : 'TBD';

        if ($filter == 'all' || ($filter == 'not_done' && $completed < $total) || ($filter == 'done' && $completed == $total && $total != 0)) {
            $projects[] = [
                'project_id' => $projectId,
                'project_name' => $project['project_name'],
                'total_tasks' => $total,
                'completed_tasks' => $completed,
                'completion_percentage' => $completionPercentage,
                'team_members' => $teamMembers,
                'project_deadline' => $projectDeadline
            ];
        }
    }
}

if (isset($_POST['search'])) {
    $text = $_POST['text'];
    $searchStmt = "
        SELECT `project`.`project_id`, `project`.`project_name`, GROUP_CONCAT(`user`.`first_name` SEPARATOR ', ') AS team_members
        FROM `project`
        INNER JOIN `project_member` ON `project`.`project_id` = `project_member`.`project_id`
        INNER JOIN `user` ON `project_member`.`user_id` = `user`.`user_id`
        WHERE `project_member`.`user_id` = $logged_user_id AND `project`.`project_name` LIKE '%$text%'
        GROUP BY `project`.`project_id`, `project`.`project_name`
    ";
    $run_search1 = mysqli_query($connect, $searchStmt);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects</title>
    <link rel="stylesheet" href="./css/projects.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="header">
    <h1>My Projects</h1>
    <button class='btnn' ><a href='add-project.php' style="text-decoration: none;"><i class="fa-solid fa-plus"></i>Add Project </a> </button>
    <div class="anchors">
        <a href="projects.php?filter=all"><button type="submit" class="btn btn-outline-primary" <?php if ($filter == 'all') echo "style='    background-color:#033043ad;
 color:white'" ?>>All</button></a>
        <a href="projects.php?filter=not_done"><button type="submit" class="btn btn-outline-secondary" <?php if ($filter == 'not_done') echo "style='background-color: #033043ad; color:white'" ?>>In Progress</button></a>
        <a href="projects.php?filter=done"><button type="submit" class="btn btn-outline-success" <?php if ($filter == 'done') echo "style='background-color: #033043ad; color:white'" ?>>Completed</button></a>
    </div>
</div>

    <?php if (isset($_POST['search'])) { ?> 
        <?php foreach ($run_search1 as $data){ ?>
    <div class="pricing-card">
    
        <h2 class="card-title">Project :</h2>
        
        <a href="ViewSprints.php?pid=<?php echo $data['project_id'] ?>">
            <h2><?php echo $data['project_name'] ?></h2>
        </a>
        <h3>Team members:</h3>
        <div class="profile-container">
            <?php echo $data['team_members'] ?>
            
        </div>
        
    </div>
    <?php } ?>
     
    <?php } else { ?>
    <div class="pricing-container">
        <?php if (!empty($allProjects)) {foreach ($projects as $project) {?>
        <div class="pricing-card">
            <h2 class="card-title"><?php echo $project['project_name']; ?></h2>
            <p class="price"></p>
            <p class="description"><i class="fa-solid fa-clock"></i> Due date: <?php echo $project['project_deadline']; ?></p>
            <div class="team">
                <h3>Team members:</h3>
            </div>
            <div class="profile-container">
                <?php foreach ($project['team_members'] as $member) { ?>
                <div class="profile-icon">
                    <img src="img/profile/<?php echo $member['image']; ?>" alt="Profile Image" title="<?php echo $member['first_name']; ?>">
                </div>
                <?php } ?>
            </div>
            <div class="flex-wrapper">
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart orange">
                        <path class="circle-bg"
                              d="M18 2.0845
                           a 15.9155 15.9155 0 0 1 0 31.831
                           a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="<?php echo $project['completion_percentage'] ?>, 100"
                              d="M18 2.0845
                           a 15.9155 15.9155 0 0 1 0 31.831
                           a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $project['completion_percentage'] ?>%</text>
                    </svg>
                </div>
            </div>
            <div class="card-actions">
                <a href="ViewSprints.php?pid=<?php echo $project['project_id'] ?>"><button class="view-button">View</button></a>
                <a href="editproject.php?pid=<?php echo $project['project_id'] ?>"><button class="view-button edit">Edit</button></a>
            </div>
        </div>
        <?php }
        }
        else
        {
            $msg = "No projects to be shown"; ?>
            <div class="pricing-container">
                <h4><?php echo $msg ?></h4>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<!--<button class='btn' style="transform: translate3D(279%,-342%,0);"><a href='add-project.php' style='text-decoration: none'</a>Add Project</button>-->
</body>
</html>
