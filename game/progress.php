<?php


require_once ('../connection.php');



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user progress
$progress_query = "SELECT levels_completed, coins FROM users WHERE id = :user_id";
$progress_stmt = $connection->prepare($progress_query);
$progress_stmt->execute(['user_id' => $user_id]);
$progress = $progress_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Progress</h1>
        <p>Levels Completed: <?php echo $progress['levels_completed']; ?></p>
        <p>Coins: <?php echo $progress['coins']; ?></p>

        <a href="index.php" class="btn btn-primary">Go Back to Levels</a>
    </div>
</body>
</html>
