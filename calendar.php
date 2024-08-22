<?php             
include 'nav.php';
if(!isset($_SESSION['user_id']))
    header ("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
    <!-- CSS for full calendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS for full calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        /* Customize the calendar header */
.fc-header {
  background-color: #333;
  color: #fff;
  padding: 10px;
  border-bottom: 1px solid #333;
}

.fc-header-toolbar {
  padding: 10px;
}

.fc-button {
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
}

.fc-button:hover {
  background-color: #23527c;
}

.fc-button:active {
  background-color: #1d4e7a;
}

/* Customize the calendar body */
.fc-body {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
}

.fc-day-grid {
  background-color: #fff;
  border: 1px solid #ddd;
}

.fc-day {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.fc-day:hover {
  background-color: #f5f5f5;
}

.fc-event {
  background-color: #337ab7;
  color: #fff;
  border-radius: 5px;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
}

.fc-event:hover {
  background-color: #23527c;
}

.fc-event:active {
  background-color: #1d4e7a;
}

/* Customize the event rendering */
.fc-event-time {
  font-size: 14px;
  color: #666;
}

.fc-event-title {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

/* Customize the today button */
.fc-today-button {
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
}

.fc-today-button:hover {
  background-color: #23527c;
}

.fc-today-button:active {
  background-color: #1d4e7a;
}
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Calendar</h1>
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: 'display_task.php',
        dataType: 'json',
        success: function(response) {
            if (response.status && response.data.length > 0) {
                var tasks = [];
                $.each(response.data, function(i, item) {
                    tasks.push({
                        title: item.task_name,
                        start: item.start_date,
                        end: item.end_date,
                        backgroundColor: item.bg_color,
                        textColor: item.color
                    });
                    if (item.plan_type) {
                        tasks.push({
                            title: item.plan_type,
                            start: item.deadline_date,
                            end: item.deadline_date,
                            textColor: item.color
                        });
                    }
                });

                $('#calendar').fullCalendar({
                    defaultView: 'month',
                    editable: true,
                    events: tasks,
                    eventRender: function(event, element) {
                        element.bind('click', function() {
                            alert(event.title + "\nStart: " + event.start.format("YYYY-MM-DD") + "\nEnd: " + event.end.format("YYYY-MM-DD"));
                        });
                    }
                });
            } else {
                $('#calendar').fullCalendar({
                    defaultView: 'month',
                    editable: true
                });
            }
        },
        error: function(xhr, status) {
            alert('Error fetching data.');
        }
    });
});
</script>
</body>
</html>
