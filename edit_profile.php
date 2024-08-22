<?php
include('connection.php');
$error="";
$firstname="";    
$lastname="";    
$phone_number="";

if(!isset($_SESSION['user_id']))
    header ("Location: index.php");

$userid=$_SESSION['user_id'];
$select="SELECT * FROM `user` WHERE `user_id`=$userid";
$run_select=mysqli_query($connect,$select);
$fetch=mysqli_fetch_assoc($run_select);
$first_name=$fetch['first_name'];
$last_name=$fetch['last_name'];
$phone_number=$fetch['phone_number'];

if (isset($_POST['update'])){
       
    $firstname=mysqli_real_escape_string($connect,$_POST['firstname']);
    $lastname=mysqli_real_escape_string($connect,$_POST['lastname']);
    $phone_number=mysqli_real_escape_string($connect,$_POST['phone_number']);
    $role=$_SESSION['role_id'];
    $image=$_FILES['image']['name'];
    if (strlen($phone_number) != 11) {
        $error ="Please enter a valid phone number";
    }elseif(empty($image)){
        $update = "UPDATE `user` SET `first_name`='$firstname', 
                                    `last_name`='$lastname', 
                                    `phone_number`='$phone_number' WHERE `user_id`='$userid'";
        $run_update = mysqli_query($connect, $update);
        header('location: userprof.php');
    }else{
        $update = "UPDATE `user` SET `first_name`='$firstname', 
                                    `last_name`='$lastname', 
                                    `phone_number`='$phone_number' ,
                                    `image`='$image' WHERE `user_id`='$userid'";
        $run_update = mysqli_query($connect, $update);
        move_uploaded_file($_FILES['image']['tmp_name'],"./img/profile/".$image);
        header('location: userprof.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrab link -->
    <link rel="stylesheet" href="bootstrab/css/bootstrap.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/edit.css">
    <title>Edit profile</title>
</head>

<body>
    <div class="main">
        <div class="head">
            <h1>Edit Profile</h1>
        </div>
        <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?php if ($error) { echo $error; } ?>
                </div>
        <div class="container">
        <a href="userprof.php" class="close"><i class="fa-solid fa-x "></i></a>
            <!-- lw mfeesh image it's likely you don't have the img in img/profile/ folder or theres no image in database  -->

            <img src="./img/profile/<?php echo $fetch['image'] ?>" alt="">
            <div class="forms">
                <form method="POST"  enctype="multipart/form-data">
                <!-- first name input div -->
    

                <div class="form-group">
                    <label for="first"> First Name</label>
                    <input type="text" id="first"  value="<?php echo $first_name ?>" name="firstname" placeholder="Your Name">
                </div>
                <div class="form-group">
                    <label for="last">Last Name</label>
                    <input  type="text" id="last" value="<?php echo $last_name ?>" name="lastname" placeholder="Your Name">
                </div>

                
                <div class="form-group">
                    <label for="lname">Phone Number</label>
                    <input type="number" class="form-control" name="phone_number" id="lname" value="<?php echo $phone_number ?>" placeholder="Phone Number">
                </div>
             


                <!-- change img input -->
                <div class="form-group">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Proflie Image:</label>
                    
                    <input class="form-control" type="file" id="formFile" value="<?php echo $image?>"name="image">
                    
                </div>
                </div>


                <!-- submit btn -->
                <!-- <div class="btnn">
                    <button type="submit" class="btn btn-light"name="update">Submit</button>
                    
                </div>  -->
                <button type="submit" name="update">Submit</button>
            </div>

        </div>
    </form>
    </div>
<script src="bootstrab/js/bootstrap.min.js"></script>
</body>

</html>
