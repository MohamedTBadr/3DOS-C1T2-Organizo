<?php             
include 'connection.php'; 

// $assign=33;
$assign=$_SESSION['user_id'];

$display_query = "SELECT `task_id`, `task_name`, `start_date`, `end_date`, `priority_id` FROM
`task` WHERE `assign_by`= '$assign' OR `assignie`='$assign'";
$run = mysqli_query($connect, $display_query);   


$subs="SELECT * FROM `subscription`  
join `plan` on `subscription`.`plan_id`= `plan`.`plan_id`
join `user` on `subscription`.`user_id`= `user`.`user_id`
where `user`.`user_id` = '$assign'";
$runS = mysqli_query($connect, $subs); 

if (mysqli_num_rows($runS) > 0) {
    $fetch = mysqli_fetch_array($runS);
    $plan_type = $fetch['plan_type'];
    $plan_deadline = date("Y-m-d", strtotime($fetch['end_date']));
    $role = $fetch['role_id'];
} else {
    $plan_type = '';
    $plan_deadline = '';
    $role = '';
}

if (!$runS) {
    // handle the error
    echo "Error: " . mysqli_error($connect);
    exit;
}

$count = mysqli_num_rows($run);  

if ($count > 0) {
    $data_arr = array();
    $i = 0;
    foreach($run as $data_row) {	
        $data_arr[$i]['task_id'] = $data_row['task_id'];
        $data_arr[$i]['task_name'] = $data_row['task_name'];
        $data_arr[$i]['start_date'] = date("Y-m-d", strtotime($data_row['start_date']));
        $data_arr[$i]['end_date'] = date("Y-m-d", strtotime($data_row['end_date']));
        
        // Assign colors based on priority
        if ($data_row['priority_id'] == 1) {
            $data_arr[$i]['bg_color'] = '#033043'; // Dark Blue
            $data_arr[$i]['color'] = '#ffffff';
        } elseif ($data_row['priority_id'] == 2) {
            $data_arr[$i]['bg_color'] = '#FDA521'; // Orange
            $data_arr[$i]['color'] = '#ffffff';
        } elseif ($data_row['priority_id'] == 3) {
            $data_arr[$i]['bg_color'] = '#E9E3D5'; // Yellow
            $data_arr[$i]['color'] = '#ffffff';
        }
        $i++;
        
    }
    if($role == 1){
        $data_arr[]=['plan_type'=>$plan_type, 'deadline_date'=>$plan_deadline];
        $data_arr[$i]['color'] = '#ffffff';
    }

    $data = array(
        'status' => true,
        'msg' => 'Successfully retrieved tasks!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'No tasks found!'
    );
}

echo json_encode($data);
?>
