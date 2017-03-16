<?php
// Build the link to mysql database;
include("connection.php");


// Start session;
session_start();

// Check user inputs;
// Define error messages;
$missingUsername='<p><strong>Please enter a username!</strong></p>';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invaildEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a password!</strong></p>';
$invaildPassword = '<p><strong>Your Password should be at least 6 characters long!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';

// Get the information of the form;
// Get username;
if(empty($_POST['username'])) {
  $errors .= $missingUsername;
} else {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
}

// Get email;
if(empty($_POST['email'])) {
  $errors .= $missingEmail;
} else {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors .= $invaildEmail;
  }
}

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

// If the form has no error;

// Prepare variables for the queries
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password1 = mysqli_real_escape_string($link, $password1);
// $password1 = md5($password1); // not strong enough;
$password1 = hash('sha256', $password1);

// If username exists in the users table, print errors;
$sql = "SELECT * FROM users WHERE username = '$username' ";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the query!</p></div>';
  echo '<div class="alert alert-danger">'. mysqli_error($link) . '</div>';
  exit;
}
$resultRows = mysqli_num_rows($result);
if($resultRows) {
  echo '<div class="alert alert-danger"><p>The username is already registered!</p></div>';
  exit;
}

// If email exists in the users table, print error;
$sql = "SELECT * FROM users WHERE email ='$email'";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query!</p></div>';
  exit;
}
$resultRows = mysqli_num_rows($result);
if($resultRows) {
  echo '<div class="alert alert-danger"><p>The email is already registered!</p></div>';
  exit;
}

// Create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

// Insert user details and activation code in the users table;
$sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password1', '$activationKey')";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the INSERT query!</p></div>';
  exit;
}

// Send user an email with a link to activate.php with their email and activation code;
$message = "Please click on this link to activate your account:\n\n";
$message .= "http://hunting.thecompletewebhosting.com/noteapp/activate.php?email=" . urlencode($email) . "&key=$activationKey";
// Set the headers to prevent from going to spam folder;
$headers .= "Reply-To: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "Return-Path: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "From: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
$headers .= "Organization: Online Notes by Hunting\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

if(mail($email, 'Confirm your Registration', $message, $headers)) {
  echo '<div class="alert alert-success"><p>Thank for your registration! A confirmation email has been sent to ' . $email
  . '. Please click on the activation link to activate your account.
  <br /><strong>Notice:</strong> This email might be put into your spam folder, just check it out!</p></div>';
}





 ?>
