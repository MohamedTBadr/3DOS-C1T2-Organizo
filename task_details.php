<?php
// include("connection.php");
include("nav.php");

if(isset($_GET['task_id'])){
  $task_id=$_GET['task_id'];
}

$user_id=$_SESSION['user_id'];

$role_id = $_SESSION['role_id'];
if ($task_id > 0 && $user_id > 0) {
   
    $select = "SELECT `task`.*,  
                      u1.`first_name` AS assign_by_first_name, u1.`last_name` AS assign_by_last_name, 
                      u2.`first_name` AS assignie_first_name, u2.`last_name` AS assignie_last_name,
                      c.`category_name`, s.`sprint_name`, p.`priority_name`
               FROM `task` 
               JOIN `category` c ON `task`.`category_id` = c.`category_id`
               JOIN `sprint` s ON `task`.`sprint_id` = s.`sprint_id`
               JOIN `priority` p ON `task`.`priority_id` = p.`priority_id`
               JOIN `user` AS u1 ON `task`.`assign_by` = u1.`user_id`
               JOIN `user` AS u2 ON `task`.`assignie` = u2.`user_id`
               WHERE `task`.`task_id` = $task_id";
    $run = mysqli_query($connect, $select);
    $task = mysqli_fetch_assoc($run);

    if ($task) {
        $update = "UPDATE `task` SET `view`= 'seen' WHERE `task_id` = $task_id AND `assignie` = $user_id";
        mysqli_query($connect, $update);
        
    }

    if (isset($_GET['deletee'])) {
      $id = $_GET['deletee'];
      $delete = "DELETE FROM `comment` WHERE `comment_id` = '$id'";
      $run_delete = mysqli_query($connect, $delete);
      if (!$run_delete) {
          die('Delete query failed: ' . mysqli_error($connect));
      } else {
          header("Location: task_details.php?task_id=$task_id");
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>task-details</title>
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fontawesome.com/icons/">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- fontawesome link -->
  <!-- font awesome link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css link -->
  <link rel="stylesheet" href="css/taskdetailslaila.css">
</head>


<body>
  <!-- start card -->

  <div class="card mt-5">
  <a href="tasks.php?sid=<?php echo $task['sprint_id'];?>" class="close"><i class="fa-solid fa-x "></i></a>

    <div class="w-100">
      <div class="txt">
      <?php if ($user_id == $task['assign_by']) { ?>
    <?php if ($task['view'] == 'default') { ?>
      
      <i class="fa-solid fa-eye-slash"></i> 

      <?php } elseif ($task['view'] == 'seen') { ?>

        <i class="fa-solid fa-eye"></i>
       
    <?php } ?>
<?php } ?>
        <p class="me-3">
          <?php  echo $task['category_name']; ?>
        </p>

        <p class="me-3">
        <?php if ($task['priority_id'] == 1) { ?>
       <i class="fa-solid fa-flag priorityOpt" style="color: #399918;"></i>
        <?php echo $task['priority_name']; ?></p>
                                <?php } elseif ($task['priority_id'] == 2) { ?>
                                  <i class="fa-solid fa-flag priorityOpt" style="color: #F9E400;"></i> 
                                    <?php echo $task['priority_name']; ?></p>
                                <?php } else { ?>
                                 > <i class="fa-solid fa-flag priorityOpt" style="color: #ff0000;"></i></i>
                                  <?php echo $task['priority_name']; ?></p>
                                <?php } ?>
          </p>
          

          <?php

if ($role_id == 1 || $user_id == $task['assign_by']) { ?>
  <a href="edittask.php?task_id=<?php echo $task_id?>" class="">
    <i class="fa-regular fa-pen-to-square orange"></i>
  </a>
<?php } ?>      </div>

      <h6 class="orange ">
        <?php  echo "Task Name: " ?>
      </h6>


      <h2 class="mt-2">
        <?php echo $task['task_name']; ?>
      </h2>
      <?php
$assign_by_id = $task['assign_by']; 
$select1 = "SELECT `image` FROM `user` WHERE `user_id` = '$assign_by_id'";
$run_select_assigned_by = mysqli_query($connect, $select1);
$fetch_image_assigned_by = mysqli_fetch_assoc($run_select_assigned_by);

$assignie_id = $task['assignie']; 
$select2 = "SELECT `image` FROM `user` WHERE `user_id` = '$assignie_id'";
$run_select_assignie = mysqli_query($connect, $select2);
$fetch_image_assignie = mysqli_fetch_assoc($run_select_assignie);
?>

<p class="mb-4">
    <?php  echo $task['description']; ?>
  </p>
  <div class="row g-3">
    <div class="col-sm-6">
      <div class="center">
        <img src="img/profile/<?php echo $fetch_image_assigned_by['image']; ?>" class="pp" alt="profile pic">
        <h6 class="ms-2">Assign By:
          <?php echo $task['assign_by_first_name']. " " . $task['assign_by_last_name']; ?>
        </h6>
      </div>

      <h6 class="mb-0 ms-5"><i class="fa-solid fa-calendar-days orange me-2"></i>
        Start:
        <?php echo $task['start_date']; ?>
      </h6>
    </div>
    <div class="col-sm-6 ">
      <div class="center">
        <img src="img/profile/<?php echo $fetch_image_assignie['image']; ?>" class="pp" alt=>
        <h6 class="ms-2">
          Assignee:
          <?php echo $task['assignie_first_name'] . " " . $task['assignie_last_name']; ?>
        </h6>
      </div>

      <h6 class="mb-0 ms-5"> 
      <i class="fa-solid fa-calendar-days orange me-2"></i>Ends:
        <?php echo $task['end_date'];  ?>
      </h6>
    </div>
  </div>
</div>




</div>

<div class="second">
    <div class="comments">
      <?php
        $cid = $task['task_id'];
        $commentQuery = "SELECT `comment_id`, `comment`.`user_id`, `comment`.`image`, `comment`, `first_name`, `last_name` 
                         FROM `comment`
                         JOIN `user` ON `comment`.`user_id` = `user`.`user_id`
                         WHERE `comment`.`task_id` = '$cid'";
        $run_comment = mysqli_query($connect, $commentQuery);
        while ($fetch_comment = mysqli_fetch_assoc($run_comment)) { ?>
        
        <div class="comment-item">
          <div class="center">
            <div class="me-auto">
              <h6 class="orange">
                <?php echo $fetch_comment['first_name'] . " " . $fetch_comment['last_name']; ?> :
              </h6>
              <p class="ms-5">
                <?php echo $fetch_comment['comment']; ?>
              </p>
            </div>

            <?php if (!empty($fetch_comment['image'])) { ?>
            <div class="me-2">
              <img src="./img/<?php echo $fetch_comment['image']; ?>" alt="Comment Image"
                style="max-width: 200px; max-height: 200px;">
            </div>

            <!-- download -->
            <div class="me-2">
              <a href="./img/<?php echo $fetch_comment['image']; ?>" download>
                <i class="fa-solid fa-download orange"></i>
              </a>
            </div>
            <?php } ?>
            
           
            <?php if ($fetch_comment['user_id'] == $_SESSION['user_id']) { ?>
            <div class="me-2">
              <a href="task_details.php?task_id=<?php echo $task_id; ?>&deletee=<?php echo $fetch_comment['comment_id']; ?>">
                <i class="fa-solid fa-trash orange"></i>
              </a>
            </div>
            <?php } ?>
          </div> 
        </div> 
      <?php } ?>
    </div>
</div>

  <!-- bootstrap link -->
  <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

</html>
