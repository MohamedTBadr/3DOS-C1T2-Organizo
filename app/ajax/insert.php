<?php 

# Database connection file
include '../../connection.php';

# Check if the user is logged in
if (isset($_SESSION['user_id'])) {

    if (isset($_POST['message']) && isset($_POST['to_user'])) {

        $message = mysqli_real_escape_string($connect, $_POST['message']);
        $to_id = (int)$_POST['to_user'];
        $from_id = $_SESSION['user_id'];
        $date=date("Y-m-d H:i ");
        $message_file = NULL;

        if(isset($_FILES['file'])){
            $file_path=$_FILES['file']['name'];
            $move_file = move_uploaded_file($_FILES['file']['tmp_name'],'../../img/chat file/'.$file_path);
            if($move_file){
                $message_file=mysqli_real_escape_string($connect,$file_path);
            }
        }
        # Insert message into the chats table
        $sql = "INSERT INTO chats VALUES (NULL, '$from_id', '$to_id', '$message', 0, '$date', '0', '0', " . ($message_file ? "'$message_file'" : "NULL") . ")";
        $res = mysqli_query($connect, $sql);
        
        if ($res) {
            /**
             * Check if this is the first conversation between them
             **/
            $sql2 = "SELECT * FROM conversations WHERE (user_1 = $from_id AND user_2 = $to_id) OR (user_2 = $from_id AND user_1 = $to_id)";
            $result2 = mysqli_query($connect, $sql2);

            // Setting up the time Zone
            define('TIMEZONE', 'Africa/Cairo');
            date_default_timezone_set(TIMEZONE);

            $time = date("h:i:s a");

            if (mysqli_num_rows($result2) == 0) {
                # Insert into conversations table
                $sql3 = "INSERT INTO conversations (user_1, user_2) VALUES ($from_id, $to_id)";
                mysqli_query($connect, $sql3);
            }
            ?>

            <p class="rtext align-self-end border rounded p-2 mb-1">
                <?= htmlspecialchars($message) ?>  
                <small class="d-block"><?= htmlspecialchars($time) ?></small>      	
            </p>

            <?php 
        }
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>
