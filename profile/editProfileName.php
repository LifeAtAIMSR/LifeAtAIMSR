<?php
// This file is used to edit the name of the user from profilepage.php

include '../connection.php';
include '../function.php';

session_start();

$user_id = $_SESSION['user_id'];

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

$sql = "UPDATE users SET first_name = ?, last_name = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $firstName, $lastName, $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error updating user: " . $conn->error;
}