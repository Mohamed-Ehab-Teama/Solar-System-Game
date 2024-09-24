<?php
// Include database connection
require_once('../connection.php');

// Fetch levels from the database
$levels = $connection->query("SELECT * FROM levels")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Exploration Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Explore Space</h1>
    <p class="text-center">Choose a level to start your space adventure!</p>

    <div class="row">
        <?php foreach ($levels as $level): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $level['level_name']; ?></h5>
                        <p class="card-text"><?= $level['description']; ?></p>
                        <a href="level.php?level=<?= $level['id']; ?>" class="btn btn-primary">Start Level <?= $level['level_number']; ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
