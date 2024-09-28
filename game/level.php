
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Level Details</h1>
        <?php
        require_once '../connection.php'; // Database connection
        $level_id = $_GET['id'];
        $query = "SELECT * FROM levels WHERE id = :level_id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['level_id' => $level_id]);
        $level = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h2>{$level['level_name']}</h2>";
        echo "<p>{$level['description']}</p>";
        ?>

        <h3>Sessions</h3>
        <div class="list-group">
            <?php
            $sessions_query = "SELECT * FROM sessions WHERE level_id = :level_id";
            $sessions_stmt = $connection->prepare($sessions_query);
            $sessions_stmt->execute(['level_id' => $level_id]);
            $sessions = $sessions_stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($sessions as $session) {
                echo "
                <a href='session.php?id={$session['id']}' class='list-group-item list-group-item-action'>
                    Session {$session['session_number']}: {$session['content']}
                </a>
                ";
            }
            ?>
        </div>
        <a href="game.php" class="btn btn-secondary btn-block mt-3">Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
