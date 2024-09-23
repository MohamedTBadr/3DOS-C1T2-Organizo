// Function to fetch data from server-side and render charts
async function loadChartData() {
    // Fetch the JSON data from the server
    const response = await fetch('./charts.php');
    const data = await response.json();

    const { usernames, taskCounts, commentCounts, chatCounts, months, userCounts, plans, user_counts, roles, roleUserCounts } = data;

    // Active Users Chart
    const ctxActiveUsers = document.getElementById('activeUsersChart').getContext('2d');
    const activeUsersChart = new Chart(ctxActiveUsers, {
        type: 'bar',
        data: {
            labels: usernames,
            datasets: [
                {
                    label: 'Tasks',
                    data: taskCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Comments',
                    data: commentCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Chats',
                    data: chatCounts,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            },
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Most Active Users by Tasks, Comments, and Chats' }
            }
        }
    });

    // Donut Chart - User Signups by Month
    const ctxDonut = document.getElementById('myDonutChart').getContext('2d');
    const myDonutChart = new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: months,
            datasets: [{
                label: 'User Signups',
                data: userCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'User Signups by Month' }
            }
        }
    });

    // Bar Chart - Number of Users per Plan
    const barColors = [
        'rgba(255, 99, 132, 0.2)',  // Matching "Tasks" color
        'rgba(54, 162, 235, 0.2)'   // Matching "Comments" color
    ];
    const borderColors = [
        'rgba(255, 99, 132, 1)',  // Matching "Tasks" border color
        'rgba(54, 162, 235, 1)'   // Matching "Comments" border color
    ];

    const datasets = plans.map((plan, index) => ({
        label: plan,
        backgroundColor: barColors[index],
        borderColor: borderColors[index],
        borderWidth: 1,
        data: [user_counts[index]],
        barPercentage: 0.3
    }));

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: ['Users'],
            datasets: datasets
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    onClick: function(e, legendItem) {
                        var index = legendItem.datasetIndex;
                        var chart = this.chart;
                        var meta = chart.getDatasetMeta(index);
                        meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
                        chart.update();
                    }
                },
                title: { display: true, text: "Number of Users per Plan" }
            },
            scales: {
                y: {
                    ticks: { beginAtZero: true, stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // Pie Chart - Role-Based User Distribution
    const ctxRole = document.getElementById('roleDistributionChart').getContext('2d');
    const roleDistributionChart = new Chart(ctxRole, {
        type: 'pie',
        data: {
            labels: roles,
            datasets: [{
                data: roleUserCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Role-Based User Distribution' }
            }
        }
    });
}

// Load the chart data when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', loadChartData);
