<?php


require_once('../connection.php');


if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

// Get the level_id and session_id from the URL
$level_id = $_GET['level_id']; // Get the level_id from the URL
$session_id = $_GET['session_id']; // Get the specific session_id from the URL

// Fetch the specific session for the level
$query = "SELECT * FROM sessions WHERE level_id = :level_id AND id = :session_id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':level_id', $level_id);
$stmt->bindParam(':session_id', $session_id);
$stmt->execute();
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    die("Session not found.");
}

// User's ID
$user_id = $_SESSION['user_id'];

// Initialize variables for session limit
$max_sessions_per_day = 2; // Maximum sessions a user can complete in a day

// Get today's date
$today = date('Y-m-d');

// Check how many sessions have been completed today by the user
$count_query = "SELECT COUNT(*) as session_count FROM sessions 
                WHERE user_id = :user_id AND DATE(completed_at) = :today";
$count_stmt = $connection->prepare($count_query);
$count_stmt->bindParam(':user_id', $user_id);
$count_stmt->bindParam(':today', $today);
$count_stmt->execute();
$count_result = $count_stmt->fetch(PDO::FETCH_ASSOC);
$completed_today = $count_result['session_count'];

// Complete a session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the session is already completed by the user
    $check_query = "SELECT is_completed, coins_awarded FROM sessions WHERE id = :session_id AND user_id = :user_id";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->bindParam(':session_id', $session_id);
    $check_stmt->bindParam(':user_id', $user_id);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['is_completed']) {
        // Session already completed
        echo "You have already completed this session.";
    } elseif ($completed_today >= $max_sessions_per_day) {
        // User has reached the session limit for the day
        echo "You have reached the maximum of $max_sessions_per_day sessions for today.";
    } else {
        // Update session as completed
        $update_query = "UPDATE sessions SET is_completed = 1, user_id = :user_id, completed_at = NOW() WHERE id = :session_id";
        $update_stmt = $connection->prepare($update_query);
        $update_stmt->execute([
            'session_id' => $session_id,
            'user_id' => $user_id,
        ]);

        // Award coins for completing the session
        $coins_awarded = 10; // Adjust the coins to award as necessary
        $coins_query = "UPDATE users SET coins = coins + :coins_awarded WHERE id = :user_id";
        $coins_stmt = $connection->prepare($coins_query);
        $coins_stmt->execute([
            'coins_awarded' => $coins_awarded,
            'user_id' => $user_id,
        ]);

        echo "Session completed successfully! You earned $coins_awarded coins.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session for Level <?= htmlspecialchars($level_id); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -100;
        }

        /* Add some content at the bottom of the video/page */
        .content {
            position: fixed;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #f1f1f1;
            width: 100%;
            padding: 20px;
        }

        /* Style the button used to pause/play the video */
        #myBtn {
            width: 200px;
            font-size: 18px;
            padding: 10px;
            border: none;
            background: #000;
            color: #fff;
            cursor: pointer;
        }

        #myBtn:hover {
            background: #ddd;
            color: black;
        }
    </style>
</head>

<body>

    <video autoplay muted loop id="myVideo">
        <source src="../vids/background-vid.mp4" type="video/mp4">
    </video>

    <div class="container">
        <h1 class="text-center text-warning m-5">Session for Level <?= htmlspecialchars($level_id); ?></h1>
        <div class="session border border-warning rounded-pill">
            <h3 class="text-center text-warning mt-5">Session <?= htmlspecialchars($session['session_number']); ?></h3>
            <p class="text-white mt-5 p-5"><?= htmlspecialchars($session['content']); ?></p>
            <?php if ($session['is_completed']): ?>
                <p class="text-success text-center">You have completed this session.</p>
            <?php else: ?>
                <form method="POST" action="">
                    <input type="hidden" name="session_id" value="<?= htmlspecialchars($session['id']); ?>">
                    <center>
                        <button type="submit" class="btn btn-primary p-1 m-4">Complete Session</button>
                    </center>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <center>
        <a href="game.php" class="btn btn-warning m-3">Back to Home</a>
    </center>

    <script src="../js/back-vid.js"></script>
</body>

</html>