<?php
// index.php

require_once ('../connection.php');


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all levels
$levels_stmt = $connection->prepare("SELECT * FROM levels");
$levels_stmt->execute();
$levels = $levels_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Exploration Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php if (isset($_SESSION['congrats'])): ?>
        <div class="alert alert-success text-center">
            <?php echo $_SESSION['congrats'] ?>
            <?php unset($_SESSION['congrats']) ?>
        </div>
    <?php endif; ?>
    <div class="container">
        <h1>Welcome to the Space Exploration Game!</h1>
        <p>Select a level to start your journey.</p>

        <div class="row">
            <?php foreach ($levels as $level) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $level['level_name']; ?></h5>
                            <p class="card-text"><?php echo $level['description']; ?></p>
                            <a href="level.php?level_id=<?php echo $level['id']; ?>" class="btn btn-primary">Start Level</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
