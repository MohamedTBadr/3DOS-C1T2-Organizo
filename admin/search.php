<?php
// search.php
include "connection.php";

if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $select = "SELECT * FROM user 
               JOIN `plan` ON `user`.`plan_id` = `plan`.`plan_id` 
               JOIN `role` ON `user`.`role_id` = `role`.`role_id` 
               WHERE first_name LIKE '%$searchText%' OR last_name LIKE '%$searchText%' OR email LIKE '%$searchText%'
               ORDER BY 
               CASE 
                   WHEN `plan`.`plan_type` = 'Business' THEN 1 
                   WHEN `plan`.`plan_type` = 'Professional' THEN 2 
                   ELSE 3 
               END";
    $runSelect = mysqli_query($connect, $select);

    if (mysqli_num_rows($runSelect) > 0) {
        while ($row = mysqli_fetch_assoc($runSelect)) {
            echo "<tr><td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['role_name'] . "</td>
                <td>" . $row['plan_type'] . "</td>";

            // Hold/Unhold button logic under "Hold" column
            if ($row['plan_type'] == 'Professional' || $row['plan_type'] == 'Business') {
                if ($row['user_hidden'] == 0) {
                    echo "<td><a href='display_users.php?hold=" . $row['user_id'] . "'>
                        <button type='submit' name='hold' class='btn btn-danger'>Hold</button></a></td>";
                } else {
                    echo "<td><a href='display_users.php?unhold=" . $row['user_id'] . "'>
                        <button type='submit' name='unhold' class='btn btn-success'>Unhold</button></a></td>";
                }
            } else {
                echo "<td></td>"; // Leave it empty for other plans
            }

            // Placeholder for Delete button (if needed)
            echo "<td><button type='button' class='btn btn-danger' onclick='deleteItem(" . $row['user_id'] . ")'>Delete</button></td>";


            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No users found</td></tr>";
    }
} else {
    $select = "SELECT * FROM user 
               JOIN `plan` ON `user`.`plan_id` = `plan`.`plan_id` 
               JOIN `role` ON `user`.`role_id` = `role`.`role_id`";
    $runSelect = mysqli_query($connect, $select);

    if (mysqli_num_rows($runSelect) > 0) {
        while ($row = mysqli_fetch_assoc($runSelect)) {
            echo "<tr><td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['role_name'] . "</td>
                <td>" . $row['plan_type'] . "</td>";

            // Hold/Unhold button logic under "Hold" column
            if ($row['plan_type'] == 'Professional' || $row['plan_type'] == 'Business') {
                if ($row['user_hidden'] == 0) {
                    echo "<td><a href='display_users.php?hold=" . $row['user_id'] . "'>
                        <button type='submit' name='hold' class='btn btn-danger'>Hold</button></a></td>";
                } else {
                    echo "<td><a href='display_users.php?delete=" . $row['user_id'] . "'>
                        <button type='submit' name='unhold' class='btn btn-success'>Unhold</button></a></td>";
                }
            } else {
                echo "<td></td>"; // Leave it empty for other plans
            }

            // Placeholder for Delete button (if needed)
            echo "<td><button type='button' class='btn btn-danger' onclick='deleteItem(" . $row['user_id'] . ")'>Delete</button></td>";


            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No users found</td></tr>";
    }
}
?>
