<?php
include "connection.php";

// Query to count the number of users in each plan
$query = "SELECT `plan`.`plan_type`, COUNT(user_id) as `user_count` FROM `subscription` 
    JOIN `plan` ON `subscription`.`plan_id` = `plan`.`plan_id`
    GROUP BY `plan`.`plan_type`";
$result = mysqli_query($connect, $query);

$plans = [];
$user_counts = [];

// Fetch results from the query
while ($row = mysqli_fetch_assoc($result)) {
    $plans[] = $row['plan_type'];        // xValues (plan types)
    $user_counts[] = $row['user_count'];  // yValues (number of users)
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User/Plan Chart</title>
    <link href="img/logo.png" rel="icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body>
<canvas id="myChart" style="width:100%;max-width:700px;margin:10% auto;"></canvas>

</body>
<script>
// PHP arrays converted to JavaScript arrays
var xValues = <?php echo json_encode($plans); ?>;
var yValues = <?php echo json_encode($user_counts); ?>;
var barColors = ["#fda521", "#6db1a6", "#FFCE56"];  // Different colors for each bar

// Create separate datasets for each plan type
var datasets = xValues.map(function(plan, index) {
  return {
    label: plan,  // Use the plan type as the label
    backgroundColor: barColors[index],  // Assign color to each plan
    data: [yValues[index]],  // Each plan has its own dataset
    // Set the bar width to fill the space properly
    barPercentage: 0.5
  };
});

new Chart("myChart", {
  type: "bar",
  data: {
    labels: ['Users'],  // Single x-axis label
    datasets: datasets  // Multiple datasets, one for each plan
  },
  options: {
    legend: { 
      display: true,
      onClick: function(e, legendItem) {
        var index = legendItem.datasetIndex;
        var chart = this.chart;
        var meta = chart.getDatasetMeta(index);
        // Toggle the visibility of the clicked dataset
        meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
        chart.update();
      }
    },
    title: {
      display: true,
      text: "Number of Users per Plan"
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          stepSize: 1  // Ensure the y-axis starts at 0
        }
      }]
    }
  }
});
</script>
</html>
