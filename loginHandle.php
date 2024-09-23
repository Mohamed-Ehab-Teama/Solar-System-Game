<?php

// require files
require_once './connection.php';


////////////////////////////////////////////////////////////////////////

// Get Method
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $_SESSION['error'] = 'Something went wrong. <br>You cannot access using GET method';
        header('location:login.php');
        exit();
}



////////////////////////////////////////////////////////////////////////

//if the user hits the submit button
if (isset($_POST['submit'])){


// fetch data
    foreach ($_POST as $key => $value)
    {
        $$key = $value;
    }

    // $email
    // $pass


// test
    // echo $email;
    // echo "<br>";
    // echo $pass;


////////////////////////////////////////////////////////////////////////

// check the connection with database 
    if (!$connection)
    {
        $_SESSION['error'] = 'Cannot connect to Database.';
        header('location:login.php');
        exit;
    }
    else
    {

        // encrypt password
        $pass = md5($pass);

        // get data from database
        $query = "select * from users where email = ? and password = ? ";

        $sqlQuery = $connection->prepare($query);

        $sqlQuery->execute([$email, $pass]);

        $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);

        if($result)
        {

            foreach ($result as $key => $value)
            {
                $_SESSION[$key] = $value;
            }

            // $_SESSION['id']
            // $_SESSION['name']
            // $_SESSION['email']


            $_SESSION['login'] = true;
            $_SESSION['success'] = 'Login Successful';
            header('location:index.php');
            exit;
        }
        else
        {
            $_SESSION['error'] = 'Email or Password is incorrect';
            header('location:login.php');
            exit;
        }






    }








}
