<?php
// Include database connection
require_once('../connection.php');



// Get the level ID from the URL
$level_id = $_GET['level'];

// Fetch level details
$level = $connection->prepare("SELECT * FROM levels WHERE id = :id");
$level->execute(['id' => $level_id]);
$level = $level->fetch();

// Fetch sessions for the selected level
$sessions = $connection->prepare("SELECT * FROM sessions WHERE level = :level_id");
$sessions->execute(['level_id' => $level_id]);
$sessions = $sessions->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level <?= $level['level_number']; ?>: <?= $level['level_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Level <?= $level['level_number']; ?>: <?= $level['level_name']; ?></h1>
    <p class="text-center"><?= $level['description']; ?></p>

    <div class="row">
        <?php foreach ($sessions as $session): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Session <?= $session['session_number']; ?></h5>
                        <a href="session.php?session=<?= $session['id']; ?>" class="btn btn-success">
                            <?php if ($session['is_completed']): ?>
                                Completed
                            <?php else: ?>
                                Start Session
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
