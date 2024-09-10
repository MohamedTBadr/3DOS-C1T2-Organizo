<?php
include("nav.php");
if(!isset($_SESSION['user_id']))
    header ("Location: index.php");
$user_id=$_SESSION['user_id'];

$join = "SELECT p.project_name, COUNT(p.project_id) AS project_count
FROM `user` AS u 
JOIN `project` AS p ON u.`user_id` = p.`user_id`
INNER JOIN `project_member` pm ON p.`project_id` = pm.`project_id`
WHERE pm.`user_id` = $user_id
GROUP BY p.project_name ";

$run_join = mysqli_query($connect, $join);

if (!$run_join) {
    die("Query failed: " . mysqli_error($connect));
}
$data = []; 


while ($row = mysqli_fetch_assoc($run_join)) {
    $data[] = $row;
}

$json = json_encode($data);
mysqli_free_result($run_join);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/chart.css">
    <title>charts</title>
</head>
<body>
    <div class="container">
        <div class="chart">
            <canvas id="doughnut" width="500" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script >
const data = <?php echo $json; ?>;
console.log(data);
const labels = data.map(item => item.project_name);
const counts = data.map(item => parseInt(item.project_count));
const colors = labels.map(() => '#' + Math.floor(Math.random()*16777215).toString(16));

const ctx = document.getElementById('doughnut').getContext('2d');

const doughnut = new Chart(ctx, {
    type: 'doughnut',
    data:  {
    labels: labels,  
    datasets: [{
        label: 'Projects',
        data: counts,  
        backgroundColor: colors,  
        borderWidth: 1
                }]
        }
});
    </script>
</body>
</html> 