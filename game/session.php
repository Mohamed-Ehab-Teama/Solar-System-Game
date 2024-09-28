

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Session Details</h1>
        <?php
        require_once '../connection.php'; // Database connection
        $session_id = $_GET['id'];
        $query = "SELECT * FROM sessions WHERE id = :session_id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['session_id' => $session_id]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h2>{$session['content']}</h2>";
        // Add your session content and logic here
        ?>

        <form method="POST" action="complete_session.php">
            <input type="hidden" name="session_id" value="<?php echo $session['id']; ?>">
            <button type="submit" class="btn btn-success">Complete Session</button>
        </form>
        <a href="level.php?id=<?php echo $session['level_id']; ?>" class="btn btn-secondary btn-block mt-3">Back to Level</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
