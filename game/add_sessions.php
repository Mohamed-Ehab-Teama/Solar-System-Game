<?php
require_once '../connection.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level_id = $_POST['level_id'];
    $session_number = $_POST['session_number'];
    $content = $_POST['content'];

    // Insert session into the database
    $query = "INSERT INTO sessions (level_id, session_number, content) VALUES (:level_id, :session_number, :content)";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        'level_id' => $level_id,
        'session_number' => $session_number,
        'content' => $content
    ]);

    echo "<div class='alert alert-success'>Session added successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Session</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Add New Session</h1>
        <form method="POST">
            <div class="form-group">
                <label for="level_id">Select Level:</label>
                <select class="form-control" name="level_id" required>
                    <?php
                    // Fetch levels from the database to populate the dropdown
                    $levels_query = "SELECT * FROM levels";
                    $levels_stmt = $connection->prepare($levels_query);
                    $levels_stmt->execute();
                    $levels = $levels_stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($levels as $level) {
                        echo "<option value='{$level['id']}'>{$level['level_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="session_number">Session Number:</label>
                <input type="number" class="form-control" name="session_number" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" name="content" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Session</button>
        </form>
        <a href="game.php" class="btn btn-secondary btn-block mt-3">Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
