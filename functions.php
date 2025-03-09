<?php
function fetchProfileDetails($conn, $user_id) {
    // Prepare the SQL statement to fetch user details
    $sql = "SELECT user_id, email, first_name, last_name, course, batch, rollno, profile_photo, dob, visibility, role 
            FROM users 
            WHERE user_id = ?";
    
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->get_result();
    
    // Check if the user exists
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return user details as an associative array
    } else {
        return null; // Return null if no user is found
    }
}

