<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');
// If the user is logged incand logout == 1;
if(isset($_SESSION['user_id']) && $_GET['logout'] == 1) {
  session_destroy();
  setcookie("rememberme", "", time() - 3600); // Delete the cookie;
  $_COOKIE['rememberme'] = NULL;    // Deleting cookie is different from $_COOKIE == NULL;

  // echo '<div class="alert alert-danger"><p>The cookie is destroyed? ' . var_dump($_COOKIE['rememberme']) . '</p></div>';

  header("Location:index.php");

}


 ?>
