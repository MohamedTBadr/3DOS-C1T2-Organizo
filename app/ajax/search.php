<?php

# database connection file
include '../../connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id=$_SESSION['user_id'];
    if (isset($_POST['key'])) {

        $key = mysqli_real_escape_string($connect, $_POST['key']);
        $searchKey = "%$key%";

        $sql = "SELECT * FROM `user`
                JOIN `project_member` ON `user`.`user_id` = `project_member`.`user_id`
                WHERE `project_member`.`project_id` IN (SELECT `project_id` FROM `project_member` WHERE `user_id` = '$user_id') 
                AND (`user`.`first_name` LIKE '$searchKey' OR `user`.`last_name` LIKE '$searchKey')";
        
        $run_search = mysqli_query($connect, $sql);

        if (mysqli_num_rows($run_search) > 0) {

            while ($user = mysqli_fetch_assoc($run_search)) {
                # Skip the current logged-in user
                if ($user['user_id'] == $_SESSION['user_id']) continue;
        ?>
                <li class="list-group-item">
                    <a href="chat.php?user=<?= $user['user_id'] ?>"
                       class="d-flex justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center">
                            <img src="img/profile/<?= $user['image'] ?>"
                                 class="w-10 rounded-circle">
                            <h3 class="fs-xs m-2">
                                <?= $user['first_name'] ." ".$user['last_name']?>
                            </h3>            	
                        </div>
                    </a>
                </li>
        <?php
            }
        } else {
        ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-user-times d-block fs-big"></i>
                The user "<?= htmlspecialchars($_POST['key']) ?>" and you are not in any projects.
            </div>
        <?php
        }
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>
