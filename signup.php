<?php
include 'mail.php';
$error = FALSE;
$error_message = '';
if (isset($_POST['submit'])) {
    // $user_name = $_POST['username'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $comfirm_password = $_POST['comfirm_password'];
    $phone = $_POST['phone_number'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $select = "SELECT * FROM `user` WHERE `email`='$email'";
    $run_select = mysqli_query($connect, $select);

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $numbers = preg_match('@[0-9]@', $password);
    $character = preg_match('@[^/w]@', $password);
    
    $row = mysqli_num_rows($run_select);
    
    if (empty($first_name) || empty($email) || empty($last_name) || empty($password) || empty($comfirm_password) || empty($phone)) {
        $error = TRUE;
        $error_message = "Please fill required data";
    } elseif (strlen($phone) != 11) {
        $error = TRUE;
        $error_message = "Invalid phone number";
    } elseif ($row > 0) {
        $error = TRUE;
        $error_message = "Email is already used";
    } elseif ($password != $comfirm_password) {
        $error = TRUE;
        $error_message = "Password doesn't match confirm password";
    } elseif ($uppercase < 1 || $lowercase < 1 || $numbers < 1 || $character < 1) {
        $error = TRUE;
        $error_message = "Password doesn't contain uppercase, lowercase, numbers or a special character";
    } else {
        $_SESSION['firstname'] = $first_name;
        $_SESSION['lastname'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $hash_password;
        $_SESSION['phone_number'] = $phone;
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
        $old_time = time(); // TIME AS IT IS ON THE THE FORM SUBMISSION !11!111!1!111!
        $_SESSION['old_time'] = $old_time;

        // PHP mail start
        // $mail->setFrom('mohamedtarekbadr047@gmail.com', 'website_name'); // sender mail address, website name
        $mail->setFrom('organizohelp@gmail.com', 'Organizo');
        $mail->addAddress($email); // receiver mail address
        $mail->isHTML(true);
        $mail->Subject = 'Account Activation code'; // mail subject
        $mail->Body = ($massage); // mail content
        $mail->send();
        // PHP mail end
        
        header("location:verification_signup.php");
    }
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap" rel="stylesheet">
    <title>Sign up form</title>
    <link rel="stylesheet" type="text/css" href="css/sign up.css">
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
    <!-- Start of form -->
    <div class="wrapper">
        <div class="layer"></div>
        <div class="from-wraapper Sign-in">
            <form method="POST">
                <h2>Sign up</h2>
                <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                    <?php if ($error) { echo $error_message; } ?>
                </div>
                
                <div class="radio-contianer"></div>

                <div class="input-group">
                    <input type="text" name="firstname">
                    <label for="">
                        <h3 class="haveaccount">First name</h3>
                    </label>
                </div>

                <div class="input-group">
                    <input type="text" name="lastname">
                    <label for="">
                        <h3 class="haveaccount" name="last_name">Last name</h3>
                    </label>
                </div>
                
                <div class="input-group">
                    <input type="password" name="password">
                    <label for="">
                        <h3 class="haveaccount">Password</h3>
                    </label>
                </div>

                <div class="input-group">
                    <input type="password" name="comfirm_password">
                    <label for="">
                        <h3 class="haveaccount">Confirm Password</h3>
                    </label>
                </div>
                
                <div class="input-group">
                    <input type="email" name="email">
                    <label for="">
                        <h3 class="haveaccount">E-mail</h3>
                    </label>
                </div>
                
                <div class="input-group">
                    <input type="number" name="phone_number">
                    <label for="">
                        <h3 class="haveaccount">Phone number</h3>
                    </label>
                </div>

                <button name="submit">
                    <span class="transition"></span>
                    <span class="gradient"></span>
                    <span class="label">Submit</span>
                </button>
                
                <div class="signUp-link">
                    <p class="haveaccount">Already have an account? <a href="login.php" class="signUpBtn-link">login</a></p>
                </div>
            </form>
        </div>
    </div>
    <!-- End of form -->

    <script src="js/signup.js"></script>
</body>
</html>
