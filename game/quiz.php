<?php
require_once('../connection.php');


if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

// Get the quiz ID from the URL
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    die("Quiz not found.");
}

// Fetch quiz details
$quiz_query = "SELECT * FROM quizzes WHERE id = :quiz_id";
$quiz_stmt = $connection->prepare($quiz_query);
$quiz_stmt->bindParam(':quiz_id', $quiz_id);
$quiz_stmt->execute();
$quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    die("Quiz not found.");
}

// Fetch quiz questions
$questions_query = "SELECT * FROM quiz_questions WHERE quiz_id = :quiz_id";
$questions_stmt = $connection->prepare($questions_query);
$questions_stmt->bindParam(':quiz_id', $quiz_id);
$questions_stmt->execute();
$questions = $questions_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correct_answers = 0;
    $total_questions = count($questions);


    foreach ($questions as $question) {
        $user_answer = $_POST['question_' . $question['id']] ?? null;

        if ($user_answer == $question['correct_answer']) {
            $correct_answers++;
        }
    }

    $score = ($correct_answers / $total_questions) * 100;

    if ($score >= 70) {
        // Award coins for passing the quiz
        $coins_awarded = 50; // Adjust coins as necessary
        $user_id = $_SESSION['user_id'];
        $coins_query = "UPDATE users SET coins = coins + :coins_awarded WHERE id = :user_id";
        $coins_stmt = $connection->prepare($coins_query);
        $coins_stmt->execute([
            'coins_awarded' => $coins_awarded,
            'user_id' => $user_id,
        ]);

        echo "Congratulations! You passed the quiz with a score of $score%. You earned $coins_awarded coins.";
    } else {
        echo "You failed the quiz with a score of $score%. Try again!";
    }
    exit; // Exit after processing the form
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz['quiz_name']); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($quiz['quiz_name']); ?></h1>
        <form method="POST">
            <?php foreach ($questions as $question): ?>
                <div class="form-group">
                    <label><?= htmlspecialchars($question['question_text']); ?></label><br>
                    <div>
                        <input type="radio" name="question_<?= $question['id']; ?>" value=<?php echo htmlspecialchars($question['option_a']); ?> <?= htmlspecialchars($question['option_a']); ?><br>
                        <input type="radio" name="question_<?= $question['id']; ?>" value=<?php echo htmlspecialchars($question['option_b']); ?> <?= htmlspecialchars($question['option_b']); ?><br>
                        <input type="radio" name="question_<?= $question['id']; ?>" value=<?php echo htmlspecialchars($question['option_c']) ?> <?= htmlspecialchars($question['option_c']); ?><br>
                        <input type="radio" name="question_<?= $question['id']; ?>" value=<?php echo htmlspecialchars($question['option_d']) ?> <?= htmlspecialchars($question['option_d']); ?><br>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
