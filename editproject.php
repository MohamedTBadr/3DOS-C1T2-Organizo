<?php
include("nav.php");
$error = "";

if (!isset($_GET['pid'], $_SESSION['user_id'])) {
    header("Location: index.php"); // BACK PLACEHOLDER MAY CHANGE
} else {
    $project_id = $_GET['pid'];
    $user_id = $_SESSION['user_id'];
    // $role_id = $_SESSION['role_id'];
    // $plan_id = $_SESSION['plan_id'];

    $project_name = '';
    $edit = false;

    if (isset($project_id)) {
        // Fetch project details
        $select1 = "SELECT * FROM `project` WHERE `project_id` = '$project_id'";
        $run_select1 = mysqli_query($connect, $select1);
        if ($run_select1 && mysqli_num_rows($run_select1) > 0) {
            $fetch = mysqli_fetch_assoc($run_select1);
            $project_name = $fetch['project_name'];
        } else {
            $error= "Project not found.";
        }

        if (isset($_POST['edit'])) {
            $name = mysqli_real_escape_string($connect,$_POST['project_name']);
            $update = "UPDATE `project` SET `project_name` = '$name' WHERE `project_id` = '$project_id'";
            $run_update = mysqli_query($connect, $update);
            if ($run_update) {
                header("Location: editproject.php?pid=$project_id");
            } else {
                $error="Failed to update project name.";
            }
        }

        // Fetch project members
        $select = "SELECT `user`.* FROM `project_member`
            JOIN `user` ON `project_member`.`user_id` = `user`.`user_id`
            WHERE `project_member`.`project_id` = '$project_id'";
        $run = mysqli_query($connect, $select);

        if (isset($_GET['delete'])) {
            $user_id = $_GET['delete'];
            $delete = "DELETE FROM `project_member` WHERE `user_id` = '$user_id' AND `project_id` = '$project_id'";
            $run_delete = mysqli_query($connect, $delete);
            if ($run_delete) {
                header("Location: editproject.php?pid=$project_id");
            } else {
                $error= "Failed to delete project member.";
            }
        }
    } else {
        $error= "No project selected.";
    }

    $user_id = $_SESSION['user_id'];
    $sqlstmt = "SELECT * FROM `user` JOIN `plan` ON `user`.`plan_id` = `plan`.`plan_id` WHERE `user_id` = '$user_id'";
    $execstmt = mysqli_query($connect, $sqlstmt);
    $fetcharr = mysqli_fetch_assoc($execstmt);
    $plan_id = $fetcharr['plan_id'];
    $role_id = $fetcharr['role_id'];
    if ($role_id == 1) {
        if (isset($_POST['submit'])) {
            // $first_name = $_POST['first_name'];
            // $last_name = $_POST['last_name'];
            $email = mysqli_real_escape_string($connect,$_POST['email']);

            $planMember = "SELECT * FROM `plan` WHERE `plan_id` = $plan_id";
            $run_plan = mysqli_query($connect, $planMember);
            if ($run_plan && mysqli_num_rows($run_plan) > 0) {
                $fetch_plan = mysqli_fetch_assoc($run_plan);
                $limitMember = $fetch_plan['limit'];

                $pro = "SELECT * FROM `project_member` WHERE `project_id` = $project_id";
                $mysqli = mysqli_query($connect, $pro);
                if ($mysqli && mysqli_num_rows($mysqli) >= 0) {
                    $member_count = mysqli_num_rows($mysqli);

                    if ($limitMember > $member_count) {
                        $select = "SELECT * FROM `user` WHERE `email` = '$email'";
                        $run_select = mysqli_query($connect, $select);
                        $rows = mysqli_num_rows($run_select);

                        if ($rows === 0) {
                            $error = "This member is not registered.";
                        } elseif ($rows > 0) {
                            $fetch_user = mysqli_fetch_assoc($run_select);
                            $found_id = $fetch_user['user_id'];

                            // Check if the user is already in the project
                            $select_project_member = "SELECT * FROM `project_member` WHERE `user_id` = $found_id AND `project_id` = $project_id";
                            $run_project_member_check = mysqli_query($connect, $select_project_member);

                            if (mysqli_num_rows($run_project_member_check) === 0) {
                                // Insert the member into the project
                                $insert1 = "INSERT INTO `project_member`(`user_id`, `project_id`) VALUES ('$found_id', '$project_id')";
                                $run_insert1 = mysqli_query($connect, $insert1);

                                if ($run_insert1) {
                                    header("Location: editproject.php?pid=$project_id");
                                } else {
                                    $error = "This member could not be inserted.";
                                }
                            } else {
                                $error = "This member is already in the project.";
                            }
                        }
                    } else {
                        $error = "You can only add up to $limitMember members.";
                    }
                } else {
                    $error = "Error fetching project members.";
                }
            } else {
                $error = "Error fetching plan details.";
            }
        }
    
    }elseif($role_id == 2){
        $error="only a leader can add members to this project";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Project</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/editproject.css" />
    <style>
        .warning {
            display: none;
            color: red;
        }
        .warning.visible {
            display: block;
        }
    </style>
</head>
<body>

<div class="heading">
    <div class="wrapper">
        <div class="form-wrapper Sign-in">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex">
                    <div class="input-group">
                        <input type="text" name="project_name" value="<?php echo htmlspecialchars($project_name); ?>">
                        <label for="">Project name:</label>
                    </div>
                    <button type="submit" name="edit" class="ms-auto btn btn-outline-secondary w-25"><i class="fa-regular fa-pen-to-square"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="header d-flex">
    <h1 class="me-3">Project Members</h1>
    <button type="submit" class="btn btn-outline-secondary" onclick="openpopup2()">+ add member</button>
</div>
<div class="warning <?php if ($error) { echo 'visible'; } ?>">
<i class="fa-solid fa-triangle-exclamation"></i>
                    <?php if ($error) { echo $error; } ?>
                </div>

<div class="add">
    <div class="wrapper popup2" id="popup2">
        <div class="form-wrapper Sign-in">
            <form method="post" enctype="multipart/form-data">
                <h2>Add Member</h2>
                <!-- <div class="input-group">
                    <input type="text" id="first_name" name="first_name" required>
                    <label for="">First name</label>
                </div>
                <div class="input-group">
                    <input type="text" id="last_name" name="last_name" required>
                    <label for="">Last name</label>
                </div> -->
                <div class="input-group">
                    <input type="email" id="email" name="email" required>
                    <label for="">Email</label>
                </div>
                <button type="submit" name="submit" class="btn btn-outline-dark">Submit</button>
                <button type="button" class="btn btn-outline-dark" onclick="closepopup2()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<table id="example" class="table table-striped text-center" style=" margin-left:5%; margin-top:2%">
    <thead>
    <tr>
        <th>Profile</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Remove</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($run && mysqli_num_rows($run) > 0) {
        while ($data = mysqli_fetch_assoc($run)) { ?>
            <tr>
                <!-- DATABASE STORE FILENAME.FORMAT -->
                <td><img src="./img/profile/<?php echo $data['image']; ?>" class="timg" alt=""></td>
                <td class="p-3"><?php echo $data['first_name'] . " " . $data['last_name']; ?></td>
                <td class="p-3"><?php echo $data['email']; ?></td>
                <td class="p-3"><?php echo $data['phone_number']; ?></td>
                <td class="p-3"><a style="color:red;" href="editproject.php?pid=<?php echo $project_id; ?>&delete=<?php echo $data['user_id']; ?>" <?php if($data['user_id'] == $_SESSION['user_id']) echo 'hidden'?>>Delete</a></td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="4">No members found.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script src="js/editproject.js"></script>
</body>
</html>
