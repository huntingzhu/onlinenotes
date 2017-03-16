<?php

//start session and connect
session_start();
include ('connection.php');

//get user_id
$user_id = $_SESSION['user_id'];

//Get username sent through Ajax
$username = $_POST['username'];

// Prepare for the query;
$username = mysqli_real_escape_string($link, $username);

//Run query and update username
$sql = "UPDATE users SET username='$username' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) != 1){
  echo '<div class="alert alert-danger"><p>
    There was an error updating storing the new username in the database!
  </p></div>';
} else {
  echo '<div class="alert alert-success"><p>
  Your user name has been updated successfully!
  </p></div>';
}

?>
