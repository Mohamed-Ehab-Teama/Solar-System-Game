<?php
// level.php

require_once ('../connection.php');



// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level_id = $_GET['level_id'];

// Fetch level details
$level_stmt = $connection->prepare("SELECT * FROM levels WHERE id = :level_id");
$level_stmt->execute(['level_id' => $level_id]);
$level = $level_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user's session progress
$sessions_stmt = $connection->prepare("
    SELECT * 
    FROM sessions 
    WHERE level_id = :level_id 
    ORDER BY session_number
");
$sessions_stmt->execute([
    'level_id' => $level_id,
]);
$sessions = $sessions_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $level['level_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><?php echo $level['level_name']; ?></h1>
        <p><?php echo $level['description']; ?></p>

        <div class="row">
            <?php foreach ($sessions as $session) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Session <?php echo $session['session_number']; ?></h5>
                            <p class="card-text"><?php echo $session['content']; ?></p>
                            <?php if ($session['is_completed']) { ?>
                                <button class="btn btn-success">Completed</button>
                            <?php } else { ?>
                                <a href="session.php?level_id=<?php echo $level_id; ?>&session_number=<?php echo $session['session_number']; ?>" class="btn btn-primary">Start Session</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
