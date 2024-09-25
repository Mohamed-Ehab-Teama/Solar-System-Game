<?php
// progress.php

require_once ('../connection.php');



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user progress and coins
$progress_stmt = $connection->prepare("SELECT * FROM users WHERE id = :user_id");
$progress_stmt->execute(['user_id' => $user_id]);
$user_progress = $progress_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Progress</title>
</head>
<body>
    <div class="container">
        <h1>Your Progress</h1>
        <p>Coins: <?php echo $user_progress['coins']; ?></p>
        <p>Levels Completed: <?php echo $user_progress['levels_completed']; ?></p>
    </div>
</body>
</html>
