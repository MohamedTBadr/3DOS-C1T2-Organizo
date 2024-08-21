<?php
include ("connection.php");

if(!isset($_SESSION['user_id'])){
    header("Location: index.php"); // BACK PLACEHOLDER MAY CHANGE
}else {
    $id= $_SESSION['user_id'];
    $error="";
    $select="SELECT * FROM `user` WHERE `user_id` = '$id'";
    $run_select=mysqli_query($connect,$select);
    $fetch=mysqli_fetch_assoc($run_select);

    $fetcholdpass=$fetch['password'];
    if(isset($_POST['edit'])){
        $old_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];
        $uppercase = preg_match('@[A-Z]@', $new_password);
        $lowercase = preg_match('@[a-z]@', $new_password);
        $number = preg_match('@[0-9]@', $new_password);
        $character = preg_match('@[^/w]@', $new_password);
        if(empty ($new_password) || empty ($confirm_password)){
            $error = "Please enter the empty fields";
        }elseif ($uppercase < 1 || $lowercase < 1 || $number < 1 || $character <1) {
            $error = "Password must contain uppercase, lowercase, numbers, characters";
        }elseif ($new_password != $confirm_password) {
            $error = "New password doesn't match confirm password";
        }else{
            if(password_verify($old_password,$fetcholdpass)){
                if($new_password == $confirm_password){
                    $new_hashed=password_hash($new_password,PASSWORD_DEFAULT);
                    $update="UPDATE `user` SET `password`='$new_hashed' WHERE `user_id`=$id";
                    $run_update=mysqli_query($connect,$update);
                    if($run_update){
                        session_unset();
                        session_destroy();
                        header("location:login.php?LC=1");
                    }else{
                        $error = "Failed to update password.";
                    }
                }
            }else{
                $error= "Old password is wrong";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>edit password</title>
    <link rel="stylesheet" type="text/css" href="./css/Edit password.css">
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
<div class="wrapper">
    <a href="userprof.php" class="close"><i class="fa-solid fa-x "></i></a>
    <div class="from-wraapper  Sign-in">
        <form method="POST">
            <h2>Edit password</h2>
            <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                <?php if ($error) { echo $error; } ?>
            </div>


            <div class="input-group">
                <input type="password" required name="old_password">
                <label for="">Old Password</label>
            </div>


            <div class="input-group">
                <input type="password" required name="new_password">
                <label for="">New password</label>
            </div>

            <div class="input-group">
                <input type="password" required name="confirm_password">
                <label for="">Confirm new password</label>
            </div>


            <button type="submit" name="edit">Submit</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>

</html>
