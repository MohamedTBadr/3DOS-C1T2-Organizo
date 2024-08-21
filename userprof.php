<?php
include("nav.php");

if(!isset($_SESSION['user_id'])){ // imagine accessing userprof.php while LOGGED OUT
  header("Location: index.php");
}
$userid = $_SESSION['user_id'];
$select="SELECT * FROM `user` join `plan` on `user`.`plan_id`=`plan`.`plan_id` WHERE `user`.`user_id`='$userid'";
$run=mysqli_query($connect,$select);
$fetch=mysqli_fetch_assoc($run);

    $first_name=$fetch['first_name'];
    $last_name=$fetch['last_name'];
    $password=$fetch['password'];
    $email=$fetch['email'];
    $phone_number=$fetch['phone_number'];
    $role=$fetch['role_id'];
    $plane_name=$fetch['plan_type'];
    $image=$fetch['image'];

$select_p="SELECT *  FROM `project` WHERE `user_id` = '$userid'";
$run_select_p=mysqli_query($connect,$select_p);
$num_p=mysqli_num_rows($run_select_p);

$select_t="SELECT *  FROM `task` WHERE `assignie` = '$userid'";
$run_select_t=mysqli_query($connect,$select_t);
$num_s=mysqli_num_rows($run_select_t);

$select_f="SELECT *  FROM `task` WHERE `assign_by`= '$userid'";
$run_select_f=mysqli_query($connect,$select_f);
$num_f=mysqli_num_rows($run_select_f);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/userprofile.css">
    <title>User profile</title>
</head>

<body>
    <div class="container">
        <div class="header-container">
          <div class="header">
            <h1 class="main-heading"><?php echo  $first_name," " ,$last_name  ;?></h1>
            <div class="stats">
              <span class="stat-module">
                E-mail: <span class="stat-number"><?php echo $email;?></span>
                <br><br>
                <span class="stat-module">
                   Phone: <span class="stat-number"><?php echo$phone_number;?></span>
              </span>
                <br><br>
              <span class="stat-module">
                Current plan: <span class="stat-number"><?php echo$plane_name ;?></span>
              </span>
              
            </div>
          </div> <!-- END header -->
        </div>
        
        <div class="overlay-header"></div>
        
        <div class="body">
          <img src="./img/profile/<?php echo $fetch['image'] ?>" alt="<?php echo  $first_name," " ,$last_name  ;?>" class="body-image" />
          <div class="body-action-button u-flex-center">
            
          <a href="edit_profile.php">
          <svg class="iconsvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>          </i></a>
          </div>
          <div class="txt">
          <span class="body-stats">projects: <span><?php echo $num_p?></span></span>
          <span class="body-stats">Tasks assigned to me: <span><?php echo $num_s?></span></span>
          <span class="body-stats">Tasks assigned by me: <span><?php echo $num_f?></span></span>
          </div>
          
          <div class="u-clearfix"></div>
          <div class="body-info">
          <a href="./subscription.php" class="c-button c-button--gooey">Upgrade Plan
              <div class="c-button__blobs">
              <div></div>
              <div></div>
              <div></div>
              </div>
              </a>
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
              <defs>
                <filter id="goo">
                  <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                  <feBlend in="SourceGraphic" in2="goo"></feBlend>
                </filter>
              </defs>
            </svg>
          <a href="Edit password.php">
            <button class="c-button c-button--gooey" type="submit"> Update password
              <div class="c-button__blobs">
              <div></div>
              <div></div>
              <div></div>
              </div>
            </button>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
              <defs>
                <filter id="goo">
                  <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                  <feBlend in="SourceGraphic" in2="goo"></feBlend>
                </filter>
              </defs>
            </svg>
            <form method="post" >
            <button class="c-button c-button--gooey" type="submit" name="logout">Logout
                <div class="c-button__blobs">
                <div></div>
                <div></div>
                <div></div>
                </div>
              </button>
              </form>
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
                <defs>
                  <filter id="goo">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                    <feBlend in="SourceGraphic" in2="goo"></feBlend>
                  </filter>
                </defs>
              </svg>
                  </div>
          
        </div>
        
      </div>
</div>
</body>
</html>
