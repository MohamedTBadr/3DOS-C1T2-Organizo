<?php
include("nav.php");
$error= '';
$done="";
$done='';
if(!isset($_SESSION['user_id']) || !isset($_GET['pid']))
    header ("Location: index.php"); //BACK PLACEHOLDER MAY CHANGE
else
{
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id'];
    $plan_id = $_SESSION['plan_id']; // future uses
    $pid = $_GET['pid'];

    $limit=3; // FRONT - BACK MAY DECIDE TO CHANGE THIS
    if(!isset($_GET['page']))
        $page=1;
    else
        $page=$_GET['page'];

    $num="SELECT * FROM `sprint` WHERE `project_id` = $pid";
    $run_num=mysqli_query($connect, $num);
    $num_rows=mysqli_num_rows($run_num);

    $total_pages=ceil($num_rows / $limit);
    $offset = ($page - 1) * $limit;
    // $select="SELECT * FROM`sprint` limit $limit offset $offset";
    // $run_select=mysqli_query($connect,$select);

    $memberStmt = "SELECT * FROM `project_member` WHERE `user_id` = $user_id AND `project_id` = $pid";
    $ExecMember = mysqli_query($connect, $memberStmt);
    if (mysqli_num_rows($ExecMember) == 0)
        header("Location: index.php"); // not a member = kick

    $sprintsStmt = "SELECT * FROM `sprint` WHERE `project_id` = $pid ORDER BY `end_date` limit $limit offset $offset";
    $ExecSprint = mysqli_query($connect, $sprintsStmt);
    if (mysqli_num_rows($ExecSprint) == 0)
        $error = "There are no sprints for this Project yet";

    if (isset($_GET['ds'])) // del logic
    {
        $sprint_id = $_GET['ds'];
        $DeleteSprStmt = "DELETE FROM `sprint` WHERE `sprint_id` = $sprint_id";
        $ExecDeleteSpr = mysqli_query($connect, $DeleteSprStmt);
        if ($ExecDeleteSpr)
        {
            $done="Sprint deleted successfully!";
            header("location:ViewSprints.php?pid=$pid");
        }
    }

    if (isset($_GET['es'])) //edit logic
    {
        $sprint_id = $_GET['es'];
        $EditSprStmt = "SELECT * FROM `sprint` WHERE `sprint_id` = $sprint_id";
        $ExecEditSpr = mysqli_query($connect, $EditSprStmt);
        $sprintData = mysqli_fetch_assoc($ExecEditSpr);
        if (isset($_POST['update-spr']))
        {
            $sprint_name = $_POST['sprint_name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $UpdateSprStmt = "UPDATE `sprint` SET `sprint_name` = '$sprint_name', `start_date` = '$start_date', `end_date` = '$end_date' WHERE `sprint_id` = $sprint_id";
            $ExecUpdateSpr = mysqli_query($connect, $UpdateSprStmt);
            if ($ExecUpdateSpr)
            {
                $done="Sprint updated successfully!";
                header("Refresh:3; url=ViewSprints.php?pid=$pid");
            }
        }
    }
}
$select="SELECT * FROM sprint ";
$run_select=mysqli_query($connect,$select);
if(isset($_POST['search'])){
    $text=mysqli_real_escape_string($connect, $_POST['text']);

    $select_search="SELECT * FROM sprint WHERE (sprint_name LIKE '%$text%') AND `project_id` = $pid";
    $run_select_search=mysqli_query($connect,$select_search);
    $num_rows = mysqli_num_rows($run_select_search);
    $total_search_pages = ceil($num_rows / $limit);
    $offset = ($page - 1) * $limit;

    $select_search = "SELECT * FROM sprint WHERE (sprint_name LIKE '%$text%') AND `project_id` = $pid LIMIT $limit OFFSET $offset";
    $run_select_search = mysqli_query($connect, $select_search);
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My sprints</title>
        <!-- font awesomr link -->
        <link rel="stylesheet" href="https://fontawesome.com/icons/">
        <link rel="stylesheet" href="css/all.min.css">
        <!-- css link -->
        <link rel="stylesheet" href="css/sprints.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- cdjn link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />

              <style>
                .warning
                {
                    display: none; color: red;
                    position: static;
                    width: 65%;
                    margin: -13% auto -1%;
                    font-size: 1vw;
                }
                .warning.visible {display: block}
                #s-btn {margin-top: 20px}

                .error {
                    font-size: 15px;
                    margin: 2px;
                    text-align: center;
                    color: red;
                    width: 100%;
                }
             
        /* Popup delete styling */
        .popup-sprint {
    display: none; /* Hide popups by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    text-align: center;
    border-radius: 7px;
    color:#58151c;
}

.popup-sprint.show {
    display: block; /* Show popup when class 'show' is added */
}

.overlay {
    display: none; /* Hide overlay by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
}

.overlay.show {
    display: block; /* Show overlay when class 'show' is added */
}

.lol {
    color:#58151c;
}

    /* Custom Popup Styling for SweetAlert */
    .custom-popup .wrapper {
      width: auto;
      border: 2px solid #fff;
      border-radius: 20px;
      margin: 20px auto;
      background-color: rgb(255, 255, 255);
      padding: 40px;
      text-align: center;
    }

    .custom-popup h2 {
      font-size: 40px;
      color: black;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .custom-popup .input-group {
      position: relative;
      margin: 30px 0;
      border-bottom: 2px solid black;
    }

    .custom-popup .input-group label {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      font-size: 16px;
      color: black;
      pointer-events: none;
      transition: .5s;
      top: -5px;
    }

    .custom-popup .input-group input {
      width: 320px;
      height: 40px;
      font-size: 16px;
      color: black;
      padding: 0 5px;
      background: transparent;
      border: none;
      outline: none;
    }
    .btnnn {
        margin-top: -20%;
        background-color: rgba(255, 174, 0, 0.829);
        color: white;
        border: #033043;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
    }
    .btnnn:hover {
        background-color: #033043;
        color: rgb(255, 255, 255);
    }
    div.swal2-actions{
      display: inline-flex;
    justify-content: center;
    flex-direction: row;
    width: 87%;
    flex-wrap: wrap;
    }
    .swal2-popup{
        width: 35%;
        height: 100%;
    }
    .error-message {
      color: red;
      font-size: 14px;
      text-align: left;
      margin-top: 5px;
    }
            </style>
    </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script> 
    $(document).ready(function() {
    $("#searchText").on("input", function() {
        var searchText = $(this).val();
        
        // Prevent search if empty
        if (searchText === "") {
            location.reload();  // Reload the page if search is cleared
            return;
        }
        
        // Perform AJAX request to search
        $.ajax({
            url: "ViewSprints.php?pid=<?php echo $pid ?>", // The same URL for the search
            type: "POST",
            data: {
                text: searchText, // Send the search text
                search: true // Flag to detect the search query
            },
            success: function(data) {
                var results = $(data).find('.pricing-card'); // Extract the updated search results
                $('.pricing-container').html(results); // Update the UI with new search results
            }
        });
    });
});
$('form').on('submit', function(e) {
    //e.preventDefault();  // Prevent the form from submitting in the default way
    var searchText = $('#searchText').val();

    if (searchText === "") {
        location.reload();  // Reload page if search is cleared
        return;
    }

    $.ajax({
        url: "ViewSprints.php?pid=<?php echo $pid ?>", // Same page
        type: "POST",
        data: { text: searchText, search: true },
        success: function(data) {
            var results = $(data).find('.pricing-card');
            $('.pricing-container').html(results);
        }
    });
});

</script>

<body>
    <div class="head">
        <h1>Sprints</h1>
            <button class="start ms-3" onclick="showSprintForm()">+ Add Sprint</button>
    </div>
    <div class="warning <?php if ($error) { echo 'visible'; } ?>">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?php if ($error) { echo $error; } ?>
                </div>
    <div class="done <?php if ($done) { echo 'visible'; } ?>">
    <!-- <i class="fa-solid fa-triangle-exclamation"></i> -->
    <?php if ($done) { echo $done; } ?>
    </div>
    <div class="pricing-container">


        <!-- start first card  -->
        <?php if(isset($_POST['search'])){?>
        <?php foreach ($run_select_search as $data){ ?>
            <div class="pricing-card">
                <div class="d-flex mb-3">
                    <h2 class="card-title"><?php echo $data['sprint_name'] ?></h2>
                    <div class="ms-4">
                        <button type="button" class="icon"><a href="editsprints.php?sid=<?php echo $data['sprint_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button>
                        
                        <button type="button" class="icon" onclick="openSprintPopup(<?php echo $data['sprint_id']?>)">
                            <i class="fa-solid fa-x fs-4" style="color: rgb(151, 2, 2);"></i>
                        </button>
                            <form method="GET" id="deleteSprintForm-<?php echo $data['sprint_id'];?>" style="display:none;">
                            <input type="hidden" name="ds" value="<?php echo $data['sprint_id']; ?>">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            </form>
                    </div>
                </div>

                <p class="due-description"><i class="fa-solid fa-clock"></i> Due date: <?php echo date('d M',strtotime($data['end_date'])) ?></p>
                <?php
                $end = strtotime($data['end_date']); // sec
                $now = time();
                $gap = $end - $now;  // sec
                $days_left = ceil($gap / 86400); // Tarek, my resolute is still strong!! XD 60.60.24, I think ciel is good; 1 instead of 0 days sounds good
                if ($gap < 0) {
                    $days_left = abs($days_left);
                    $message = "$days_left days overdue";
                } else {
                    $message = "$days_left days left";
                }

                ?>
                <p class="left-description"><i class="fa-solid fa-hourglass-start"></i> <?php echo $message ?></p>
                <a href="tasks.php?sid=<?php echo $data['sprint_id'] ?>"><button class="btnn ms-5">Tasks</button></a>
            </div>
            
    <!-- delete popup  -->
    <?php if($role_id == 1) {?>

<!-- Example delete popup HTML -->
<div class="popup-sprint" id="popup-sprint-<?php echo $data['sprint_id']; ?>" role="alert">
<h3><i class="fa-solid fa-triangle-exclamation"></i>Are you sure you want to delete this Sprint?</h3>
<button type="button" class="lol btn btn-outline-dark" onclick="confirmSprintDelete()">Yes</button>
<button type="button" class="lol btn btn-outline-dark" onclick="closeSprintPopup()">No</button>
</div>



<?php } else if ($role_id == 2) { ?>
<div class="popup alert alert-danger w-75" id="popup3" role="alert">
    <h2>Only the Leader can delete sprints</h2>
    <button type="button" class="btn btn-outline-success" onclick="closepopup3()">Understood!</button>
</div>
<?php } ?>
        <?php } ?>
        <!-- end first card  -->
    </div><!-- end cards container -->
    </a>
    
    <?php }else{ ?>


    <!-- start first card  -->
        <?php while ($data = mysqli_fetch_assoc($ExecSprint)) { ?>
            <div class="pricing-card">
                <div class="d-flex mb-3">
                    <h2 class="card-title"><?php echo $data['sprint_name'] ?></h2>
                    <div class="ms-4">
                        <button type="button" class="icon"><a href="editsprints.php?sid=<?php echo $data['sprint_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></button>
                        
                        <button type="button" class="icon" onclick="openSprintPopup(<?php echo $data['sprint_id']?>)">
                            <i class="fa-solid fa-x fs-4" style="color: rgb(151, 2, 2);"></i>
                            </button>

                            <form method="GET" id="deleteSprintForm-<?php echo $data['sprint_id'];?>" style="display:none;">
                            <input type="hidden" name="ds" value="<?php echo $data['sprint_id']; ?>">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            </form>
                    </div>
                </div>

                <p class="due-description"><i class="fa-solid fa-clock"></i> Due date: <?php echo date('d M',strtotime($data['end_date'])) ?></p>
                <?php
                $end = strtotime($data['end_date']); // sec
                $now = time();
                $gap = $end - $now;  // sec
                $days_left = ceil($gap / 86400); // Tarek, my resolute is still strong!! XD 60.60.24, I think ciel is good; 1 instead of 0 days sounds good
                if ($gap < 0) {
                    $days_left = abs($days_left);
                    $message = "$days_left days overdue";
                } else {
                    $message = "$days_left days left";
                }

                ?>
                <p class="left-description"><i class="fa-solid fa-hourglass-start"></i> <?php echo $message ?></p>
                <a href="tasks.php?sid=<?php echo $data['sprint_id'] ?>"><button class="btnn ms-5">Tasks</button></a>

            </div>
                <!-- delete popup  -->
    <?php if($role_id == 1) {?>

<!-- Example delete popup HTML -->
<div class="popup-sprint" id="popup-sprint-<?php echo $data['sprint_id']; ?>" role="alert">
<h3><i class="fa-solid fa-triangle-exclamation"></i>Are you sure you want to delete this sprint?</h3>
<button type="button" class="lol btn btn-outline-dark" onclick="confirmSprintDelete()">Yes</button>
<button type="button" class="lol btn btn-outline-dark" onclick="closeSprintPopup()">No</button>
</div>

<?php } else if ($role_id == 2) { ?>
<div class="popup alert alert-danger w-75" id="popup3" role="alert">
    <h2>Only the Leader can delete sprints</h2>
    <button type="button" class="btn btn-outline-success" onclick="closepopup3()">Understood!</button>
</div>
<?php } ?>
        <?php }} ?>
        <!-- end first card  -->
    </div><!-- end cards container -->


  <ul class="pagination">
  <?php
    if(isset($_POST['search']))
        $total_pages = $total_search_pages;
    else
        $total_pages = ceil($num_rows / $limit);

    if(isset($_GET['page']))
      $currentPage = $_GET['page'];
    else
      $currentPage = 1;
    if($total_pages > 1){
      if($currentPage > 1) {?>
    <li class="page-item">
      <a class="page-link" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php } $max = 0;
    for($pn = 1; $pn <= $total_pages; $pn++) {$max++;?>

    <li class="page-item"><a class="page-link" id="frstnmb" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $pn ?>"><?php echo $pn ?></a></li>
    <?php } ?>
    <li class="page-item">
    <?php if($currentPage != $max) {?>
      <a class="page-link" href="ViewSprints.php?pid=<?php echo $pid ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    <?php } ?>
    </li>
  </ul>
  <?php } ?>

    <script src="js/sprints.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Assume $pid is coming from a PHP variable in your HTML
    var pid = <?php echo json_encode($pid); ?>; // Passing the PHP $pid to JavaScript

    function showSprintForm() {
      Swal.fire({
        title: '',
        html: `
          <div class="custom-popup">
            <div class="wrapper">
              <h2>Add Sprint</h2>
              <div class="input-group">
                <input type="text" id="sprint_name" name="sprint_name" required>
                <label for="sprint_name">Sprint Name</label>
              </div>
              <div class="input-group">
                <input type="date" id="start_date" name="start_date" required>
                <label for="start_date">Start Date</label>
              </div>
              <div class="input-group">
                <input type="date" id="end_date" name="end_date" required>
                <label for="end_date">End Date</label>
              </div>
              <div id="validationMessage" class="error-message"></div>
            </div>
          </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Add Sprint',
        cancelButtonText: 'Cancel',
        customClass: {
          confirmButton: 'btnnn',
          cancelButton: 'btnnn',
        },
        preConfirm: () => {
          const sprint_name = document.getElementById('sprint_name').value;
          const start_date = document.getElementById('start_date').value;
          const end_date = document.getElementById('end_date').value;

          const validationMessage = validateForm(sprint_name, start_date, end_date);

          if (validationMessage) {
            Swal.showValidationMessage(validationMessage);
            return false;
          }

          return { sprint_name, start_date, end_date };
        }
      }).then((result) => {
        if (result.isConfirmed) {
      // Send data via AJAX to your PHP file
      $.ajax({
        type: 'POST',
        url: 'add_sprint.php', 
        data: {
          sprint_name: result.value.sprint_name,
          start_date: result.value.start_date,
          end_date: result.value.end_date,
          pid: pid,
          add_spr: true
        },
        success: function(response) {
          // Show success message
          Swal.fire(
            'Added!',
            'The sprint has been successfully added.',
            'success'
          ).then(() => {
            location.reload();
          });
        },
        error: function() {
          Swal.fire(
            'Error!',
            'An error occurred while adding the sprint.',
            'error'
          );
        }
      });
    }
  });

  // Add input event listeners for real-time validation
  document.getElementById('sprint_name').addEventListener('input', handleValidation);
  document.getElementById('start_date').addEventListener('input', handleValidation);
  document.getElementById('end_date').addEventListener('input', handleValidation);
}

// Function to validate form data
function validateForm(sprint_name, start_date, end_date) {
  const currentDate = new Date().toISOString().split('T')[0];
  const startDateObj = new Date(start_date);
  const endDateObj = new Date(end_date);
  const currentDateObj = new Date(currentDate);
  const diffDays = (endDateObj - startDateObj) / (1000 * 60 * 60 * 24);

  if (!sprint_name) {
    return 'Please fill in Sprint Name';
  }
  if (!start_date) {
    return 'Please fill in Start Date';
  }
  if (!end_date) {
    return 'Please fill in End Date';
  }
  if (diffDays < 7 || diffDays > 30) {
    return 'The sprint duration must be between 7 and 30 days!';
  }
  if (startDateObj <= currentDateObj) {
    return 'Invalid start date. It must be in the future!';
  }

  return '';
}

// Function to handle real-time validation
function handleValidation() {
  const sprint_name = document.getElementById('sprint_name').value;
  const start_date = document.getElementById('start_date').value;
  const end_date = document.getElementById('end_date').value;

  const validationMessage = validateForm(sprint_name, start_date, end_date);
  document.getElementById('validationMessage').textContent = validationMessage;
}
</script>

</body>
</html>
