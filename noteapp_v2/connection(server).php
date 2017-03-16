<?php
$link = mysqli_connect("localhost", "huntingt_note", "ad2137096068ad", "huntingt_onlinenotes");

if(mysqli_connect_error()) {
  die("Error: Unable to connect");
  echo "<script>window.alert('Errors!')</script>";
}
 ?>
