
<?php 
# database connection file
include '../../connection.php';

if (isset($_POST['chat_id']) && isset($_POST['new_message'])) {
    $message_id = $_POST['chat_id'];
    $new_message = $_POST['new_message'];

    $edit_message = "UPDATE `chats` SET `message` = '$new_message' WHERE `chat_id` = '$message_id'";
    $run_edit_message = mysqli_query($connect, $edit_message);

    if ($run_edit_message) {
        echo 'success';  // Return success response for AJAX
    } else {
        echo 'error';  // Return error if query fails
    }
}
