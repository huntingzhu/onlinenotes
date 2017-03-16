<?php
// The user is redirected to this file after clicking the activation link;
// Signup link contains two GET parameters: email and actication key;
session_start();
include('connection.php');
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>
      Account Activation
    </title>
    <style>
      h1{
        color:purple;
      }

      .container-fluid {
        border: 1px solid purple;
        margin-top: 50px;
        margin-left: 20px;
        margin-right: 20px;
        border-radius:15px;
        padding-bottom: 20px;
      }

      .btn-success {
          border-radius: 4px;
      }
    </style>

  </head>
  <body>
    <div class="container-fluid">
      <div class="row">

        <div class="col-sm-offset-1 col-sm-10 contactForm">
          <h1>Account Activation</h1>
<?php
// If email or activation key is missing, show an error;
if(!isset($_GET['email']) || !isset($_GET['key'])) {
  echo '<div class="alert alert-danger"><p>Error occurs during running activation process!</p></div>';
  exit;
}
// else
// Store them in two variables
$email = $_GET['email'];
$key = $_GET['key'];

// Prepare variables for the query;
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);

// Run query: set activation field to "activated" for the provided email;
$sql = "UPDATE users SET activation = 'activated' WHERE (email = '$email' AND activation = '$key') LIMIT 1";  // only allow this operation once;
$result = mysqli_query($link, $sql);
// If the query is successful;
if(mysqli_affected_rows($link) == 1) {
  echo '<div class="alert alert-success"><p>Your account has been activated!</p></div>';
  echo '<a href="index.php" type="button" class="btn btn-success">Login</a>';
} else {
  echo '<div class="alert alert-danger"><p>Your account could not be activated. Please try again later.</p>!</div>';
  echo '<div class="alert alert-danger"><p>' . mysqli_error($link) . '</p></div>';
}

 ?>

        </div>
      </div>
    </div>


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
