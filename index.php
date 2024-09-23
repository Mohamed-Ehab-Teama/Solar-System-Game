<?php

require_once './connection.php';

if ($_SESSION['login'] != true) {
    header('location:login.php');
    exit();
}

$name = $_SESSION['username'];
$email = $_SESSION['email'];

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="./images/logo.png" />
    <link rel="stylesheet" href="./css/index.css">

</head>

<body style=" background-image: url(./images/solar-system-bg.jpg); background-size: cover; ">

    <!-- NAVBAR -->
    <nav class="nav-style navbar navbar-expand-lg bg-transparent ">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./images/logo.png" alt="Bootstrap" width="50" height="45">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./solar-system.php">
                            <button type="button" class="btn btn-outline-warning">3D Sloar System</button>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <button type="button" class="btn btn-outline-warning">Start Learning</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <button type="button" class="btn btn-outline-warning">Profile</button>
                        </a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a class="nav-link" href="./logout.php">
                        <button class="btn btn-outline-danger" type="button">LogOut</button>
                    </a>
                </form>
            </div>
        </div>
    </nav>


    <!-- First Card Content -->
    <div class="main-card card mt-5">
        <div class="card-body">
            <h1 class="card-title text-center">Solar System Exploration</h1>
            <br>
            <p class="card-text">
                Join us as we explore our planetary neighborhood: The Sun, planets, moons, comets, and asteroids.
            </p>
            <!-- Image Cards -->
            <div class="img-cards d-flex flex-column justify-content-around">
                <!-- Row 1 -->
                <div class="row-div d-flex flex-row justify-content-around">
                    <div class="card col">
                        <center>
                            <img src="./images/solar-system-bg.jpg" class="card-img-top" alt="...">
                            <h3>Solar System</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    The solar system includes the Sun, eight planets, five officially named dwarf planets, and hundreds of moons, and thousands of asteroids and comets
                                </p>
                            </div>
                        </center>
                    </div>
                    <div class="card col">
                        <center>
                            <img src="./images/sun.jpeg" class="card-img-top" alt="...">
                            <h3>The SUN</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    The Sun is a massive, nearly perfect sphere of hot plasma at the center of the Solar System.
                                </p>
                            </div>
                        </center>
                    </div>
                </div>
                <!-- Row 2 -->
                <div class="row-div d-flex flex-row justify-content-around">
                    <div class="card col">
                        <center>
                            <img src="./images/planets.jpeg" class="card-img-top" alt="...">
                            <h3>The Planets</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    A planet is a large, rounded astronomical body that is generally required to be in orbit around a star, stellar remnant, or brown dwarf, and is not one itself.
                                </p>
                            </div>
                        </center>
                    </div>
                    <div class="card col">
                        <center>
                            <img src="./images/eclipse.jpeg" class="card-img-top" alt="...">
                            <h3>The Eclipse</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    A solar eclipse occurs when the Moon passes between Earth and the Sun, thereby obscuring the view of the Sun from a small part of Earth, totally or partially
                                </p>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

        </div>
    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>