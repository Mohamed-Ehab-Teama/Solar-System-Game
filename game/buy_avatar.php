<?php

require_once('../connection.php');


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id'];
$avatar_id = $_POST['avatar_id'];

// Get avatar cost
$avatar_query = "SELECT cost FROM avatars WHERE id = :avatar_id";
$avatar_stmt = $connection->prepare($avatar_query);
$avatar_stmt->bindParam(':avatar_id', $avatar_id);
$avatar_stmt->execute();
$avatar = $avatar_stmt->fetch(PDO::FETCH_ASSOC);

if (!$avatar) {
    die("Avatar not found.");
}

// Check if user has enough coins
$user_query = "SELECT coins FROM users WHERE id = :user_id";
$user_stmt = $connection->prepare($user_query);
$user_stmt->bindParam(':user_id', $user_id);
$user_stmt->execute();
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if ($user['coins'] < $avatar['cost']) {
    die("You don't have enough coins to buy this avatar.");
}

// Deduct coins and assign avatar
$connection->beginTransaction();
try {
    // Deduct coins
    $deduct_coins_query = "UPDATE users SET coins = coins - :cost WHERE id = :user_id";
    $deduct_coins_stmt = $connection->prepare($deduct_coins_query);
    $deduct_coins_stmt->bindParam(':cost', $avatar['cost']);
    $deduct_coins_stmt->bindParam(':user_id', $user_id);
    $deduct_coins_stmt->execute();

    // Add avatar to user_avatars
    $assign_avatar_query = "INSERT INTO user_avatars (user_id, avatar_id) VALUES (:user_id, :avatar_id)";
    $assign_avatar_stmt = $connection->prepare($assign_avatar_query);
    $assign_avatar_stmt->bindParam(':user_id', $user_id);
    $assign_avatar_stmt->bindParam(':avatar_id', $avatar_id);
    $assign_avatar_stmt->execute();

    $connection->commit();
    echo "Avatar purchased successfully!";
} catch (Exception $e) {
    $connection->rollBack();
    die("Error purchasing avatar.");
}
