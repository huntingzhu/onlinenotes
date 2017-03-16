<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');

session_start();

// Function definition area;
// Use f1 to encode the authentificators;
function f1($a, $b) {
  $c = $a . ",". bin2hex($b);
  return $c;
}

// Use f2 to further encode the cookie info;
function f2($a) {
  $b = hash('sha256', $a);
  return $b;
}

// // If the session exists, redirect to loggedin page;
// if(isset($_SESSION['user_id'])) {
//   header("location:loggedin.php");
//   exit;
// }

// If the remember cookie exists
if(!empty($_COOKIE['rememberme'])) {
  // echo
  // f1: COOKIE: $a . "," . bin2hex($b);
  // f2; hash('sha256', $a);

  // Extract 4authentificators 1&2 from the cookie;
  list($authentificator1, $authentificator2) = explode(',', $_COOKIE['rememberme']);  // Return an array which contains the info inside the cookie;
  $authentificator2 = hex2bin($authentificator2);
  $f2authentificator2 = hash('sha256', $authentificator2);

  // Run the query to look for the authentificators in rememberme table;
  $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
  $result = mysqli_query($link, $sql);
  if(!$result) {
    echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query of rememberme table!</p></div>';
    exit;
  }

  $count = mysqli_num_rows($result);
  if($count !== 1) {
    echo '<div class="alert alert-danger"><p>Remember me process failed</p></div>';
    exit;
  }

  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  // If authentificator2 does not match;
  if(!hash_equals($row['f2authentificator2'], $f2authentificator2)) {  // compare 2 hash value;
    echo '<div class="alert alert-danger"><p>Hash_equals returned false.</p></div>';
    exit;
  } else {

    // Log the user in and redirect to notes page
    $_SESSION['user_id'] = $row['user_id'];

    // Run query to get username;
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * from users WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result) {
      echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query for username!</p></div>';
      echo '<div class="alert alert-danger">'. mysqli_error($link) . '</div>';
      exit;
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];

    // Redirect
    header("Location:loggedin.php");


  }

} else { // If There is no cookie. The code below is just for testing;
  // echo '<div class="alert alert-danger" style="margin-top: 50px;"><p>User_id:' . $_SESSION['user_id'] . '</p></div>';
  // echo '<div class="alert alert-danger"><p>Cookie value:' . $_COOKIE['rememberme'] . '</p></div>';

}

 ?>
