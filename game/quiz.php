<?php
// Include database connection
require_once('../connection.php');



// Get the level ID
$level_id = $_GET['level'];

// When the user submits the quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = rand(50, 100); // Random score for now
    $coins_awarded = ($score > 70) ? 50 : 0; // Award coins if score > 70

    // Insert quiz result
    $stmt = $connection->prepare("INSERT INTO quizzes (user_id, level, score, coins_awarded) VALUES (:user_id, :level, :score, :coins_awarded)");
    $stmt->execute([
        'user_id' => 1, // Assuming user_id = 1 for now
        'level' => $level_id,
        'score' => $score,
        'coins_awarded' => $coins_awarded
    ]);

    // Update user's coin balance
    $stmt = $connection->prepare("UPDATE users SET coins = coins + :coins_awarded WHERE id = :user_id");
    $stmt->execute(['coins_awarded' => $coins_awarded, 'user_id' => 1]);

    header('Location: level.php?level=' . $level_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz for Level <?= $level_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Quiz for Level <?= $level_id; ?></h1>

    <!-- Quiz content goes here -->

    <form method="POST">
        <button type="submit" class="btn btn-primary">Submit Quiz</button>
    </form>
</div>

</body>
</html>
