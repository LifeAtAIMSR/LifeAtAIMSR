<?php

include '../connection.php';
require '../functions.php';

$profileDetails = fetchProfileDetails($conn, 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php var_dump($profileDetails) ?>
</body>
</html>