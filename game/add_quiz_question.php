<?php

require_once '../connection.php'; 



if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

// Fetch quizzes to populate the dropdown
$query = "SELECT * FROM quizzes";
$stmt = $connection->prepare($query);
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $question_text = $_POST['question_text'];
    $correct_answer = $_POST['correct_answer'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];

    // Insert the question into the database
    $insert_question = "INSERT INTO quiz_questions (quiz_id, question_text, correct_answer, option_a, option_b, option_c, option_d) VALUES (:quiz_id, :question_text, :correct_answer, :option_a, :option_b, :option_c, :option_d)";
    $stmt = $connection->prepare($insert_question);
    $stmt->execute([
        'quiz_id' => $quiz_id,
        'question_text' => $question_text,
        'correct_answer' => $correct_answer,
        'option_a' => $option_a,
        'option_b' => $option_b,
        'option_c' => $option_c,
        'option_d' => $option_d,
    ]);

    echo "Question added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz Question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Add Quiz Question</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="quiz_id">Select Quiz:</label>
            <select class="form-control" id="quiz_id" name="quiz_id" required>
                <?php foreach ($quizzes as $quiz): ?>
                    <option value="<?= $quiz['id']; ?>"><?= $quiz['quiz_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="question_text">Question Text:</label>
            <textarea class="form-control" id="question_text" name="question_text" required></textarea>
        </div>
        <div class="form-group">
            <label for="correct_answer">Correct Answer:</label>
            <input type="text" class="form-control" id="correct_answer" name="correct_answer" required>
        </div>
        <div class="form-group">
            <label for="option_a">Option A:</label>
            <input type="text" class="form-control" id="option_a" name="option_a">
        </div>
        <div class="form-group">
            <label for="option_b">Option B:</label>
            <input type="text" class="form-control" id="option_b" name="option_b">
        </div>
        <div class="form-group">
            <label for="option_c">Option C:</label>
            <input type="text" class="form-control" id="option_c" name="option_c">
        </div>
        <div class="form-group">
            <label for="option_d">Option D:</label>
            <input type="text" class="form-control" id="option_d" name="option_d">
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>
</div>
</body>
</html>
