<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['mark_as_done'])) {
    $id = intval($_POST['id']);
    $mark_as_done = intval($_POST['mark_as_done']);
    
    $query = "UPDATE `tbl_tasklist` SET `mark_as_done` = ? WHERE `id` = ? AND `student_id` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iii", $mark_as_done, $id, $_SESSION['student_id']);
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
    $stmt->close();
}
?>
