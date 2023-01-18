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
<?php 
$result = mysqli_query($conn,"SELECT * FROM users") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr><td><center><b>S.N.</b></center></td><td><center><b>Name</b></center></td><td><center></center></td><td><center><b>Email</b></center></td><td><center><b>Action</b></center></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) 
{
 $name = $row['name'];
 $email = $row['email'];
echo '<tr><td><center>'.$c++.'</center></td><td><center>'.$name.'</center></td><td><center>'.'</center></td><td><center>'.$email.'</center></td><td><center><a title="Delete User" href="update.php?demail='.$email.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></center></td></tr>';
}$c=0;
echo '</table></div></div>';
?>

