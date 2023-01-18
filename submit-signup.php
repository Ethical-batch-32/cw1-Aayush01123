<?php
include 'db.php';

// Check if user is already logged in
if(isset($_SESSION['user'])){
  echo "<script>alert('You are already logged in.');</script>";
  header('Location:user.php');
  die();
}

// Check for empty fields
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
  echo "<script>alert('Please fill in all fields.');</script>";
  echo "<script> window.location.href='signup.php' </script>";
  die();
}

// Sanitize user input
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if email already exists
$check_email = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $check_email);
if(mysqli_num_rows($result) > 0) {
  echo "<script>alert('Email already exists.');</script>";
  echo "<script> window.location.href='signup.php' </script>";
  die();
 
}

// Hash password
$password = md5($password);

// Insert data into database
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Registered successfully');</script>";
    header('Location:login.php');
  } else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    echo "<script> window.location.href='signup.php' </script>";
  }
  

// Close connection
mysqli_close($conn);
?>