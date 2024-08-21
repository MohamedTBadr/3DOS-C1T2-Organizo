<?php
include("connection.php");
$user_id=$_SESSION['user_id'];
$role_id=$_SESSION['role_id'];
$plan_id=$_SESSION['plan_id'];
echo "$user_id"."<br>";
echo "$role_id"."<br>";
echo "$plan_id"."<br>";

$select_user = "SELECT * FROM `project`
                JOIN `project_member` ON `project`.`project_id` = `project_member`.`project_id`
                JOIN `user` ON `project`.`user_id` = `user`.`user_id`
                WHERE `user`.`user_id` = $user_id";
$run_select=mysqli_query($connect,$select_user);
$fetch_info=mysqli_fetch_assoc($run_select);

$countquery= "SELECT COUNT(*) as member_count FROM `project_member` WHERE `project_id` = '$project_id'";
$countresult= mysqli_query($connect,$countquery);
$countrow= mysqli_fetch_assoc($countresult);

if($countrow['member_count'] >= 5){
    echo "you can only add up to 5 members";
}
// $select_plan="SELECT * FROM `plan` WHERE `plan_id`= '$plan_id' ";
// $run_plan = mysqli_query($connect,$select_plan);

// foreach($run_plan as $value){
// echo $value['limit'];
// }
// echo "<br>";

// $selectuser="SELECT * FROM `user` 
// WHERE `user`.`user_id`='$user_id' AND `role_id`= '$role_id' AND `plan_id`='$plan_id' ";
// $run_userselect=mysqli_query($connect,$selectuser);
// $fetch_user=mysqli_fetch_assoc($run_userselect);
// if($fetch_user){
//     echo "done";
// }
if(isset($_GET['edit'])){
    $planid=$_GET['edit'];
    $edit= "UPDATE `plan` SET `plan_id` = '$planid'";
    $run_edit= mysqli_query($connect,$edit);
}

?>

<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>test</title>
    </head>
    <body>
    <h1>User Info</h1>
    <br><br>
<table>
    <thead>
        <tr class="head">
            <th>name</th>
            <th>email</th>
            <th>plan</th>
            <th>upgrade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($fetch_user as $key){ ?>
        <tr>
            <td><?php echo $fetch_user['first_name'] ?></td>
            <td><?php echo $fetch_user['email'] ?></td>
            <td><?php echo $fetch_user['plan_type'] ?> </td>
            <td><a href="pricing.php?edit=<?php echo $fetch_user['plan_id']?>">upgrade</a></td>
        </tr>
    </tbody>
    <?php } ?>
    </table>
    </body>
</html>
