<?php


require_once('../connection.php');



if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$query = "SELECT username, avatar, planet, levels_completed, sessions_completed_today, coins FROM users WHERE id = :user_id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Progress</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-header {
            text-align: center;
            margin-top: 20px;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        .stats {
            margin-top: 30px;
        }
        .stats div {
            margin-bottom: 20px;
        }
        .customization-section {
            margin-top: 40px;
        }
        .customization-options img {
            width: 100px;
            height: 100px;
            cursor: pointer;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="avatars/<?= htmlspecialchars($user['avatar']); ?>" alt="User Avatar">
            <h2><?= htmlspecialchars($user['username']); ?></h2>
            <p>Planet: <?= htmlspecialchars($user['planet']); ?></p>
            <p>Coins: <?= htmlspecialchars($user['coins']); ?></p>
        </div>

        <div class="stats row">
            <div class="col-md-4">
                <h4>Sessions Completed Today</h4>
                <p><?= htmlspecialchars($user['sessions_completed_today']); ?></p>
            </div>
            <div class="col-md-4">
                <h4>Levels Completed</h4>
                <p><?= htmlspecialchars($user['levels_completed']); ?></p>
            </div>
            <div class="col-md-4">
                <h4>Total Coins</h4>
                <p><?= htmlspecialchars($user['coins']); ?></p>
            </div>
        </div>

        <div class="customization-section">
            <h3>Customize Your Avatar and Planet</h3>
            <p>Use your coins to buy new avatars or planets!</p>

            <div class="customization-options">
                <h4>Avatars</h4>
                <div class="row">
                    <div class="col-md-2">
                        <img src="avatars/avatar1.png" alt="Avatar 1" onclick="customizeAvatar('avatar1.png', <?= $user['coins']; ?>)">
                    </div>
                    <div class="col-md-2">
                        <img src="avatars/avatar2.png" alt="Avatar 2" onclick="customizeAvatar('avatar2.png', <?= $user['coins']; ?>)">
                    </div>
                    <!-- Add more avatar options here -->
                </div>

                <h4>Planets</h4>
                <div class="row">
                    <div class="col-md-2">
                        <img src="planets/planet1.png" alt="Planet 1" onclick="customizePlanet('planet1.png', <?= $user['coins']; ?>)">
                    </div>
                    <div class="col-md-2">
                        <img src="planets/planet2.png" alt="Planet 2" onclick="customizePlanet('planet2.png', <?= $user['coins']; ?>)">
                    </div>
                    <!-- Add more planet options here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function customizeAvatar(avatar, coins) {
            if (coins >= 50) { // Assuming each avatar costs 50 coins
                alert("Avatar changed to: " + avatar);
                // You can make an AJAX call here to update the user's avatar in the database
            } else {
                alert("Not enough coins to change avatar!");
            }
        }

        function customizePlanet(planet, coins) {
            if (coins >= 100) { // Assuming each planet costs 100 coins
                alert("Planet changed to: " + planet);
                // You can make an AJAX call here to update the user's planet in the database
            } else {
                alert("Not enough coins to change planet!");
            }
        }
    </script>
</body>
</html>
