<?php
// Boshra
include ("connection.php");
$select="SELECT * FROM `task`";
$run_select=mysqli_query($connect,$select);

if(isset($_POST['search_btn'])){
    // $task_name=$_POST['task_name'];
    // $description=$_POST['description'];
    // $assignie=$_POST['assignie'];
    $text=$_POST['text'];

    $select_search="SELECT * FROM `task` WHERE (`task_name` LIKE '%$text%') OR (`description` LIKE '%$text%') OR (`assignie` LIKE '%$text%')";
    $run_select_search=mysqli_query($connect,$select_search);
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST">
        <input type="search" name="text">
        <button type="submit" name="search_btn">submit</button>
    </form>
    <?php if(isset($_POST['search_btn'])) { ?>
    <table>
    
        <thead>
            <tr>
                <th>task_name</th>
                <th>description</th>
                <th>assignie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($run_select_search as $data) { ?>
            <tr>
                <td><?php echo $data['task_name'] ?></td>
                <td><?php echo $data['description'] ?></td>
                <td><?php echo $data['assignie'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php }else{ ?>
    <table>
        <thead>
            <tr>
                <th>task_name</th>
                <th>description</th>
                <th>assignie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($run_select as $data) { ?>
            <tr>
                <td><?php echo $data['task_name'] ?></td>
                <td><?php echo $data['description'] ?></td>
                <td><?php echo $data['assignie'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</body>
</html>