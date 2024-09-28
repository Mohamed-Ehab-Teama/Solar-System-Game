<?php

require_once '../connection.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level_number = $_POST['level_number'];
    $level_name = $_POST['level_name'];
    $description = $_POST['description'];
    $total_sessions = $_POST['total_sessions'];

    // Insert level into the database
    $query = "INSERT INTO levels (level_number, level_name, description, total_sessions) VALUES (:level_number, :level_name, :description, :total_sessions)";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        'level_number' => $level_number,
        'level_name' => $level_name,
        'description' => $description,
        'total_sessions' => $total_sessions
    ]);

    echo "<div class='alert alert-success'>Level added successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Level</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Add New Level</h1>
        <form method="POST">
            <div class="form-group">
                <label for="level_number">Level Number:</label>
                <input type="number" class="form-control" name="level_number" required>
            </div>

            <div class="form-group">
                <label for="level_name">Level Name:</label>
                <input type="text" class="form-control" name="level_name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="total_sessions">Total Sessions:</label>
                <input type="number" class="form-control" name="total_sessions" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Level</button>
        </form>
        <a href="game.php" class="btn btn-secondary btn-block mt-3">Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

