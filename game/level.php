<?php
// level.php

require_once('../connection.php');



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




<!-- Check if all sessions are completed -->
<?php
// Get total sessions in this level
$total_sessions_stmt = $connection->prepare("SELECT total_sessions FROM levels WHERE id = :level_id");
$total_sessions_stmt->execute(['level_id' => $level_id]);
$total_sessions = $total_sessions_stmt->fetchColumn();

// Get the number of sessions the user has completed for this level
$completed_sessions_stmt = $connection->prepare("
SELECT COUNT(*) FROM sessions
WHERE level_id = :level_id AND is_completed = 1
");
$completed_sessions_stmt->execute(['level_id' => $level_id]);
$completed_sessions = $completed_sessions_stmt->fetchColumn();

// Check if all sessions are completed
$all_sessions_completed = ($completed_sessions == $total_sessions ? true : false);
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


        
        <!-- Show the button to access the quiz only if all sessions are completed -->
        <?php if ($all_sessions_completed): ?>
            <form action="quiz.php" method="get">
                <input type="hidden" name="level_id" value="<?php echo $level_id; ?>">
                <button type="submit">Go to Quiz</button>
            </form>
        <?php else: ?>
            <p>You must complete all sessions to access the quiz.</p>
        <?php endif; ?>


    </div>
</body>

</html>