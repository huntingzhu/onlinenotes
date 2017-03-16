<?php
// This file is going to reset the password;
session_start();
include('connection.php');

// If email or activation key is missing, show an error;
if(!isset($_POST['user_id']) || !isset($_POST['key'])) {
  echo '<div class="alert alert-danger"><p>Error occurs during running reset-password process!</p></div>';
  exit;
}
// else
// Store them in two variables
$user_id = $_POST['user_id'];
$key = $_POST['key'];
$time = time() - 86400; // This reset-password page is only valid for 24h;

// Prepare variables for the query;
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

// Run query: Check combination of user_id &key exists and less than 24h old;
$sql = "SELECT user_id FROM forgotpassword WHERE (resetkey = '$key' AND user_id = '$user_id' AND time > '$time' AND status='pending')";

// Check the result;
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query to forgotpassword table!</p></div>';
  exit;
}

$count = mysqli_num_rows($result);
if($count !== 1) {
  echo '<div class="alert alert-danger"><p>Reset Password failed! Maybe the link is expired! Please try it again later!</p></div>';
  exit;
}

// Check user inputs;
// Define error messages;
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invaildPassword = '<p><strong>Your Password should be at least 6 characters long!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';

// Get password;
if(empty($_POST['password1'])) { // If the first password is empty;
  $errors .= $missingPassword;
} elseif(strlen($_POST['password1']) < 6 ) {  // If the length of password is less thon 6 or longer than 30, print error;
  $errors .= $invaildPassword;
} else {
  $password1 = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
  if(empty($_POST['password2'])) {   // If the second Password is empty;
    $errors .= $missingPassword2;
  } else {
    $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
    if($password1 !== $password2) {  // If the passwords don't match;
      $errors .= $differentPassword;
    }
  }
}

// If there are any errors, then print them out;
if($errors) {
  $resultMessage = '<div class="alert alert-danger">'. $errors . '</div>';
  echo $resultMessage;
  exit;
}

// prepare the variable for the query to reset the password stored in database;
$password = mysqli_real_escape_string($link, $password1);
$password = hash('sha256', $password);


// Run query to Update password in the users table;
$sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>There was an error occuring in the UPDATE query to users table!</p></div>';
  exit;
}

// If the query is successful;
if(mysqli_affected_rows($link) != 1) {
  echo '<div class="alert alert-danger"><p>Your account could not be reset password. Please try again later.</p>!</div>';
  echo '<div class="alert alert-danger"><p>' . mysqli_error($link) . '</p></div>';
  exit;
}

// Run query to update status in the forgotpassword table;
$sql = "UPDATE forgotpassword SET status = 'used' WHERE user_id='$user_id' AND resetkey='$key'";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>There was an error occuring in the UPDATE query to forgotpassword table!</p></div>';
  exit;
}

// If the query is successful;
if(mysqli_affected_rows($link) != 1) {
  echo '<div class="alert alert-danger"><p>Your account could not be reset status. Please try again later.</p>!</div>';
  echo '<div class="alert alert-danger"><p>' . mysqli_error($link) . '</p></div>';
  exit;
}

// All is successful;

echo '<div class="alert alert-success"><p>Your password has been update successfully!<a href="index.php">Login</a></p></div>';




?>
