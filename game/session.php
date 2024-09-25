<?php
// session.php

require_once ('../connection.php');



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level_id = $_GET['level_id'];
$session_number = $_GET['session_number'];

// Fetch session details
$session_stmt = $connection->prepare("
    SELECT * 
    FROM sessions 
    WHERE level_id = :level_id AND session_number = :session_number AND user_id = :user_id
");
$session_stmt->execute([
    'level_id' => $level_id,
    'session_number' => $session_number,
    'user_id' => $user_id
]);
$session = $session_stmt->fetch(PDO::FETCH_ASSOC);

// Mark session as completed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update_stmt = $connection->prepare("
        UPDATE sessions 
        SET is_completed = 1 
        WHERE id = :session_id
    ");
    $update_stmt->execute(['session_id' => $session['id']]);

    // Award coins to the user
    $coins_stmt = $connection->prepare("UPDATE users SET coins = coins + 10 WHERE id = :user_id");
    $coins_stmt->execute(['user_id' => $user_id]);

    header("Location: level.php?level_id=$level_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session <?php echo $session['session_number']; ?></title>
</head>
<body>
    <div class="container">
        <h1>Session <?php echo $session['session_number']; ?></h1>
        <p><?php echo $session['content']; ?></p>

        <form method="post">
            <button type="submit" class="btn btn-primary">Complete Session</button>
        </form>
    </div>
</body>
</html>
