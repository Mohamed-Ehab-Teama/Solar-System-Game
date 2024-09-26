<?php
// quiz.php

require_once ('../connection.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level_id = $_GET['level_id'];

// Fetch quiz score from POST request or calculate based on quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assume that the POST contains the user's score for the quiz
    $score = $_POST['score']; // This should be calculated based on quiz answers

    // Award coins based on the score
    if ($score >= 70) {
        // Award coins (custom logic for coin amount)
        $coins_awarded = round($score / 10); // Example: 70% = 7 coins
        $add_coins_stmt = $connection->prepare("UPDATE users SET coins = coins + :coins WHERE id = :user_id");
        $add_coins_stmt->execute(['coins' => $coins_awarded, 'user_id' => $user_id]);

        // Record quiz result
        $insert_quiz_stmt = $connection->prepare("
            INSERT INTO quizzes (user_id, level, score, coins_awarded) 
            VALUES (:user_id, :level, :score, :coins_awarded)
        ");
        $insert_quiz_stmt->execute([
            'user_id' => $user_id, 
            'level' => $level_id, 
            'score' => $score, 
            'coins_awarded' => $coins_awarded
        ]);

        // Update levels_completed only if the user passes the quiz
        if ($score >= 70) {
            // Check if the user already completed this level
            $update_user_stmt = $connection->prepare("
                UPDATE users 
                SET levels_completed = :level_id 
                WHERE id = :user_id AND levels_completed < :level_id
            ");
            $update_user_stmt->execute(['user_id' => $user_id, 'level_id' => $level_id]);
        }

        $_SESSION['congrats'] = "Congratulation, You passed the Quiz$level_id Successfully";

        // Redirect to the next level or success page
        header("Location: game.php");
        exit;
    } else {
        // Quiz failed; show failure message
        echo "You did not pass the quiz. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz for Level <?php echo $level_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <h1>Quiz for Level <?php echo $level_id; ?></h1>

    <!-- Quiz form (replace with actual quiz content) -->
    <form method="POST" action="quiz.php?level_id=<?php echo $level_id; ?>">
        <!-- Example Quiz -->
        <label for="score">Enter Quiz Score (for testing): </label>
        <input type="number" id="score" name="score" min="0" max="100" required>

        <button type="submit">Submit Quiz</button>
    </form>
</body>
</html>
