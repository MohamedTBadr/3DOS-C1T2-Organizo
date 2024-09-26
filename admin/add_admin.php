<?php  
include("connection.php");
if(isset($_SESSION['admin_id']))
{
    $admin_id=$_SESSION['admin_id'];
}else
    header("location: login_admin.php");

    if(isset($_SESSION['isSuper']))
    {
        $isSuper=$_SESSION['isSuper'];
        $isSuper=1;
    }else
        header("location: login_admin.php");
if(isset($_POST['submit'])){
    $name=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['name'])));
    $email=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect,$_POST['email'])));
    $passwordhashing=password_hash("Aa.123", PASSWORD_DEFAULT);
    $select="SELECT * FROM `admin` WHERE `email` ='$email'";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    $error= "Invalid email format";
else if($rows>0)
    $error= "Email is already taken";
else{
    $insert="INSERT INTO `admin` VALUES(NULL, '$name', '$email', '$passwordhashing', '0')";
    $run_insert=mysqli_query($connect,$insert);
    header("location: display_admins.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/addadmin.css">
    <link href="img/logo.png" rel="icon">
</head>
<body>
<div class="background">
    <div class="container-main">
        <div class="wrapper">
    <a href="admin_profile.php" class="close"><i class="fa-solid fa-x "></i></a>
            <div class="from-wraapper  Sign-in">
            <form method="POST">
                <h2>Add Admin</h2>
                <a href="" class="close"><i class="fa-solid fa-x "></i></a>

                <div class="input-group">
                    <input type="text" required name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                    <label for="">Name</label>
                </div>

                <div class="input-group">
                    <input type="email" required name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <label for="">E-mail</label>
                </div>
            </div>
   
            <div class="buttons">
                <button class="Btn" name="submit" type="submit">Add</button>
            </div>
            <div class="signUp-link">
                <p> <a href="#" class="signUpBtn-link"></a> </p>
            </div>
            <?php if(!empty($error)) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error ?>
                </div>
            <?php } ?>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>