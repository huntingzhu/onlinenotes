<?php
session_start();
include('connection.php');

// Get the id of the note through Ajax;
$note_id = $_POST['note_id'];

// Get the user id, just for security;
$user_id = $_SESSION['user_id'];

// Run a query to delete the note;
$sql = "DELETE FROM notes WHERE note_id='$note_id' AND user_id='$user_id'";

// Check the results;
$result = mysqli_query($link, $sql);
if(!$result) {
  echo 'error';
}





 ?>
