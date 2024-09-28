<?php

require_once '../connection.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $session_id = $_POST['session_id'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // Update session to completed
    $update_session_query = "UPDATE sessions SET is_completed = TRUE WHERE id = :session_id";
    $stmt = $connection->prepare($update_session_query);
    $stmt->execute(['session_id' => $session_id]);

    // Get the number of coins awarded for completing a session (you can adjust the amount)
    $coins_awarded = 10; // For example, award 10 coins for each completed session

    // Update the user's coins
    $update_coins_query = "UPDATE users SET coins = coins + :coins_awarded WHERE id = :user_id";
    $stmt = $connection->prepare($update_coins_query);
    $stmt->execute(['coins_awarded' => $coins_awarded, 'user_id' => $user_id]);

    // Redirect to level page or to a success page
    header("Location: level.php?id={$_POST['level_id']}");
    exit;
} else {
    // If the request method is not POST, redirect to home or show an error
    header("Location: game.php");
    exit;
}
?>
