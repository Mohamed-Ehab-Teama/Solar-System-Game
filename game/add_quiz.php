<?php

require_once '../connection.php'; 



if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

// Fetch levels to populate the dropdown
$query = "SELECT * FROM levels";
$stmt = $connection->prepare($query);
$stmt->execute();
$levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level_id = $_POST['level_id'];
    $quiz_name = $_POST['quiz_name'];
    $total_questions = $_POST['total_questions'];

    // Insert the quiz into the database
    $insert_quiz = "INSERT INTO quizzes (level_id, quiz_name, total_questions) VALUES (:level_id, :quiz_name, :total_questions)";
    $stmt = $connection->prepare($insert_quiz);
    $stmt->execute([
        'level_id' => $level_id,
        'quiz_name' => $quiz_name,
        'total_questions' => $total_questions,
    ]);

    echo "Quiz added successfully!";
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Add Quiz</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="level_id">Select Level:</label>
            <select class="form-control" id="level_id" name="level_id" required>
                <?php foreach ($levels as $level): ?>
                    <option value="<?= $level['id']; ?>"><?= $level['level_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="quiz_name">Quiz Name:</label>
            <input type="text" class="form-control" id="quiz_name" name="quiz_name" required>
        </div>
        <div class="form-group">
            <label for="total_questions">Total Questions:</label>
            <input type="number" class="form-control" id="total_questions" name="total_questions" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Quiz</button>
    </form>
</div>
</body>
</html>
