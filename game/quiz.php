<?php
// quiz.php

require_once ('../connection.php');



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level_id = $_GET['level_id'];

// Check if user completed all sessions in this level
$completion_check_stmt = $connection->prepare("
    SELECT COUNT(*) as total_sessions, SUM(is_completed) as completed_sessions 
    FROM sessions 
    WHERE level = :level_id AND user_id = :user_id
");
$completion_check_stmt->execute([
    'level_id' => $level_id,
    'user_id' => $user_id
]);
$completion_status = $completion_check_stmt->fetch(PDO::FETCH_ASSOC);

if ($completion_status['total_sessions'] != $completion_status['completed_sessions']) {
    echo "You must complete all sessions before taking the quiz.";
    exit;
}

// Implement quiz logic and store results in database
// For simplicity, assume quiz submission is done here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = rand(50, 100); // Example score generation

    // Store quiz result
    $quiz_stmt = $connection->prepare("
        INSERT INTO quizzes (user_id, level, score, coins_awarded) 
        VALUES (:user_id, :level, :score, :coins_awarded)
    ");
    $quiz_stmt->execute([
        'user_id' => $user_id,
        'level' => $level_id,
        'score' => $score,
        'coins_awarded' => ($score >= 70 ? 50 : 0)
    ]);

    header("Location: progress.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz for Level <?php echo $level_id; ?></title>
</head>
<body>
    <div class="container">
        <h1>Quiz for Level <?php echo $level_id; ?></h1>
        <p>Test your knowledge!</p>

        <form method="post">
            <button type="submit" class="btn btn-primary">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
