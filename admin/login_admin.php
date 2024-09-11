<?php
include("connection.php");
$error="";

if(isset($_SESSION['admin_id'])) 
    header("Location: admin_profile.php");

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($connect, $_POST['email']); 
    $password = mysqli_real_escape_string($connect, $_POST['password']); 

    if (empty($email))
        $error = "Email can't be left empty";

    if (empty($password))
        $error = "Password can't be left empty";

    else
    {
        $selectemail = "SELECT * FROM `admin` WHERE `email` = '$email'";
        $runselect = mysqli_query($connect, $selectemail);

        if ($runselect)
        {
            if (mysqli_num_rows($runselect) > 0)
            {
              $data = mysqli_fetch_assoc($runselect);
              $hashedPass = $data['password'];
              if (password_verify($password, $hashedPass))
              {
                  $_SESSION['admin_id'] = $data['admin_id'];
                  $_SESSION['name'] = $data['name'];
                  $_SESSION['isSuper'] = $data['isSuper'];
                  header("Location: admin_profile.php"); //missing location "homepage"
              }
                else
                    $error ="Incorrect Password";
            }
            else
                $error ="Email isn't registered";
        }
    }
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <!----link bootsrap-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/login.css"/>
    <title>Login</title>
    <link href="img/logo.png" rel="icon">
  </head>

  <body> 
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <!-- <a href="home.php" class="close"><i class="fa-solid fa-x"></i></a> -->
          <div class="from-wraapper  Sign-in">

          <form method="post">
          <h2>Login</h2>
         
          
          <div class="input-group">
              <input type="email" required name="email">
              <label for="">E-mail</label>
          </div>
          
          
          <div class="input-group">
              <input type="password" required  name="password">
              <label for="">Password</label>
          </div>
              <br>
              <?php if($error){

echo "<div class='alert alert-warning' role='alert'>$error</div>"; } ?>
          <div class="buttons">

      <button class="Btn" name="login">
          SUBMIT
      </button>
      <br>
     
    <a class="FRG " href="emailverify_admin.php">Forgot Password?</a>

  </div>
          
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="main.js"></script>
  </body>

</html>
