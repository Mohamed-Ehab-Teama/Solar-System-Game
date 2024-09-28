<?php


// require files
require_once './connection.php';




// Get Method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION['error'] = 'Something went wrong. <br>You cannot access using GET method';
    header('location:register.php');
    exit();
}




// if press the submit button and sends the data
if (isset($_POST['submit'])) {

    foreach ($_POST as $key => $value) {
        // hold variables
        $$key = trim(htmlspecialchars(strip_tags($value)));
        // $name
        // $email
        // $pass
        // $cpass
    }


    // Test 
    // echo $name, "<br>",
    //     $email, "<br>",
    //     $pass, "<br>",
    //     $cpass, "<br>",
    // exit;


    //////////////////////////////////////////////////////////////////////////



    // if empty fileds
    if (empty($name)) {
        $_SESSION['error'] = 'UserName is Required';
        header('location:register.php');
        exit;
    } elseif (empty($email)) {
        $_SESSION['error'] = 'Email is Required';
        header('location:register.php');
        exit;
    } elseif (empty($pass)) {
        $_SESSION['error'] = 'Password is Required';
        header('location:register.php');
        exit;
    } elseif (empty($cpass)) {
        $_SESSION['error'] = 'The Confirmation of Password is Required';
        header('location:register.php');
        exit;
    }



    //////////////////////////////////////////////////////////////////////////


    // validate and sanitize fileds
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please enter a valid Email';
        header('location:register.php');
        exit;
    }


    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    //////////////////////////////////////////////////////////////////////////



    // No Duplicate Emails
    if (!$connection) {
        $_SESSION['error'] = 'Cannot connect to Database.';
        header('location:register.php');
        exit;
    } else {
        // check if emails exists before:

        $query = "select * from users where email = ? ";

        $sqlQuery = $connection->prepare($query);

        $sqlQuery->execute([$email]);

        $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION['error'] = 'Email already exists.';
            header('location:register.php');
            exit;
        }
    }



    //////////////////////////////////////////////////////////////////////////



    // Check if password and confirm password are the same
    if ($pass !== $cpass) {
        $_SESSION['error'] = 'Password and confirm password must be the same';
        header('location:register.php');
        exit;
    }


    //////////////////////////////////////////////////////////////////////////


    // Password length
    if (strlen($pass) < 3 || strlen($pass) > 16) {
        $_SESSION['error'] = 'Password must be between 3 to 16 characters';
        header('location:register.php');
        exit;
    }




    // encrypting password
    $pass = md5($pass);
    $cpass = md5($cpass);



    //////////////////////////////////////////////////////////////////////////



    // Storing data in database
    if (!$connection) {
        $_SESSION['error'] = 'Cannot store data. <br>Database Not Found.';
        header('location:register.php');
        exit;
    } else {
        // Inserting data to database:

        $query = "INSERT INTO users (username,email,password) 
        VALUES(?, ?, ?)";

        $sqlQuery = $connection->prepare($query);

        // $name
        // $email
        // $pass

        $sqlQuery->execute([$name, $email, $pass]);


        $_SESSION['success'] = 'Registered Successfully';

        // /////////////////////////////////////////////////////////////////////

        // // Get the new user's ID
        // $user_id = $connection->lastInsertId();

        // // Initialize session progress for the new user (for all levels and sessions)
        // $levels_stmt = $connection->query("SELECT id, total_sessions FROM levels");
        // $levels = $levels_stmt->fetchAll(PDO::FETCH_ASSOC);

        // foreach ($levels as $level) {
        //     $level_id = $level['id'];
        //     $total_sessions = $level['total_sessions'];

        //     for ($session_number = 1; $session_number <= $total_sessions; $session_number++) {
        //         $session_stmt = $connection->prepare("
        //         INSERT INTO sessions (user_id, level_id, session_number, is_completed) 
        //         VALUES (:user_id, :level, :session_number, FALSE)
        //     ");
        //         $session_stmt->execute([
        //             'user_id' => $user_id,
        //             'level' => $level_id,
        //             'session_number' => $session_number
        //         ]);
        //     }
        // }




        header('location:register.php');
        exit;
    }




    //////////////////////////////////////////////////////////////////////////
















}
