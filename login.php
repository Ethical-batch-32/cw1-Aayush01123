<!doctype html>
<html lang="en">
<head>
  <title>Aayush HTML Template - Log In</title>
  <meta charset="utf-8">
  <meta name="description" content="A minimal and responsive HTML5 landing page built on lightweight, clean and customizable code.">
  <meta name="viewport" content="width=device-width">
  <link rel="apple-touch-icon-precomposed" href="media/favicon.png">
  <link rel="icon" href="media/favicon.png">
  <link rel="mask-icon" href="media/favicon.svg" color="rgb(36,38,58)">
  <link rel="shortcut icon" href="media/favicon.png">
  <link rel="stylesheet" href="css/main.css">
</head>
<body class="page page-onboarding preload">
<?php 
session_start();
if(isset($_SESSION['email'])){
    header("Location: user.php");
    exit;
}
?>
  <main>

    <a href="index.php" class="button button-close" role="button"></a>

    <section class="row no-gutter reverse-order">
      <div class="col-one-half middle padding">
        <div class="max-width-s">
          <h5>Welcome back.</h5>
          <p class="paragraph">Enter your details below.</p>
          <form action="submit-login.php" method="post">
          <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required>
            <a href="forgot-password.php" class="form-help">Forgot password?</a>
          </div>
          <div class="form-group">
            <input id="remember-me" type="checkbox" name="remember-me">
            <label for="remember-me" class="checkbox">Remember Me</label>
          </div>
          <input type="submit" value="Log In" class="button button-primary full-width">
        </form>
        <script>
        <?php
        if(isset($errors) && count($errors) > 0){
          echo "alert('Wrong email/password combination');";
        }
        ?>
        </script>

        </div>
        <div class="center max-width-s space-top">
          <span class="muted">Don't have an account? </span><a href="signup.php">Sign Up</a>
        </div>
      </div>
      <div class="col-one-half bg-image-04 featured-image"></div>
    </section>

  </main>

  <script src="js/main.js"></script>
</body>
</html>
