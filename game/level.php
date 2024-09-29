<?php require_once '../connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


    <!-- In case of Success -->
    <?php if (isset($_SESSION['success'])): ?>

        <div class="alert alert-success text-center bg-transparent">
            <?php echo $_SESSION['success']; ?>
        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>
    <!-- end of success display -->
    </div>


    <div class="container mt-5">
        <h1 class="text-center">Level Details</h1>
        <?php
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
                <a href='session.php?level_id={$level_id}&session_id={$session['id']}' class='list-group-item list-group-item-action'>
                    Session {$session['session_number']}:
                </a>
                ";
            }
            ?>
        </div>

        <?php
        // Check if user has completed all sessions of a level
        $level_id = $_GET['id']; // Assuming level_id is passed in the query
        $query = "SELECT COUNT(*) as total_sessions FROM sessions WHERE level_id = :level_id AND is_completed = 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':level_id', $level_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_sessions_completed = $result['total_sessions'];

        $quiz_query = "SELECT * FROM quizzes WHERE level_id = :level_id";
        $quiz_stmt = $connection->prepare($quiz_query);
        $quiz_stmt->bindParam(':level_id', $level['id']);
        $quiz_stmt->execute();
        $quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);


        if ($quiz): ?>
            <?php
            if ($total_sessions_completed == 12) : ?>
                <a href="quiz.php?quiz_id=<?= htmlspecialchars($quiz['id']); ?>" class="btn btn-success">Take Quiz</a>
            <?php endif; ?>
        <?php else: ?>
            <p>No quiz available for this level.</p>
        <?php endif; ?>

        <a href="game.php" class="btn btn-secondary btn-block mt-3">Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>