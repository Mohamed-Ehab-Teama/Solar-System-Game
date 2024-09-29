

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Exploration Game</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background-image: url('your-image-url.jpg'); /* Replace with your hero image */
            background-size: cover;
            color: white;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Welcome to Space Exploration Game!</h1>
    </div>

    <div class="container">
        <h2 class="text-center">Levels</h2>
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
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$level['level_name']}</h5>
                            <p class='card-text'>{$level['description']}</p>
                            <a href='level.php?id={$level['id']}' class='btn btn-primary'>Start Level</a>
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
                if ($user['is_admin']){ ?>
                    <a href="add_levels.php" class="btn btn-success btn-block">Add Level</a>
                    <a href="add_sessions.php" class="btn btn-info btn-block">Add Session</a>
                    <a href="add_quiz.php" class="btn btn-info btn-block">Add Quiz</a>
                    <a href="quiz_list.php" class="btn btn-info btn-block">Quizzes</a>
                    <a href="add_quiz_question.php" class="btn btn-info btn-block">Add Quizz Questions</a>
                <?php }
            }
        ?>

        
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
