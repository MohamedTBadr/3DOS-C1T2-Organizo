<?php
// display_users.php
include "connection.php";
if (isset($_GET['hold'])) {
    $user_id = $_GET['hold'];
    $update = "UPDATE `user` SET `user_hidden` = 1 WHERE `user_id` = $user_id";
    mysqli_query($connect, $update);
    header("Location: display_users.php"); // Redirect to refresh the page
}

if (isset($_GET['unhold'])) {
    $user_id = $_GET['unhold'];
    $update = "UPDATE `user` SET `user_hidden` = 0 WHERE `user_id` = $user_id";
    mysqli_query($connect, $update);
    header("Location: display_users.php"); // Redirect to refresh the page
}

if (isset($_GET['delete'])) {
    $user_id =$_GET['delete']; 

    // Prepare the DELETE query
    $delete = "DELETE FROM user WHERE user_id = $user_id";
    if (mysqli_query($connect, $delete)) {
        echo "Admin has been removed.";

        header("Location: display_users.php");

    } else {
        echo "Error: " . mysqli_error($connect);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Search</title>
    <!-- Bootstrap and jQuery CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Search Users</h1>
        <form>
            <input type="search" id="searchText" placeholder="Search by username" class="form-control mb-3">
        </form>
        
        <table class="table table-bordered" id="example">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Member type</th>
                    <th>Plan</th>
                    <th>Hold</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic content will be loaded here via Ajax -->
            </tbody>
        </table>
    </div>

<script src="js/search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11 "></script>
<script>

function deleteItem(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'You will not be able to recover this member!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'GET',
        url: 'display_users.php',
        data: { delete: id },
        success: function(response) {
              Swal.fire(
                'Deleted!',
                'The member has been removed.',
                'success'
              ).then(() => {
                location.reload();
              });
            },
      });
    }
  });
}



</script>
</body>
</html>
