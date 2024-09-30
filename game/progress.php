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

// Function to check if user owns an avatar or planet
function userOwns($table, $user_id, $item_id, $connection)
{
    $query = "SELECT * FROM $table WHERE user_id = :user_id AND id = :item_id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to handle purchase
function handlePurchase($table, $item_id, $user_id, $cost, $column, $connection, $item_name)
{
    global $user;

    if ($user['coins'] >= $cost) {
        // Deduct coins
        $update_coins = "UPDATE users SET coins = coins - :cost WHERE id = :user_id";
        $stmt = $connection->prepare($update_coins);
        $stmt->bindParam(':cost', $cost);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Add item to user's inventory
        $insert_item = "INSERT INTO user_{$table} (user_id, id) VALUES (:user_id, :item_id)";
        $stmt = $connection->prepare($insert_item);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();

        // Update user's current avatar/planet
        $update_user = "UPDATE users SET $column = :item WHERE id = :user_id";
        $stmt = $connection->prepare($update_user);
        $stmt->bindParam(':item', $item_name);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return "You have successfully purchased and equipped a new $column!";
    } else {
        return "You do not have enough coins.";
    }
}

// Handle avatar purchase request
if (isset($_POST['avatar_id'])) {
    $avatar_id = $_POST['avatar_id'];

    // Check if the avatar exists and fetch its cost
    $avatar_query = "SELECT * FROM avatars WHERE id = :avatar_id";
    $stmt = $connection->prepare($avatar_query);
    $stmt->bindParam(':avatar_id', $avatar_id);
    $stmt->execute();
    $avatar = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($avatar) {
        // Check if user already owns the avatar
        if (!userOwns('user_avatars', $user_id, $avatar_id, $connection)) {
            echo handlePurchase('avatars', $avatar_id, $user_id, $avatar['cost'], 'avatar', $connection, $avatar['avatar_name']);
        } else {
            // Equip the avatar
            $update_user_avatar = "UPDATE users SET avatar = :avatar WHERE id = :user_id";
            $stmt = $connection->prepare($update_user_avatar);
            $stmt->bindParam(':avatar', $avatar['avatar_image']); // Update with avatar name
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            // echo "Avatar equipped successfully!";
            header('location:progress.php');
            exit;
        }
    } else {
        echo "Avatar not found.";
    }
}

// Handle planet purchase request
if (isset($_POST['planet_id'])) {
    $planet_id = $_POST['planet_id'];

    // Check if the planet exists and fetch its cost
    $planet_query = "SELECT * FROM planets WHERE id = :planet_id";
    $stmt = $connection->prepare($planet_query);
    $stmt->bindParam(':planet_id', $planet_id);
    $stmt->execute();
    $planet = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($planet) {
        // Check if user already owns the planet
        if (!userOwns('user_planets', $user_id, $planet_id, $connection)) {
            echo handlePurchase('planets', $planet_id, $user_id, $planet['cost'], 'planet', $connection, $planet['planet_name']);
        } else {
            // Equip the planet
            $update_user_planet = "UPDATE users SET planet = :planet WHERE id = :user_id";
            $stmt = $connection->prepare($update_user_planet);
            $stmt->bindParam(':planet', $planet['planet_image']); // Update with planet name
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            // echo "Planet equipped successfully!";
            header('location:progress.php');
            exit;
        }
    } else {
        echo "Planet not found.";
    }
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
        .profile-section {
            text-align: center;
            margin: 20px 0;
        }

        .customization-options img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .customization-options {
            margin-top: 20px;
        }

        h4 {
            display: inline-block;
        }

        body {
            background-image: url("../images/profile-bg.jpg");
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center m-5 border border-warning rounded-pill  p-2 text-warning">User Progress</h1>

        <!-- Profile Section -->
        <div class="profile-section border border-warning rounded" style="background: rgba(0, 0, 0, .6) ">
            <img src="avatars/<?= htmlspecialchars($user['avatar']); ?>" alt="Avatar"
                class="img-fluid rounded-circle m-3" width="200px">
            <h3 class="m-3 text-info">User Name : <h1 style="display: in;">
                    <span class="text-warning"> <?= htmlspecialchars($user['username']); ?>
                </h1> </span>
            </h3>
            <p class="m-3 border border-bottom border-danger">
            <h4 class="m-3 text-info">Planet:</h4> <img src="planets/<?= htmlspecialchars($user['planet']); ?>" alt="Planet"
                class="img-fluid m-3" width="200px">
            </p>
            <p class="m-3 border border-bottom border-danger">
            <h4 class="m-3 text-info">Levels Completed:</h4>
            <h5 class="text-warning"><?= htmlspecialchars($user['levels_completed']); ?> </h5>
            </p>
            <p class="m-3 border border-bottom border-danger">
            <h4 class="m-3 text-info">Sessions Completed Today:</h4>
            <h5 class="text-warning"><?= htmlspecialchars($user['sessions_completed_today']); ?> </h5>
            </p>
            <p class="m-3 border border-bottom border-danger">
            <h4 class="m-3 text-info">Coins:</h4>
            <h5 class="text-warning"> <?= htmlspecialchars($user['coins']); ?> </h5>
            </p>
        </div>

        <!-- Customization Section -->
        <div class="customization-options ">
            <h4 class="text-info text-uppercase border-top border-left border-right border-info rounded pl-5 mb-0">Avatars</h4>
            <div class="row border border-warning rounded p-4 m-4" style="background: rgba(0, 0, 0, .6) ">
                <?php
                // Fetch all avatars
                $avatar_query = "SELECT * FROM avatars";
                $stmt = $connection->query($avatar_query);
                $avatars = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($avatars as $avatar): ?>
                    <div class="col-md-2 m-2 p-2">
                        <img src="avatars/<?= htmlspecialchars($avatar['avatar_image']); ?>" alt="Avatar">
                        <p class="text-white"><?= htmlspecialchars($avatar['avatar_name']); ?> (<?= htmlspecialchars($avatar['cost']); ?>
                            coins)</p>
                        <form method="POST">
                            <input type="hidden" name="avatar_id" value="<?= htmlspecialchars($avatar['id']); ?>">
                            <button type="submit" class="btn btn-outline-danger">Buy/Equip</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <h4 class="text-info text-uppercase border-top border-left border-right border-info rounded pl-5 mb-0">Planets</h4>
            <div class="row border border-warning rounded p-4 m-4 " style="background: rgba(0, 0, 0, .6) ">
                <?php
                // Fetch all planets
                $planet_query = "SELECT * FROM planets";
                $stmt = $connection->query($planet_query);
                $planets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($planets as $planet): ?>
                    <div class="col-md-2 m-2 p-2">
                        <img src="planets/<?= htmlspecialchars($planet['planet_image']); ?>" alt="Planet">
                        <p class="text-white"><?= htmlspecialchars($planet['planet_name']); ?> (<?= htmlspecialchars($planet['cost']); ?>
                            coins)</p>
                        <form method="POST">
                            <input type="hidden" name="planet_id" value="<?= htmlspecialchars($planet['id']); ?>">
                            <button type="submit" class="btn btn-outline-danger">Buy/Equip</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <center>
        <a href="../index.php" class="btn btn-outline-warning btn-block m-3">Back To Home Page</a>
    </center>
</body>

</html>