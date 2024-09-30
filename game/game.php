<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Exploration Game</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* .hero {
            background-image: url('your-image-url.jpg');
            Replace with your hero image
            background-size: cover;
            color: white;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        } */

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

    <div class="hero text-center text-white">
        <h1 class="text-warning">Welcome to Space Exploration Game!</h1>
    </div>

    <div class="container">
        <h2 class="text-center text-white-50">Levels</h2>
        <div class="row">
            <?php
            require_once '../connection.php'; // Database connection
            $query = "SELECT * FROM levels";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($levels as $level) {
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card bg-transparent border-warning rounded-pill p-5 m-2'>
                        <div class='card-body'>
                            <h5 class='card-title text-warning'>{$level['level_name']}</h5>
                            <p class='card-text text-light'>{$level['description']}</p>
                            <a href='level.php?id={$level['id']}' class='btn btn-primary '>Start Level</a>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
        </div>


        <?php
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $connection->prepare($query);
        $stmt->execute(
            ['user_id' => $user_id]
        );
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            if ($user['is_admin']) { ?>
                <center>
                    <a href="add_levels.php" class="btn btn-outline-success btn-block m-3">Add Level</a>
                    <a href="add_sessions.php" class="btn btn-outline-secondary btn-block m-3">Add Session</a>
                    <a href="add_quiz.php" class="btn btn-outline-secondary btn-block m-3">Add Quiz</a>
                    <a href="quiz_list.php" class="btn btn-outline-secondary btn-block m-3">Quizzes</a>
                    <a href="add_quiz_question.php" class="btn btn-outline-info btn-block m-3">Add Quizz Questions</a>
                </center>
        <?php }
        }
        ?>


    </div>
    <center>
        <a href="../index.php" class="btn btn-outline-warning btn-block m-3">Back To Home Page</a>
    </center>


    <script src="../js/back-vid.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>