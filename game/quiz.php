<?php


require_once '..connection.php';



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level_id = $_GET['level_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process quiz results
    $score = $_POST['score']; // Calculate score from form data
    $coin_award = $score > 70 ? 50 : 20; // Award based on score

    // Insert quiz result
    $quiz_query = "INSERT INTO quizzes (user_id, level, score, coins_awarded) VALUES (:user_id, :level_id, :score, :coins_awarded)";
    $quiz_stmt = $connection->prepare($quiz_query);
    $quiz_stmt->execute([
        'user_id' => $user_id,
        'level_id' => $level_id,
        'score' => $score,
        'coins_awarded' => $coin_award
    ]);

    // Update user coins
    $coin_query = "UPDATE users SET coins = coins + :coin_award WHERE id = :user_id";
    $coin_stmt = $connection->prepare($coin_query);
    $coin_stmt->execute(['coin_award' => $coin_award, 'user_id' => $user_id]);

    // Mark level as completed
    $complete_level_query = "UPDATE users SET levels_completed = levels_completed + 1 WHERE id = :user_id";
    $complete_level_stmt = $connection->prepare($complete_level_query);
    $complete_level_stmt->execute(['user_id' => $user_id]);

    header("Location: progress.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz for Level <?php echo $level_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Quiz for Level <?php echo $level_id; ?></h1>
        <form method="POST">
            <!-- Quiz questions go here -->
            <input type="hidden" name="score" value="85"> <!-- Example score -->
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
