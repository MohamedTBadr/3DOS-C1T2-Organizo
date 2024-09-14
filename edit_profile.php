<?php
include('connection.php');
$error="";
$firstname="";    
$lastname="";    
$phone_number="";
$popup=false;
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
        $popup = true;
        header("refresh:2; url= userprof.php");
    }else{
        $update = "UPDATE `user` SET `first_name`='$firstname', 
                                    `last_name`='$lastname', 
                                    `phone_number`='$phone_number' ,
                                    `image`='$image' WHERE `user_id`='$userid'";
        $run_update = mysqli_query($connect, $update);
        move_uploaded_file($_FILES['image']['tmp_name'],"./img/profile/".$image);
        $popup = true;
        header("refresh:2; url= userprof.php");
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
<style>
:root{
    --white: #fcfcfc;
    --gray: #cbcdd3;
    --dark: #777777;
    --error: #ef8d9c;
    --orange: #ffc39e;
    --success: #b0db7d;
    --secondary: #99dbb4;
}


@import url("https://fonts.googleapis.com/css?family=Lato:400,700");

/* $font: "Lato", sans-serif; */



.containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

#containerr {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 700px;
  height: 250px;
} 

/* h1 {
  font-size: 0.9em;
  font-weight: 100;
  letter-spacing: 3px;
  padding-top: 5px;
  color: var(--white) ;
  padding-bottom: 5px;
  text-transform: uppercase;
} */

.green {
  color:var(--secondary);
   /* darken($secondary, 20%); */
}

.red {
  color: var(--error);
  /* darken($error, 10%); */
}

.alert {
  font-weight: 700;
  letter-spacing: 5px;
}

p {
  margin-top: -5px;
  /* font-size: 0.5em; */
  /* font-weight: 100; */
  color: var(--white);
  /* darken($dark, 10%); */
  letter-spacing: 1px;
}

button,
.dot {
  cursor: pointer;
}

#success-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom right, var(--success) , var(--secondary) );
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
  perspective: 40px;
}

#error-box {
  position: absolute;
  width: 100%;
  height: 100%;
  right: 0;
  background: linear-gradient(to bottom left, var(--error) 40%, var(--orange) 100%);
  border-radius: 20px;
  box-shadow: 5px 5px 20px rgba(var(--gray), 10%);
}

.dot {
  width: 8px;
  height: 8px;
  background: var(--white);
  border-radius: 50%;
  position: absolute;
  top: 4%;
  right: 6%;

}
.dot:hover {
    background: darken(var(--white), 20%);
  }

.two {
  right: 12%;
  opacity: 0.5;
}

.face {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: bounce 1s ease-in infinite;
}

.face2 {
  position: absolute;
  width: 22%;
  height: 22%;
  background: var(--white);
  border-radius: 50%;
  border: 1px solid var(--dark);
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: roll 3s ease-in-out infinite;
}

.eye {
  position: absolute;
  width: 5px;
  height: 5px;
  background: var(--dark);
  border-radius: 50%;
  top: 40%;
  left: 20%;
}

.right {
  left: 68%;
}

.mouth {
  position: absolute;
  top: 43%;
  left: 41%;
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.happy {
  border: 2px solid;
  border-color: transparent var(--dark) var(--dark) transparent;
  transform: rotate(45deg);
}

.sad {
  top: 49%;
  border: 2px solid;
  border-color: var(--dark) transparent transparent var(--dark);
  transform: rotate(45deg);
}

.shadow {
  position: absolute;
  width: 21%;
  height: 3%;
  opacity: 0.5;
  background: var(--dark);
  left: 40%;
  top: 43%;
  border-radius: 50%;
  z-index: 1;
}

.scale {
  animation: scale 1s ease-in infinite;
}
.move {
  animation: move 3s ease-in-out infinite;
}

.message {
  position: absolute;
  width: 100%;
  text-align: center;
  height: 40%;
  top: 47%;
  
}

.button-box {
  position: absolute;
  background: var(--white);
  width: 50%;
  height: 15%;
  border-radius: 20px;
  top: 73%;
  left: 25%;
  outline: 0;
  border: none;
  box-shadow: 2px 2px 10px rgba(var(--dark), 0.5);
  transition: all 0.5s ease-in-out;
}
.button-box:hover {
    /* background: darken(var(--white), 5%); */
    transform: scale(1.05);
    transition: all 0.3s ease-in-out;
  }

@keyframes bounce {
  50% {
    transform: translateY(-10px);
  }
}

@keyframes scale {
  50% {
    transform: scale(0.9);
  }
}

@keyframes roll {
  0% {
    transform: rotate(0deg);
    left: 25%;
  }
  50% {
    left: 60%;
    transform: rotate(168deg);
  }
  100% {
    transform: rotate(0deg);
    left: 25%;
  }
}

@keyframes move {
  0% {
    left: 25%;
  }
  50% {
    left: 60%;
  }
  100% {
    left: 25%;
  }
}

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup4 {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>

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
    
<div class="overlay" id="overlay" onclick="closePopup4()"></div>
    <div class="containerr popup4" id="popup4">
        <div id="success-box">
          <div class="dot"></div>
          <div class="dot two"></div>
          <div class="face">
            <div class="eye"></div>
            <div class="eye right"></div>
            <div class="mouth happy"></div>
          </div>
          <div class="shadow scale"></div>
          <div class="message">
            <!-- <h1 class="alert">Success!</h1> -->
            <p>Your Edits have been applied successfully.</p>
         </div>
          <!-- <button type="submit" class="button-box"><h1 class="green">continue</h1></button> -->
        </div>
        </div>
                                </div>
<script src="bootstrab/js/bootstrap.min.js"></script>
<script>
        function openPopup4() {
            document.getElementById('popup4').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup4() {
            document.getElementById('popup4').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($popup){ ?>
        // Automatically open the popup if $popup is true
        openPopup4();
        <?php } ?>
        </script>
</body>

</html>
