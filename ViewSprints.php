<?php
include("nav.php");
$error= '';
$done="";
$done='';
if(!isset($_SESSION['user_id']) || !isset($_GET['pid']))
    header ("Location: index.php"); //BACK PLACEHOLDER MAY CHANGE
else
{
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id'];
    $plan_id = $_SESSION['plan_id']; // future uses
    $pid = $_GET['pid'];

    $limit=3; // FRONT - BACK MAY DECIDE TO CHANGE THIS
    if(!isset($_GET['page']))
        $page=1;
    else
        $page=$_GET['page'];

    $num="SELECT * FROM `sprint` WHERE `project_id` = $pid";
    $run_num=mysqli_query($connect, $num);
    $num_rows=mysqli_num_rows($run_num);

    $total_pages=ceil($num_rows / $limit);
    $offset = ($page - 1) * $limit;
    // $select="SELECT * FROM`sprint` limit $limit offset $offset";
    // $run_select=mysqli_query($connect,$select);

    $memberStmt = "SELECT * FROM `project_member` WHERE `user_id` = $user_id AND `project_id` = $pid";
    $ExecMember = mysqli_query($connect, $memberStmt);
    if (mysqli_num_rows($ExecMember) == 0)
        header("Location: index.php"); // not a member = kick

    $sprintsStmt = "SELECT * FROM `sprint` WHERE `project_id` = $pid ORDER BY `end_date` limit $limit offset $offset";
    $ExecSprint = mysqli_query($connect, $sprintsStmt);
    if (mysqli_num_rows($ExecSprint) == 0)
        $error = "There are no sprints for this Project yet";

    if (isset($_POST['add-spr']))
    {
        $sprint_name =mysqli_real_escape_string($connect, $_POST['sprint_name']);
        $start_date = mysqli_real_escape_string($connect, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($connect, $_POST['end_date']);

        $start= strtotime($start_date); // Farah - Tarek code
        $current_date= date('Y-m-d');
        $end= strtotime($end_date);
        $diff= ($end - $start) / (86400);

        if(empty($sprint_name) || empty($start_date) || empty($end_date))
        {
            $error = "We are past that point, invalid start date!";

        }
        elseif($start_date < $current_date)
        {
            $error = "Please fill in the required data!";

        }
        elseif($diff <7 or $diff >30)
        {
            $error = "Please select dates between 7 and 30 days!";

        }
        else
        {
            $AddSprStmt = "INSERT INTO `sprint` (`sprint_name`, `start_date`, `end_date`, `project_id`) VALUES ('$sprint_name', '$start_date', '$end_date', '$pid')";
            $ExecAddSpr = mysqli_query($connect, $AddSprStmt);
            if ($ExecAddSpr) {
                $done = "Sprint Successfully Added";
                // echo "<div class='alert alert-success w-100'>";
                // echo "<h2>Sprint Successfully Added</h2>";
                // echo "</div>";
                header("Refresh:2; url=ViewSprints.php?pid=$pid");
            }
        }

    }
    if (isset($_GET['ds'])) // del logic
    {
        $sprint_id = $_GET['ds'];
        $DeleteSprStmt = "DELETE FROM `sprint` WHERE `sprint_id` = $sprint_id";
        $ExecDeleteSpr = mysqli_query($connect, $DeleteSprStmt);
        if ($ExecDeleteSpr)
        {
            $done="Sprint deleted successfully!";
            header("Refresh:2; url=ViewSprints.php?pid=$pid");
        }
    }

    if (isset($_GET['es'])) //edit logic
    {
        $sprint_id = $_GET['es'];
        $EditSprStmt = "SELECT * FROM `sprint` WHERE `sprint_id` = $sprint_id";
        $ExecEditSpr = mysqli_query($connect, $EditSprStmt);
        $sprintData = mysqli_fetch_assoc($ExecEditSpr);
        if (isset($_POST['update-spr']))
        {
            $sprint_name = $_POST['sprint_name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $UpdateSprStmt = "UPDATE `sprint` SET `sprint_name` = '$sprint_name', `start_date` = '$start_date', `end_date` = '$end_date' WHERE `sprint_id` = $sprint_id";
            $ExecUpdateSpr = mysqli_query($connect, $UpdateSprStmt);
            if ($ExecUpdateSpr)
            {
                $done="Sprint updated successfully!";
                header("Refresh:3; url=ViewSprints.php?pid=$pid");
            }
        }
    }
}
$select="SELECT * FROM sprint ";
$run_select=mysqli_query($connect,$select);
if(isset($_POST['search'])){
    $text=$_POST['text'];
    $select_search="SELECT * FROM sprint WHERE (sprint_name LIKE '%$text%') AND `project_id` = $pid";
    $run_select_search=mysqli_query($connect,$select_search);
    $num_rows = mysqli_num_rows($run_select_search);
    $total_search_pages = ceil($num_rows / $limit);
    $offset = ($page - 1) * $limit;

    $select_search = "SELECT * FROM sprint WHERE (sprint_name LIKE '%$text%') AND `project_id` = $pid LIMIT $limit OFFSET $offset";
    $run_select_search = mysqli_query($connect, $select_search);
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My sprints</title>
        <!-- font awesomr link -->
        <link rel="stylesheet" href="https://fontawesome.com/icons/">
        <link rel="stylesheet" href="css/all.min.css">
        <!-- css link -->
        <link rel="stylesheet" href="css/sprints.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- cdjn link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <div class="head">
        <h1>Sprints</h1>
            <button class="start ms-3" onclick="openpopup()">+ Add Sprint</button>
    </div>
    <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?php if ($error) { echo $error; } ?>
                </div>
    <div class="done <?php if ($done) { echo 'visible'; } ?>">
    <!-- <i class="fa-solid fa-triangle-exclamation"></i> -->
    <?php if ($done) { echo $done; } ?>
    </div>
    <div class="pricing-container">


        <!-- start first card  -->
        <?php if(isset($_POST['search'])){?>
        <?php foreach ($run_select_search as $dataa){ ?>
            <div class="pricing-card">
                <a href="tasks.php?sid=<?php echo $dataa['sprint_id'] ?>">
                    <div class="d-flex mb-3">
                        <h2 class="card-title" style="color: #212529 !important;"><?php echo $dataa['sprint_name'] ?></h2>
                        <div class="ms-4">
                            <button type="button" class="icon"><a href="editsprints.php?sid=<?php echo $dataa['sprint_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button>
                            <form method="GET" style="display: inline">
                                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                                <input type="hidden" name="ds" value="<?php echo $dataa['sprint_id']; ?>">
                                <button type="submit" class="icon"><i class="fa-solid fa-x fs-4" style="color: rgb(151, 2, 2);"></i></button>
                            </form>
                        </div>
                    </div>

                    <p class="due-description"><i class="fa-solid fa-clock"></i> Due date: <?php echo date('d M',strtotime($dataa['end_date'])) ?></p>
                    <?php
                    $end = strtotime($dataa['end_date']); // sec
                    $now = time();
                    $gap = $end - $now;  // sec
                    $days_left = ceil($gap / 86400); // Tarek, my resolute is still strong!! XD 60.60.24, I think ciel is good; 1 instead of 0 days sounds good
                    if ($gap < 0) {
                        $days_left = abs($days_left);
                        $message = "$days_left days overdue";
                    } else {
                        $message = "$days_left days left";
                    }

                    ?>
                    <p class="left-description"><i class="fa-solid fa-hourglass-start"></i> <?php echo $message ?></p>
                    <button class="btnn ms-5">Tasks</button></a>
            </div>
        <?php } ?>
        <!-- end first card  -->
    </div><!-- end cards container -->
    </a>
    <?php }else{ ?>


    <!-- start first card  -->
        <?php while ($data = mysqli_fetch_assoc($ExecSprint)) { ?>
            <div class="pricing-card">
                <div class="d-flex mb-3">
                    <h2 class="card-title"><?php echo $data['sprint_name'] ?></h2>
                    <div class="ms-4">
                        <button type="button" class="icon"><a href="editsprints.php?sid=<?php echo $data['sprint_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button>
                        <form method="GET" style="display: inline">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            <input type="hidden" name="ds" value="<?php echo $data['sprint_id']; ?>">
                            <button type="submit" class="icon"><i class="fa-solid fa-x fs-4" style="color: rgb(151, 2, 2);"></i></button>
                        </form>
                    </div>
                </div>

                <p class="due-description"><i class="fa-solid fa-clock"></i> Due date: <?php echo date('d M',strtotime($data['end_date'])) ?></p>
                <?php
                $end = strtotime($data['end_date']); // sec
                $now = time();
                $gap = $end - $now;  // sec
                $days_left = ceil($gap / 86400); // Tarek, my resolute is still strong!! XD 60.60.24, I think ciel is good; 1 instead of 0 days sounds good
                if ($gap < 0) {
                    $days_left = abs($days_left);
                    $message = "$days_left days overdue";
                } else {
                    $message = "$days_left days left";
                }

                ?>
                <p class="left-description"><i class="fa-solid fa-hourglass-start"></i> <?php echo $message ?></p>
                <a href="tasks.php?sid=<?php echo $data['sprint_id'] ?>"><button class="btnn ms-5">Tasks</button></a>
            </div>
        <?php }} ?>
        <!-- end first card  -->
    </div><!-- end cards container -->


  <ul class="pagination">
  <?php
    if(isset($_POST['search']))
        $total_pages = $total_search_pages;
    else
        $total_pages = ceil($num_rows / $limit);

    if(isset($_GET['page']))
      $currentPage = $_GET['page'];
    else
      $currentPage = 1;
    if($total_pages > 1){
      if($currentPage > 1) {?>
    <li class="page-item">
      <a class="page-link" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php } $max = 0;
    for($pn = 1; $pn <= $total_pages; $pn++) {$max++;?>

    <li class="page-item"><a class="page-link" id="frstnmb" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $pn ?>"><?php echo $pn ?></a></li>
    <?php } ?>
    <li class="page-item">
    <?php if($currentPage != $max) {?>
      <a class="page-link" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    <?php } ?>
    </li>
  </ul>
  <?php } ?>

    <!-- form add sprint  -->
    <div class="add popup" id="popup">
        <div class="wrapper ">
            <div class="from-wraapper  Sign-in">


                <form method="POST">
                    <h2>Add sprint</h2>

                    <div class="input-group">
                        <input type="text" id="task-name" name="sprint_name"  required>
                        <label for="" id="task-name">sprint name</label>
                    </div>
            </div>
            <div class="input-group">
                <input type="date" name="start_date" value="<?php echo date('Y-m-d')?>">
                <label for="">Start Date</label>
            </div>
            <div class="input-group">
                <input type="date" name="end_date">
                <label for="">End Date</label>
            </div>
            <div class="end d-lg-flex">
                <button type="submit" class="btnn me-2" name="add-spr">Submit</button>
                <button type="button" class="btnn" onclick="closepopup()">cancel</button>
            </div>

            </form>
        </div>
    </div>
    </div>

    <!-- form edit sprint  -->
<div class="add popup" id="popup2">
    <div class="wrapper ">
    <div class="from-wraapper  Sign-in">
        <form method="POST" action="ViewSprints.php?pid=<?php echo $pid ?>&us=<?php echo $sprint_id ?>">
            <h2>Edit sprint</h2>

            <div class="input-group">
                <input type="text" id="task-name" name="sprint_name" value="<?php echo $sprintData['sprint_name']; ?>" required>
                <label for="" id="task-name">sprint name</label>
            </div>

    </div>
    <div class="input-group">
        <input type="date" name="start_date" value="<?php echo $sprintData?>">
        <input type="date" name="start_date" value="<?php echo $sprintData['start_date']; ?>" required>
        <label for="">Start Date</label>
    </div>

        <div class="input-group">
            <input type="date" name="end_date" value="<?php echo $sprintData['end_date']; ?>" required>
            <label for="">End Date</label>
        </div>

        <div class="end d-lg-flex">
            <button type="submit" class="btnn me-2" name="update-spr">Submit</button>
            <button type="button" class="btnn" onclick="closepopup2()">cancel</button>
        </div>

        </form>
    </div>
</div>

    <!-- delete popup  -->
    <?php if($role_id == 1) {?>
        <div class="popup alert alert-danger w-75" id="popup3" role="alert">
            <h2>Are you sure that you want to delete this sprint?</h2>
            <form method="GET" action="ViewSprints.php">
                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                <input type="hidden" name="ds" value="<?php echo $data['sprint_id']?>">
                <button type="submit" class="btn btn-outline-danger">Yes</button>
                <button type="button" class="btn btn-outline-success" onclick="closepopup3()">No</button>
            </form>
        </div>
    <?php } else if ($role_id == 2) { ?>
        <div class="popup alert alert-danger w-75" id="popup3" role="alert">
            <h2>Only the Leader can delete sprints</h2>
            <button type="button" class="btn btn-outline-success" onclick="closepopup3()">Understood!</button>
        </div>
    <?php } ?>
    <script src="js/sprints.js"></script>
</body>
</html>

<!-- $select_search="SELECT * FROM sprint WHERE `project_id` = $pid &&  (sprint_name LIKE '%$text%')";-->