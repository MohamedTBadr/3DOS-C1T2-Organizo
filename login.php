<?php
// YOSAB WDES
// Farah - Magda - SHEHAB WDEV
include 'mail.php';
$Smsg = '';
if (isset($_POST['sign-btn']))
{
  $first_name = mysqli_real_escape_string($connect, $_POST['firstname']);
  $last_name =mysqli_real_escape_string($connect, $_POST['lastname']);
  $email =mysqli_real_escape_string($connect, $_POST['sign-email']);
  $password = mysqli_real_escape_string($connect, $_POST['sign-password']);
  $comfirm_password = mysqli_real_escape_string($connect, $_POST['confirm_password']);
  $phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
  $hash_password = password_hash($password, PASSWORD_DEFAULT);
  $select = "SELECT * FROM `user` WHERE `email`='$email'";
  $run_select = mysqli_query($connect, $select);

  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $numbers = preg_match('@[0-9]@', $password);
  $character = preg_match('@[^\w]@', $password);

  $row = mysqli_num_rows($run_select);

  if (empty($first_name) || empty($email) || empty($last_name) || empty($password) || empty($comfirm_password) || empty($phone_number))
    $Smsg = "Please fill required data";
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $Smsg = "Invalid email format";
  elseif ($row > 0)
    $Smsg = "Email is already used";
  elseif ($uppercase < 1 || $lowercase < 1 || $numbers < 1 || $character < 1)
      $Smsg = "Password needs: numbers, uppercase, lowercase letters & a special character";
  elseif ($password != $comfirm_password)
    $Smsg = "Password doesn't match confirm password";
  elseif (strlen($phone_number) != 11)
    $Smsg = "Invalid phone number";
  else
  {
    $_SESSION['firstname'] = $first_name;
    $_SESSION['lastname'] = $last_name;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $hash_password;
    $_SESSION['phone_number'] = $phone_number;
    $rand = rand(10000, 99999);
    $_SESSION['otp'] = $rand; // OTP NOT RAND SESSION FOR REALS!!!!
    $massage = "
      <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a;'>
        <div style='background-color: #0a7273; padding: 20px; text-align: center; color: #fffffa;'>
          <h1>Welcome to Organizo, $first_name!</h1>
        </div>
        <div style='padding: 20px; background-color: #fffffa; color: #00000a;'>
          <p style='color: #00000a;'>Dear <span style='color: #fda521;'>$first_name $last_name</span>,</p>
          <p style='color: #00000a;'>Thank you for registering with Organizo! Please use the OTP below to verify your email address and complete your registration:</p>
          <p style='text-align: center; font-size: 24px; font-weight: bold; color: #fda521;'>$rand</p>
          <p style='color: #00000a;'>If you did not request this registration, please ignore this email.</p>
          <p style='color: #00000a;'>Best regards,<br>The Organizo Team</p>
        </div>
        <div style='background-color: #0a7273; padding: 10px; text-align: center; color: #fffffa;'>
        <p style='color: #fffffa;'>For support and updates, please visit our website or contact us via email.</p>
        <p style='color: #fffffa;'>Email: <a href='mailto:organizohelp@gmail.com' style='color: #fda521;'>organizohelp@gmail.com</a></p>
        </div>
      </body>
      ";
    $old_time = time(); // TIME AS IT IS ON THE THE FORM SUBMISSION
    $_SESSION['old_time'] = $old_time;

    $mail->setFrom('organizohelp@gmail.com', 'Organizo');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Account Activation code';
    $mail->Body = ($massage);
    $mail->send();

    header("location:verification_signup.php");
  }
}

if (isset($_SESSION['user_id'])) // a logged-in user shouldn't access login/signup, Anti-صعاليك measure
{
//  echo "<p>You are already logged in. Redirecting to the homepage...</p>";
//  header("refresh:3;url=index.php");
//  exit();
  // or //
  header("Location: index.php");
}

$Lmsg = "";
$loginError = false;
if (isset($_POST['login']))
{
  $email = mysqli_real_escape_string($connect, $_POST['log-email']); // badr
  $password = mysqli_real_escape_string($connect, $_POST['log-password']); // badr

  if (empty($email))
  {
      $Lmsg = "Email can't be left empty"; // FRONT SPECIAL styling - just in case someone disabled REQUIRED
      $loginError = true;
  }
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
      $Lmsg = "Invalid email format";
      $loginError = true;
  }
  else if (empty($password))
  {
      $Lmsg = "Password can't be left empty";
      $loginError = true;
  }
  else
  {
    $FindEmailstmt = "SELECT * FROM `user` WHERE `email` = '$email'";
    $ExecFindEmail = mysqli_query($connect, $FindEmailstmt);

    if ($ExecFindEmail)
    {
      if (mysqli_num_rows($ExecFindEmail) > 0)
      {
        $data = mysqli_fetch_assoc($ExecFindEmail);
        $hashedPass = $data['password'];
        $plan_id = $data['plan_id'];
        if (password_verify($password, $hashedPass))
        {
          $_SESSION['user_id'] = $data['user_id'];
          $_SESSION['role_id'] = $data['role_id'];
          $_SESSION['f_name'] = $data['first_name'];
          $_SESSION['plan_id'] = $data['plan_id'];
          header("Location: index.php");
        }
        else
        {
          $Lmsg = "Incorrect Password"; // FRONT SPECIAL styling
          $loginError = true;
        }
      }
      else
      {
        $Lmsg = "Email isn't registered"; // FRONT SPECIAL styling
        $loginError = true;
      }

    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>login - signup</title>
	<link rel="stylesheet" type="" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
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
      #s-btn {margin-top: 20px}
    </style>
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true" <?php if (($loginError) || isset($_SESSION['logCHK']) || isset($_GET['LC'])) echo 'checked'; ?>>

			<div class="signup">
				<form method="post">
					<label for="chk" aria-hidden="true">Sign up</label>
                    <div class="warning <?php if(!empty($Smsg)) echo 'visible' ?>">
                        <?php if (!empty($Smsg)) echo $Smsg ?>
                    </div>
					<input type="text" name="firstname" placeholder="First name" required value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''?>">
					<input type="text" name="lastname" placeholder="Last Name" required value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''?>">
                    <input type="email" name="sign-email" placeholder="Email" required value="<?php echo isset($_POST['sign-email']) ? $_POST['sign-email'] : ''?>">
					<input type="password" name="sign-password" placeholder="Password" required value="<?php echo isset($_POST['sign-password']) ? $_POST['sign-password'] : ''?>">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required value="<?php echo isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''?>">
					<input type="text" name="phone_number" placeholder="Phone Number" required value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>">
					<button type="submit" name="sign-btn" id="s-btn">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form class="form" method="post">
					<label for="chk" aria-hidden="true">Login</label>
                    <div class="warning <?php if(!empty($Lmsg)) echo 'visible' ?>">
                        <?php if (!empty($Lmsg)) echo $Lmsg ?>
                    </div>
					<input type="email" name="log-email" placeholder="Email" required value="<?php echo isset($_POST['log-email']) ? $_POST['log-email'] : ''?>">
					<input type="password" name="log-password" placeholder="Password" required value="<?php echo isset($_POST['log-password']) ? $_POST['log-password'] : ''?>">
					<button class="loginbtn" type="submit" name="login">Login</button>
                    <a href="email_otp.php">Forget Password?</a>
				</form>
			</div>
	</div>
</body>
</html>