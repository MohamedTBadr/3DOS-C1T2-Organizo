<?php
include("connection.php");

$admin_id=$_SESSION['admin_id'];
$select="SELECT * FROM `admin` WHERE `admin`.`admin_id` = $admin_id";
$run_select=mysqli_query($connect,$select);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adminprofile.css">
    <title>Admin profile</title>
</head>

<body>
    <?php foreach($run_select as $data){ ?>
    <div class="container">
        <div class="header-container">
          <div class="header">
            <h1 class="main-heading"><?php echo $data ['name'];?></h1>
            <div class="stats">
              <span class="stat-module">

                E-mail: <span class="stat-number"><?php echo $data ['email'];?></span>
                <br><br>
            </div>
          </div> 
        </div>
        <?php } ?>
        
        <div class="overlay-header"></div>
        
        <div class="body">
          <div class="body-action-button u-flex-center">
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