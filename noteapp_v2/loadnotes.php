<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');

// Resume the session;
session_start();
include('connection.php');

// Get the user_id;
$user_id =$_SESSION['user_id'];

// Run a query to delete empty notes;
$sql = "DELETE FROM notes WHERE note=''";

$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger">An Error occured!</div>';
  exit;
}

// Run a query to look for notes corresponding to user_id;
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY time DESC";

// Shows notes or alert message;
$result = mysqli_query($link, $sql);
if(!$result) {
  echo "<div class='alert alert-danger'>An Error occured: $sql ". mysqli_error($link) . "</div>";
  exit;

} else { // If the query is executed correctly;
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { // Store the result in $row, and the $row keeps fetching new row;
      $note_id = $row['note_id'];
      $note = $row['note'];
      $time = $row['time'];
      $time = date("F d, Y h:i:s A", $time);

      echo "<div class='note-div row'>
              <div class='col-xs-2 col-sm-2 delete pull-left'>
                <button class='btn btn-lg btn-danger'>delete</button>
              </div>

              <div class='note-header col-xs-11 col-sm-11 pull-right' id='$note_id'>
                 <div class='note-text'><p>". $note . "</p></div>
                 <div class='note-time'>". $time . " PDT</div>
              </div>
            </div>";

    }   // col-xs-7 col-sm-9;

  } else {
    echo '<div class="alert alert-warning">You have not created any notes yet!</div>';
  }
}

 ?>
