<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');

// Resume the session;
session_start();
include('connection.php');

// Get the id of the note sent through Ajax;
$note_id = $_POST['note_id'];
// Get the content of the note;
$note = $_POST['note'];
// Get the time
$time = time();

// Prepare for the query;
$note = mysqli_real_escape_string($link, $note);

// Run a query to update the notes;
$sql = "UPDATE notes SET note='$note', time='$time' WHERE note_id='$note_id'";

$result = mysqli_query($link, $sql);
if(!$result) {
// if(mysqli_affected_rows($link) != 1) {
  echo 'error';
}





 ?>
