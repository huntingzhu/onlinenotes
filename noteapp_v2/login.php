<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');
// Function definition area;
// Use f1 to encode the authentificators;
function f1($a, $b) {
  $c = $a . "," . bin2hex($b);
  return $c;
}

// Use f2 to further encode the cookie info;
function f2($a) {
  $b = hash('sha256', $a);
  return $b;
}


// Start a session;
session_start();
// Connect to the database;
include("connection.php");

// Check user inputs;
// Define error messages;
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';

$missingPassword = '<p><strong>Please enter a Password!</strong></p>';

// Get email;
if(empty($_POST['loginEmail'])) {
  $errors .= $missingEmail;
} else {
  $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
}

// Get password;
if(empty($_POST['loginPassword'])) { // If the first password is empty;
  $errors .= $missingPassword;
}  else {
  $password = filter_var($_POST['loginPassword'], FILTER_SANITIZE_STRING);
}

// If there are any errors, then print them out;
if($errors) {
  $resultMessage = '<div class="alert alert-danger">'. $errors . '</div>';
  echo $resultMessage;
  exit;
} else {
  // If the form has no error;

  // Prepare variables for the queries;
  $email = mysqli_real_escape_string($link, $email);
  $password = mysqli_real_escape_string($link, $password);
  // hash
  $password = hash('sha256', $password);

}

// Run query: Check the combination of email and password exists;
$sql = "SELECT * from users WHERE email = '$email' AND password = '$password' AND activation = 'activated'";
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query!</p></div>';
  echo '<div class="alert alert-danger">'. mysqli_error($link) . '</div>';
  exit;
}

// If there was some errors when checking;
$count = mysqli_num_rows($result);
if($count === 1) {
  $resultRow = mysqli_fetch_array($result, MYSQLI_ASSOC);

  $_SESSION['user_id'] = $resultRow['user_id'];  // set the session;
  $_SESSION['username'] = $resultRow['username'];  // use for showing the username;
  $_SESSION['email'] = $resultRow['email'];

  if(empty($_POST['rememberme'])) { // If remember me is not checked;
    setcookie("rememberme", "", time() - 3600); // Delete the cookie, then user has to re-login the next time;
    echo "success";
  } else {
    // Create two variables $authentificator1 and $authentificator2
    $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
    $authentificator2 = openssl_random_pseudo_bytes(20);

    // Stroe them in a cookie;
    $cookieValue = f1($authentificator1, $authentificator2); // f1 is an encode function;
    $expireTime = time() + 1296000; //  the cookie will last 15days, 15*24*60*60 = 1296000;
    setcookie(
      "rememberme",
      $cookieValue,
      $expireTime
    );

    $f2authentificator2 = f2($authentificator2);   // f2 is to hash the $authentificator2;
    $user_id = $_SESSION['user_id'];
    $expiration = date('Y-m-d H:i:s', $expireTime);

    // Run query to store them in rememberme table;
    $sql = "INSERT INTO rememberme (`authentificator1`, `f2authentificator2`, `user_id`, `expires`)
            VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
    $result = mysqli_query($link, $sql);
    if(!$result) {
      echo '<div class="alert alert-danger"><p>Error occurs during storing data to remember login info for the next time!</p></div>';
    } else {
      echo "success";
    }
  }
} else {
  echo '<div class="alert alert-danger">
    <p>Please Check the following errors!</p>
    <p>1. The email has not been registered. Or</p>
    <p>2. The email and password don\'t match. Or</p>
    <p>3. The email has not been activated.</p>
    </div>';
}




 ?>
