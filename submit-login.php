<?php
session_start();

// Connect to the database
include'db.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = md5($password);

    // check user table
    $query = "SELECT id, name FROM users WHERE email='$email' AND password='$password'";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $email;
        header('location: user.php');
        die();
    }

    // check admin table
    $query = "SELECT id, name FROM admin WHERE email='$email' AND password='$password'";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $email;
        header('location: admin.php');
        die();
    }else {
        echo "<script>alert('Email or Password Not Matched');</script>";
        echo "<script> window.location.href='login.php' </script>";
        die();
    }
}

?>