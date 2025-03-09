<?php
// This file is used to check the old password while changing it

session_start();
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Session expired. Please log in again.";
    exit();
}

$user_id = $_SESSION['user_id'];
$old_password = $_POST['password'];

$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $stored_password = $row['password'];

    // 🔹 If passwords are stored in plain text (not recommended)
    if ($old_password === $stored_password) {
        echo "Match";
    } else {
        echo "Incorrect password";
    }

    // 🔹 If passwords are hashed, use password_verify()
    // if (password_verify($old_password, $stored_password)) {
    //     echo "Match";
    // } else {
    //     echo "Incorrect password";
    // }

} else {
    echo "User not found";
}

$stmt->close();
$conn->close();
