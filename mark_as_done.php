<?php
session_start();
include("config.php");

if (isset($_POST['taskId']) && isset($_POST['isChecked'])) {
    $taskId = mysqli_real_escape_string($con, $_POST['taskId']);
    $isChecked = mysqli_real_escape_string($con, $_POST['isChecked']);

    $query = "UPDATE `tbl_tasklist` SET `mark_as_done` = '$isChecked' WHERE `id` = '$taskId'";
    $query_result = mysqli_query($con, $query);

    if ($query_result) {
        echo "Marked as done successfully"; // Debugging
    } else {
        echo "Query failed: " . mysqli_error($con); // Debugging
    }
} else {
    echo "Missing taskId or isChecked"; // Debugging
}
?>