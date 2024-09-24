<?php
// Include database connection
require_once('../connection.php');



// Get the session ID from the URL
$session_id = $_GET['session'];

// Fetch the session data, including content
$session = $connection->prepare("SELECT * FROM sessions WHERE id = :id");
$session->execute(['id' => $session_id]);
$session = $session->fetch();

if (!$session) {
    echo "Session not found.";
    exit();
}

// Update session completion when the user finishes it
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connection->prepare("UPDATE sessions SET is_completed = 1 WHERE id = :id");
    $stmt->execute(['id' => $session_id]);
    header('Location: level.php?level=' . $session['level']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session <?= $session['session_number']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Session <?= $session['session_number']; ?></h1>
    <p class="text-center">Learn about space in this session!</p>

    <!-- Display the session content -->
    <div class="session-content">
        <p><?= $session['content']; ?></p>
    </div>

    <form method="POST">
        <button type="submit" class="btn btn-primary">Complete Session</button>
    </form>
</div>

</body>
</html>
