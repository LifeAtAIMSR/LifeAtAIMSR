<?php

include '../connection.php';
include '../functions.php';

session_start();

$_SESSION['user_id'] = 1;

$user_id = $_SESSION['user_id'];

$profileDetails = fetchProfileDetails($conn, $user_id);


function displayDefaultGroupDetails($conn, $user_id) {
    $groups = fetchDefaultGroupIdAndRole($conn, $user_id);

    if (empty($groups)) {
        echo "User is not part of any default group.";
        return;
    }

    foreach ($groups as $group) {
        $grpId = $group['default_group_id'];
        $grpRole = $group['role'];

        $groupDetails = fetchDefaultGroupDetails($conn, $grpId);

        if (!$groupDetails) {
            echo "Group details not found for Group ID: $grpId <br>";
            continue;
        }

        echo $groupDetails['course'], ' ', $groupDetails['batch'], ' ', $grpRole, "<br><br>";
    }
}

function fetchDefaultGroupIdAndRole($conn, $user_id) {
    $sql = "SELECT default_group_id, role FROM default_group_member WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $groups = [];
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }

    return $groups;
}

function fetchDefaultGroupDetails($conn, $group_id) {
    $sql = "SELECT course, batch FROM default_group WHERE default_group_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $group_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function countFollowers($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM user_followers WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $follower_count = 0;
    $stmt->bind_result($follower_count);
    $stmt->fetch();
    $stmt->close();
    
    return $follower_count;
}

function countFollowing($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM user_followers WHERE follower_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $following_count = 0;
    $stmt->bind_result($following_count);
    $stmt->fetch();
    $stmt->close();
    
    return $following_count;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <div class="profile-details-wrapper">
        <div class="profile-email">
            <?php echo $profileDetails['email']; ?>
        </div>

        <div class="profile-name" id="profile-name">
            <?php echo $profileDetails['first_name'],  " ",  $profileDetails['last_name'] ; ?>
        </div>

        <div class="profile-role">
            <?php echo $profileDetails['role']; ?>
        </div>

        <div class="profile-course">
            <?php echo $profileDetails['course'], " ", $profileDetails['batch'];; ?>
        </div>

        <div class="profile-bday">
            <?php echo $profileDetails['dob']; ?>
        </div>
    </div>

    <div class="groups-wrapper">
        <h2>GROUPS</h2>
        <?php displayDefaultGroupDetails($conn, $user_id); ?>
    </div>

    <div class="followers-wrapper">
        <div class="followers-container">
            <?php echo countFollowers($conn, user_id: $user_id); ?>
            <br>
            Followers
        </div>
        <div class="following-container">
            <?php echo countFollowing($conn, $user_id); ?>
            <br>
            Following
        </div>
    </div>

    <div class="posts-wrapper">
        <h2>POSTS</h2>
    </div>

    <div class="edit-profile-wrapper">
        <h2>EDIT</h2>
        <h3>Name</h3>
        First Name: <input type="text" id="edit-first-name-field" value=<?php echo fetchProfileDetails($conn, $user_id)['first_name']?> >
        Last Name: <input type="text" id="edit-last-name-field" value=<?php echo fetchProfileDetails($conn, $user_id)['last_name']?> >
        <input type="button" id="edit-name-btn" value="Update">
        <h3>Password</h3>
        <input type="password" id="original-password-field" placeholder="Original Password">
        <input type="password" id="new-password-field" placeholder="New Password">
        <input type="button" id="change-password-btn" value="Change">
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="editProfile.js"></script>
</html>