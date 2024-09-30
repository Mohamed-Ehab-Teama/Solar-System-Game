<?php

require_once './connection.php';

if ($_SESSION['login'] != true) {
    header('location:login.php');
    exit();
}

$name = $_SESSION['username'];
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];


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
                        <a class="nav-link" href="./game/game.php">
                            <button type="button" class="btn btn-outline-warning">Start Learning</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./game/progress.php">
                            <button type="button" class="btn btn-outline-warning">Profile</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <button type="button" class="btn btn-outline-warning">Games</button>
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



    <!-- Second Card Content -->
    <div class="main-card card mt-5">
        <div class="card-body">
            <h1 class="card-title text-center">Solar Phenomena</h1>
            <br>
            <p class="card-text">
                Solar Phenomenas are natural phenomena which occur within the atmosphere of the Sun.
            </p>
            <!-- Image Cards -->
            <div class="img-cards d-flex flex-column justify-content-around">
                <!-- Row 1 -->
                <div class="row-div d-flex flex-row justify-content-around">
                    <div class="card col">
                        <center>
                            <img src="./images/solar wind 0.webp" class="card-img-top" alt="...">
                            <h3>Solar Wind</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    The solar wind is a continual stream of protons and electrons from the sun's outermost atmosphere — the corona.
                                    <br>
                                    <br>
                                    These charged particles breeze through the solar system at speeds ranging from around 250 miles (400 kilometers) per second to 500 miles (800 km) per second, in a plasma state, according to the National Oceanic and Administration Space Weather Prediction Center (SWPC)
                                </p>
                            </div>
                        </center>
                    </div>
                    <div class="card col">
                        <center>
                            <img src="./images/sunspot.jpeg" class="card-img-top" alt="...">
                            <h3>SunSpots</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    Sunspots are cooler regions on the Sun caused by a concentration of magnetic field lines.
                                    <br>
                                    Occasionally, dark spots freckle the face of the Sun. These are sunspots, cooler regions on the Sun caused by a concentration of magnetic field lines. Sunspots are the visible component of active regions, areas of intense and complex magnetic fields on the Sun that are the source of solar eruptions
                                </p>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Last Content -->
    <div class="main-card card mt-5">
        <div class="card-body">
            <!-- Image Cards -->
            <div class="img-cards d-flex flex-column justify-content-around">
                <!-- Row 1 -->
                <div class="row-div d-flex flex-row justify-content-around">
                    <div class="card col">
                        <center>
                            <img src="./images/telescope.jpeg" class="card-img-top" alt="...">
                            <h3>Telescope</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    A telescope is a device used to observe distant objects by their emission, absorption, or reflection of electromagnetic radiation.
                                    <br>
                                    <br>
                                    Originally, it was an optical instrument using lenses, curved mirrors, or a combination of both to observe distant objects – an optical telescope
                                </p>
                            </div>
                        </center>
                    </div>
                    <div class="card col">
                        <center>
                            <img src="./images/vechile explo.jpeg" class="card-img-top" alt="...">
                            <h3>Space Exploration Vehicle (SEV)</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    The Space Exploration Vehicle (SEV) is a modular vehicle concept developed by NASA from 2008 to 2015.
                                    <br>
                                    <br>
                                    It would have consisted of a pressurized cabin that could be mated either with a wheeled chassis to form a rover for planetary surface exploration (on the Moon and elsewhere) or to a flying platform for open space missions such as servicing satellites and missions to near-Earth asteroids.
                                </p>
                            </div>
                        </center>
                    </div>
                    <div class="card col">
                        <center>
                            <img src="./images/space craft.jpeg" class="card-img-top" alt="...">
                            <h3>Space Craft</h3>
                            <div class="card-body">
                                <p class="card-text">
                                    A spacecraft is a vehicle that is designed to fly and operate in outer space.
                                    <br>
                                    <br>
                                    Spacecraft are used for a variety of purposes, including communications, Earth observation, meteorology, navigation, space colonization, planetary exploration, and transportation of humans and cargo.
                                </p>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Footer -->
    <!-- Remove the container if you want to extend the Footer to full width. -->
    <!-- <div class="container my-5"> -->
    <footer class="my-footer text-center text-lg-start bg-transparent" style="background-color: #db6930;">
        <div class="container d-flex justify-content-center py-5">
            <a href="https://www.facebook.com/NASA/" target="_blank">
                <button type="button" class="btn btn-primary bg-transparent btn-lg btn-floating mx-2" style="background-color: #54456b;">
                    <i class="fab fa-facebook">
                        <img src="./images/facebook logo.png" alt="logo">
                    </i>
                </button>
            </a>
            <a href="https://www.linkedin.com/company/nasa" target="_blank">
                <button type="button" class="btn btn-primary bg-transparent btn-lg btn-floating mx-2" style="background-color: #54456b;">
                    <i class="fab fa-linkedin">
                        <img src="./images/linkedin logo.jpg" alt="logo">
                    </i>
                </button>
            </a>
            <a href="https://www.youtube.com/user/NASAtelevision" target="_blank">
                <button type="button" class="btn btn-primary bg-transparent btn-lg btn-floating mx-2" style="background-color: #54456b;">
                    <i class="fab fa-linkedin">
                        <img src="./images/youtube logo.png" alt="logo">
                    </i>
                </button>
            </a>
        </div>

        <!-- Copyright -->
        <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="https://github.com/Mohamed-Ehab-Teama">Mohamed Ehab Teama</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- </div> -->
    <!-- End of .container -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>