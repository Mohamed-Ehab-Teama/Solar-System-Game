<?php

require_once ('../connection.php');


if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

// Fetch quizzes
$query = "SELECT quizzes.*, levels.level_name FROM quizzes JOIN levels ON quizzes.level_id = levels.id";
$stmt = $connection->prepare($query);
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Quizzes</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Level Name</th>
                <th>Quiz Name</th>
                <th>Total Questions</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizzes as $quiz): ?>
                <tr>
                    <td><?= $quiz['id']; ?></td>
                    <td><?= $quiz['level_name']; ?></td>
                    <td><?= $quiz['quiz_name']; ?></td>
                    <td><?= $quiz['total_questions']; ?></td>
                    <td><?= $quiz['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
