<?php
include 'connection.php';
$msg = '';
if(empty($_SESSION) || !isset($_SESSION['user_id'])) // to be double sure
{
    header("Location: index.php");// BACK PLACEHOLDER MAY CHANGE
}
else
{
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['add-proj']))
    {
        if(!empty($_POST['project_name']))
        {
            $name = $_POST['project_name'];
            $insertProj ="INSERT INTO `project`(`project_name`, `team_members`, `project_type_id`, `user_id`) VALUES ('$name','1','1','$user_id')";
            $ExecProj = mysqli_query($connect, $insertProj);
            if($ExecProj)
            {
                $lastProj = "SELECT MAX(`project_id`) as `last_id` FROM `project`";
                $ExecLast = mysqli_query($connect, $lastProj);
                $fetch = mysqli_fetch_assoc($ExecLast);
                $proj_id = $fetch['last_id'];
                $insertMember ="INSERT INTO `project_member`VALUES ('$user_id','$proj_id')";
                $ExecInsertMem = mysqli_query($connect, $insertMember);
                if($ExecInsertMem)
                {
                    echo
                    "
                    <div class='alert alert-success d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                    <div>
                        An example success alert with an icon
                    </div>
                    </div>

                ";
                    //header("Location: ViewSprints.php?pid=$proj_id");
                    header("Location: projects.php");
                }
            }

        }
    }
}
?>



<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
    <title>
        Add Project
    </title>
    <link rel="icon" type="image/x-icon" href="./img/keklogo.png">
    <link rel="stylesheet" type="text/css" href="css/add-project.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">
    <a href="projects.php" class="close"><i class="fa-solid fa-x "></i></a>
        <div class="from-wraapper  Sign-in">
            <form method="POST">
                <h2>Add Project</h2>

                <div class="input-group">
                    <input type="text" id="project" required name="project_name">
                    <label for="" id="project-name">Project Name</label>
                </div>

                <button type="submit" name="add-proj">Submit</button>
                <div class="signUp-link">
                    <p> <a href="#" class="signUpBtn-link"></a> </p>
                </div>
            </form>
        </div>
    </div>
</body>



</html>