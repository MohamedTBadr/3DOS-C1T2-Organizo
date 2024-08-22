<?php
// include("connection.php");
include("nav.php");

if(!isset($_SESSION['user_id']))
    header ("Location: index.php");

$user_id=$_SESSION['user_id'];
$select_user = "SELECT * FROM `user` 
                JOIN `plan` ON `user`.`plan_id` = `plan`.`plan_id`
                WHERE `user`.`user_id`= '$user_id'";
$run_user = mysqli_query($connect,$select_user);
$fetch_plan = mysqli_fetch_assoc($run_user);

$plan_id=$fetch_plan['plan_id'];
// echo $plan_id;

$select_plan = "SELECT * FROM `plan` WHERE `plan_id` > $plan_id ";

$run_plan=mysqli_query($connect,$select_plan);

// wanted to loop the comparison but didn't work out

// $select_all="SELECT * FROM `plan` ";
// $run_all=mysqli_query($connect,$select_all);

// if(isset($_POST['choose'])){
//     $new_planid= mysqli_real_escape_string($connect, $_POST['plan_id']);
//     $user_id=$_SESSION['user_id'];
//     $edit=" UPDATE `user`
//             SET `plan_id` = '$new_planid'
//             WHERE `user_id` = '$user_id' ";
//     $run_edit= mysqli_query($connect,$edit);
//     header("Location:subscription.php");
// }
$allPlans = "SELECT * FROM `plan`";
$resAllPlans = mysqli_query($connect, $allPlans);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans</title>
    <link rel="stylesheet" href="css/subscription.css">
    <link rel="icon" type="image/x-icon" href="./img/keklogo.png">
</head>

<body>
    <div class="header">
        <h1>Pricing plans</h1>
        <?php if($plan_id == 1) {?>
        <h4>Discover the best plan for your needs</h4>
        <?php } else if($plan_id == 2) {?>
        <h4>You may consider upgrading to the Business Plan</h4>
        <?php } else if($plan_id == 3) {?>
        <h4>You're currently enjoying the highest tier!</h4>
        <?php } ?>
    </div>
    <div class="pricing-container">
        <?php foreach($run_plan as $plan){ ?>
        <div class="pricing-card">
        <form method="POST">
            <h2 class="card-title"><?php echo $plan['plan_type']?></h2>
            <p class="price">$<?php echo $plan['price']?>/month</p>
            <p class="description">Included in <?php echo $plan['plan_type']?>:</p>
            <ul class="list">
                <li>only up to <?php echo $plan['limit']?> members</li>
                <br>
                <!-- <input type="hidden" name="plan_id"> -->
            </ul>
            <!-- <button name="choose" type="submit" class="btn">select plan -->
                <a class="btn" href="./payment.php?plan=<?php echo $plan['plan_id']?>">Choose Plan</a>
            <!-- </button> -->
        </form>
        </div>
        <?php } ?>

        <!-- <div class="pricing-card">
            <h2 class="card-title">Professional</h2>
            <p class="price">$20/month</p>
            <p class="description">Everything in Free, plus:</p>
            <ul class="list">
                <li> Add up to 7 team members</li>
                <br>
                <li>Task duration</li>
                <br>
            </ul>
            <button class="btn">Choose Plan</button>
        </div>

        <div class="pricing-card">
            <h2 class="card-title">Business</h2>
            <p class="price">$37/month</p>
            <p class="description">Everything in Profissional for every member, plus: </p>
            <ul class="list">
                <li> Add up to 11 team members</li>
                <br>
                <li> Centralized team billing</li>
                <br>
            </ul>
            <button class="btn">Choose Plan</button>
        </div>
        <div class="pricing-card">
            <h2 class="card-title">Advanced</h2>
            <p class="price">$50/month</p>
            <p class="description">Everything in Business for every member, plus: </p>
            <ul class="list">
                <li> Add up to 20 team members</li>
                <br>
                <li>A shared team workspace</li>
                <br>
            </ul>
            <button class="btn">Choose Plan</button>
        </div> -->
    </div class="sectiom-two">
    <div class="header">
        <h1>Compare Our Plans</h1>
        <h4>Explore which option is right for you</h4>
    </div>
    <table class="pricing-table">
        <thead>
            <tr>
                <th>Feature</th>
                <?php foreach ($resAllPlans as $plan) {?>
                <th><?php echo $plan['plan_type']; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Add members</td>
                <td class="false">✘</td>
                <td class="true">✔</td>
                <td class="true">✔</td>
            </tr>
            <tr>
                <td>Sub Tasks</td>
                <td class="true">✔</td>
                <td class="true">✔</td>
                <td class="true">✔</td>
            </tr>
            <tr>
                <td>Member limit</td>
                <?php foreach ($resAllPlans as $plan) {?>
                <td><?php echo $plan['limit']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td>Price</td>
                <?php foreach ($resAllPlans as $plan) {?>
                    <td><?php echo (!empty($plan['price'])) ? "$".$plan['price']."/month" : "Free"; ?></td>
                <?php } ?>
            </tr>

        </tbody>
    </table>
    </div>
</body>

<style>
.pricing-container{
    width: 100%;
    transform: translateX(0%);
    margin-left: 5%;   
}
.pricing-card{
    width: 30%;
}

</style>

</html>