<?php
session_start();
include 'db.php';

// Check if user is logged in and has an active session
if(!isset($_SESSION['email'])){
    header("location: login.php");
    exit;
}

$email = $_SESSION['email'];

// check user table
$query = "SELECT id, name FROM admin WHERE email='$email'";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results) == 1) {
    $row = mysqli_fetch_assoc($results);
    $_SESSION['admin_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $email;
    $user = $row['name'];
    if(isset($_SESSION['user_id']))
    unset($_SESSION['user_id']);
}

// check admin table
$query = "SELECT id, name FROM users WHERE email='$email'";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results) == 1) {
    $row = mysqli_fetch_assoc($results);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $email;
    $admin = $row['name'];
    if(isset($_SESSION['admin_id']))
    unset($_SESSION['admin_id']);
    header('location: user.php');
    exit();
}

// Check if logout button is clicked
if(isset($_POST['logout'])){
    session_destroy();
    setcookie('email', '', time()-1);
    setcookie('pass', '', time()-1);
    header('location: login.php');
    exit;
}

// Check if the update details form has been submitted
if(isset($_POST['update_details'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($password)) {
        // Hash the password for security
        $password = md5($password);
        // Update the user's details in the database
        $query = "UPDATE admin SET name='$username', email='$email', password='$password' WHERE email='$email'";
    } else {
        // Update the user's details in the database without changing the password
        $query = "UPDATE admin SET name='$username', email='$email' WHERE email='$email'";
    }
    mysqli_query($conn, $query);

    // Set a session variable to indicate that the details have been updated
    $_SESSION['details_updated'] = true;

    // Redirect the user to the same page
    header("location: user.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
  <style type="text/css">

    .pacifico{
      font-family: 'Pacifico', cursive;
    }
    a.navbar-brand{
      font-family: 'Pacifico', cursive;
      font-size: 30px;
    }

    button.btn:hover i{
      color: white !important;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  
  </head>
  <body class="d-flex flex-column h-100">
    <header class="mb-5">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="html/index.html" style="color: #2268FF">Aayush</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" > Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home Page</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="html/index.html">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" class="btn btn-primary" data-toggle="modal" data-target="#listusers">Users</a>
        </li>

      </ul>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Details
</button>

      <form method="POST" class="form-inline mt-2 mt-md-0">
        <button class="btn btn-outline-success larger my-2 my-sm-0" name="logout" type="submit"><i class="fas fa-user text-success" style="color: red;"></i> Logout</button>
      </form>
      
    </div>
  </nav>
</header>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0 p-0">
  <div class="container">
    <h1 class="mt-5">Welcome to Admin panel <?=$user?>,</h1>
    <p></p>
    <p class="lead"></p>
  </div>



  <div class="modal" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <form action="" method="POST">
        <div class="form-group">
            <label for="username">Name</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user;?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update_details" class="btn btn-primary">Save Changes</button>
      </form>
      </div>
    </div>
  </div>
</div>




<?php
    if(isset($_POST['delete_user'])){
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $query = "DELETE FROM users WHERE id = {$user_id}";
        mysqli_query($conn, $query);
    }
?>
<div class="modal" tabindex="-1" role="dialog" id="listusers">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List of Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $query = "SELECT id, name, email FROM users";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td>
                <form action="" method="POST">
                  <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <hr>
    <span class="text-muted float-right">&copy 2022:<a class="pacifico text-secondary" href="html/index.html"> @aayush </a></span>
  </div>
</footer>
  <!-- Bootstrap core JavaScript-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/  nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>