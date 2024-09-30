<?php require_once '../connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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


    <div class="container mt-5">
        <h1 class="text-center text-warning mb-5">Level Details</h1>
        <?php
        $level_id = $_GET['id'];
        $query = "SELECT * FROM levels WHERE id = :level_id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['level_id' => $level_id]);
        $level = $stmt->fetch(PDO::FETCH_ASSOC);


        echo "  <center> <h2 class='text-white '>{$level['level_name']}</h2>  </center>";
        echo "  <center> <p class='text-light'>{$level['description']}</p>  </center>";
        ?>

        <h3 class='text-info'>Sessions</h3>
        <div class="list-group bg-transparent ">
            <?php
            $sessions_query = "SELECT * FROM sessions WHERE level_id = :level_id";
            $sessions_stmt = $connection->prepare($sessions_query);
            $sessions_stmt->execute(['level_id' => $level_id]);
            $sessions = $sessions_stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($sessions as $session) {
                echo "
                <a href='session.php?level_id={$level_id}&session_id={$session['id']}' class='list-group-item list-group-item-action bg-transparent text-white m-4 border border-warning rounded-pill pl-5'>
                    Go To Session {$session['session_number']}
                </a>
                ";
            }
            ?>
        </div>

        <?php
        // Check if user has completed all sessions of a level
        $level_id = $_GET['id']; // Assuming level_id is passed in the query
        $query = "SELECT COUNT(*) as total_sessions FROM sessions WHERE level_id = :level_id AND is_completed = 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':level_id', $level_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_sessions_completed = $result['total_sessions'];

        $quiz_query = "SELECT * FROM quizzes WHERE level_id = :level_id";
        $quiz_stmt = $connection->prepare($quiz_query);
        $quiz_stmt->bindParam(':level_id', $level['id']);
        $quiz_stmt->execute();
        $quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);


        if ($quiz): ?>
            <?php
            if ($total_sessions_completed == 12) : ?>
                <center class="m-3">
                    <a href="quiz.php?quiz_id=<?= htmlspecialchars($quiz['id']); ?>" class="btn btn-success ">Take Quiz</a>
                </center>
            <?php endif; ?>
        <?php else: ?>
            <p>No quiz available for this level.</p>
        <?php endif; ?>

        <a href="game.php" class="btn btn-info btn-block m-5">Back to Home</a>
    </div>

    <script src="../js/back-vid.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>