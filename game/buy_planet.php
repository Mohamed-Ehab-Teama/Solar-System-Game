<?php
require_once('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id'];
$planet_id = $_POST['planet_id'];

// Get planet cost
$planet_query = "SELECT cost FROM planets WHERE id = :planet_id";
$planet_stmt = $connection->prepare($planet_query);
$planet_stmt->bindParam(':planet_id', $planet_id);
$planet_stmt->execute();
$planet = $planet_stmt->fetch(PDO::FETCH_ASSOC);

if (!$planet) {
    die("Planet not found.");
}

// Check if user has enough coins
$user_query = "SELECT coins FROM users WHERE id = :user_id";
$user_stmt = $connection->prepare($user_query);
$user_stmt->bindParam(':user_id', $user_id);
$user_stmt->execute();
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if ($user['coins'] < $planet['cost']) {
    die("You don't have enough coins to buy this planet.");
}

// Deduct coins and assign planet
$connection->beginTransaction();
try {
    // Deduct coins
    $deduct_coins_query = "UPDATE users SET coins = coins - :cost WHERE id = :user_id";
    $deduct_coins_stmt = $connection->prepare($deduct_coins_query);
    $deduct_coins_stmt->bindParam(':cost', $planet['cost']);
    $deduct_coins_stmt->bindParam(':user_id', $user_id);
    $deduct_coins_stmt->execute();

    // Add planet to user_planets
    $assign_planet_query = "INSERT INTO user_planets (user_id, planet_id) VALUES (:user_id, :planet_id)";
    $assign_planet_stmt = $connection->prepare($assign_planet_query);
    $assign_planet_stmt->bindParam(':user_id', $user_id);
    $assign_planet_stmt->bindParam(':planet_id', $planet_id);
    $assign_planet_stmt->execute();

    // Update the user's current planet if you want to switch automatically
    $update_user_planet_query = "UPDATE users SET planet = :planet_id WHERE id = :user_id";
    $update_user_planet_stmt = $connection->prepare($update_user_planet_query);
    $update_user_planet_stmt->bindParam(':planet_id', $planet_id);
    $update_user_planet_stmt->bindParam(':user_id', $user_id);
    $update_user_planet_stmt->execute();

    // Commit transaction
    $connection->commit();
    echo "Planet purchased successfully!";
} catch (Exception $e) {
    $connection->rollBack();
    die("Error purchasing planet: " . $e->getMessage());
}
?>