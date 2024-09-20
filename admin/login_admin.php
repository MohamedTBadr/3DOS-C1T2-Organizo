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
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = "Invalid email format";
    else if (empty($password))
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
                $error ="Not Authorised";
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
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <title>Login</title>
    <link href="img/logo.png" rel="icon">
    <style>
        .warning
        {
            display: none; color: red;
            position: static;
            width: 65%;
            margin: -13% auto -1%;
            font-size: 1vw;
        }
        .warning.visible {display: block}
        #s-btn {margin-top: 50px}
    </style>
  </head>

  <body>
    <div class="main">

      <div class="login">

        <form method="post">
          <label>Login</label>
          <div class="warning <?php if(!empty($error)) echo 'visible' ?>">
            <?php if (!empty($error)) echo $error ?>
          </div>
          <input type="email" name="email" placeholder="E-mail" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''?>">
          <input type="password" name="password" placeholder="Password" required value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''?>">
          <button type="submit" name="login" id="s-btn">Login</button>
          <a href="emailverify_admin.php">Forgot Password?</a>
        </form>

      </div>

    </div>
    <script src="main.js"></script>
  </body>

</html>
