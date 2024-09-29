<?php

require_once '../connection.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $session_id = $_POST['session_id'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // Get user's last activity date
    $user_query = "SELECT last_activity, current_streak, longest_streak FROM users WHERE id = :user_id";
    $stmt = $connection->prepare($user_query);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $last_activity = $user['last_activity'] ? new DateTime($user['last_activity']) : null;
    $today = new DateTime(); // Get current date
    $yesterday = (clone $today)->modify('-1 day'); // Get yesterday's date

    // Update streak logic
    if ($last_activity && $last_activity == $yesterday) {
        // Increment streak if last activity was yesterday
        $current_streak = $user['current_streak'] + 1;
    } elseif ($last_activity && $last_activity < $yesterday) {
        // Reset streak if last activity was before yesterday
        $current_streak = 1;
    } else {
        // Start new streak
        $current_streak = 1;
    }

    // Update longest streak if needed
    $longest_streak = max($user['longest_streak'], $current_streak);

    // Update session to completed
    $update_session_query = "UPDATE sessions SET is_completed = TRUE WHERE id = :session_id";
    $stmt = $connection->prepare($update_session_query);
    $stmt->execute(['session_id' => $session_id]);

    // Update the user's streak, longest streak, last activity date, and coins
    $update_user_query = "UPDATE users SET current_streak = :current_streak, longest_streak = :longest_streak, last_activity = :today, coins = coins + :coins_awarded WHERE id = :user_id";
    $stmt = $connection->prepare($update_user_query);
    $stmt->execute([
        'current_streak' => $current_streak,
        'longest_streak' => $longest_streak,
        'today' => $today->format('Y-m-d'),
        'coins_awarded' => 10, // Award 10 coins for example
        'user_id' => $user_id
    ]);

    // Redirect to the level page
    header("Location: level.php?id={$_POST['level_id']}");
    exit;
} else {
    // If the request method is not POST, redirect to home or show an error
    header("Location: game.php");
    exit;
}
?>
