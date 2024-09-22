<?php require_once './connection.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign in</title>
  <link rel="icon" href="./images/logo.png" />
  <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    /> -->
  <link rel="stylesheet" href="./css/login.css" />
</head>

<body>


  <h1 class="text-center mt-5">Login page</h1>



  <div>
    <!-- If there an error -->
    <?php if (isset($_SESSION['error'])): ?>

      <div class="alert alert-warning text-center">
        <?php echo $_SESSION['error']; ?>
      </div>

      <?php unset($_SESSION['error']); ?>

    <?php endif; ?>
    <!-- end of error display -->


    <!-- In case of Success -->
    <?php if (isset($_SESSION['success'])): ?>

      <div class="alert alert-success text-center">
        <?php echo $_SESSION['success']; ?>
      </div>

      <?php unset($_SESSION['success']); ?>

      <?php header('refresh:2; url=profile.php') ?>

    <?php endif; ?>
    <!-- end of success display -->
  </div>



  <!-- Form -->
  <div class="container-1">
    <form action="./loginHandle.php" method="post">
      <div class="mainbox">
        <h1>Sign in</h1>
        <br />
        <br />
        <br />
        <div class="input-boxes">
          <input
            class="inputUserName"
            type="email"
            name="email"
            placeholder="Email" />

          <br />
          <br />
          <br />

          <input
            class="inputPassWord"
            type="password"
            name="pass"
            placeholder="Password" />

          <br />
          <br />
          <br />

          <br />
          <button type="submit" value="submit" name="submit">Log in</button>
          <br />
          <br />
          <br />
          <a class="createAcc" href="register.php">Create account.</a>
        </div>
      </div>
    </form>
  </div>

  <!-- <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script> -->
</body>

</html>