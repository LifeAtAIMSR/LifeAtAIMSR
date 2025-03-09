<?php
// This file is used to update the password pf a user

session_start();

include "../connection.php";

$user_id = $_SESSION['user_id'];
$new_password = $_POST['new_password'];

$sql = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_password, $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error updating user: " . $conn->error;
}
