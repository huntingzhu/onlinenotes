<?php
// Start Session
session_start();
// Connect to the database;
include('connection.php');

// Check user inputs;
// Define error messages;

$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invaildEmail = '<p><strong>Please enter a valid email address!</strong></p>';

// Get the information of the form;

// Get email;
if(empty($_POST['forgotEmail'])) {
  $errors .= $missingEmail;
} else {
  $email = filter_var($_POST['forgotEmail'], FILTER_SANITIZE_EMAIL);
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors .= $invaildEmail;
  }
}

// If there are any errors, then print them out;
if($errors) {
  $resultMessage = '<div class="alert alert-danger">'. $errors . '</div>';
  echo $resultMessage;
  exit;
}

// If the form has no error;
// Prepare variables for the queries
$email = mysqli_real_escape_string($link, $email);

// If the email does not exist in the users table, print error;
$sql = "SELECT * FROM users WHERE email ='$email'";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs when running SELECT query to users table!</p></div>';
  exit;
}
$resultRows = mysqli_num_rows($result);
if($resultRows != 1) {
  echo '<div class="alert alert-danger"><p>The email has not registered!</p></div>';
  exit;
}

// Else, get the user_id
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];

// Create a unique activation code
$key = bin2hex(openssl_random_pseudo_bytes(16));

// Insert user details and activation code in the forgotpassword table;
$time = time();
$status = "pending";
$sql = "INSERT INTO forgotpassword (`user_id`, `resetkey`, `time`, `status`) VALUES ('$user_id', '$key', '$time', '$status')";

$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs when running INSERT query to forgotpassword table!</p></div>';
  exit;
}

// Send user an email with a link to activate.php with their email and activation code;
$message = "Please click on this link in 24 hours to reset your password:\n\n";
$message .= "http://hunting.thecompletewebhosting.com/noteapp/reset_password.php?user_id=$user_id&key=$key";
// Set the headers to prevent from going to spam folder;
$headers .= "Reply-To: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "Return-Path: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "From: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "Organization: Online Notes by Hunting\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

if(mail($email, 'Reset Your Password', $message, $headers)) {
  echo '<div class="alert alert-success"><p>A Reset-Password email has been sent to ' . $email
  . '. Please click on the reset-password page in 24 hours to reset your password.
  <br /><strong>Notice:</strong> This email might be put into your spam folder, just check it out!</p></div>';
}

 ?>
