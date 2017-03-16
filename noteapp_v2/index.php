<?php
session_start();
// Connect to the database;
include('connection.php');

// Log out;
include('logout.php');

// Remeber me;
include('remember.php');

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online Notes</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/onlinenotes.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">
                    <i class="glyphicon glyphicon-pencil"></i> ONLINE NOTES
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">

                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>

                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>

                    <li>
                        <a class="" href="" data-target="#loginModal" data-toggle="modal">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <section class="intro">
      <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">

                  <h1 class="brand-heading">ONLINE NOTES</h1>
                  <p class="intro-text">Your Private Notes with you wherever you go.</p>

                  <button type="button" class="btn btn-default btn-lg" data-target="#signupModal" data-toggle="modal">
                     <span class="network-name">Sign Up and Login!</span>
                  </button>

                  <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

                  <a href="#about" class="btn btn-circle page-scroll">
                      <i class="fa fa-angle-double-down animated"></i>
                  </a>
              </div>
          </div>

          <!-- Sign up form -->
          <form method="post" id="signupform">
            <div class="modal" id="signupModal" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h5 class="pull-left"> Sign up to use Online Notes App! </h5>
                      </div>

                      <div class="modal-body">
                        <!-- Sign up message from PHP file -->
                        <div id="signupMessage">

                        </div>

                        <div class="form-group">
                          <label for="username" class="sr-only">Username:</label>
                          <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30" />
                        </div>

                        <div class="form-group">
                          <label for="email" class="sr-only">Email:</label>
                          <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" maxlength="50" />
                        </div>

                        <div class="form-group">
                          <label for="password1" class="sr-only">Password:</label>
                          <input class="form-control" type="password" name="password1" id="password1" placeholder="Choose a password" maxlength="30" />
                        </div>

                        <div class="form-group">
                          <label for="password2" class="sr-only">Username:</label>
                          <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="30" />
                        </div>

                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal" data-target="#loginModal" data-toggle="modal">Already registered?</button>
                          <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                          <input type="submit" class="btn btn-primary" name="signup" value="Sign up">
                      </div>
                  </div>
              </div>
            </div>
          </form>

          <!-- Login form -->
          <form method="post" id="loginform">
            <div class="modal" id="loginModal" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h5 class="pull-left"> Login: </h5>
                      </div>

                      <div class="modal-body">
                        <!-- Login message from PHP file -->
                        <div id="loginMessage">

                        </div>

                        <div class="form-group">
                          <label for="loginEmail" class="sr-only">Email:</label>
                          <input class="form-control" type="text" name="loginEmail" id="loginEmail" placeholder="E-mail" maxlength="30" />
                        </div>

                        <div class="form-group">
                          <label for="loginPassword" class="sr-only">Password:</label>
                          <input class="form-control" type="password" name="loginPassword" id="loginPassword" placeholder="Password" maxlength="30" />
                        </div>

                        <div class="checkbox">
                          <label class="pull-left">
                            <input type="checkbox" name="rememberme" id="rememberme" />
                            Auto Login
                          </label>

                          <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotModal" data-toggle="modal">Forgot Password?</a>
                        </div>
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-success pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                          <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                          <input type="submit" class="btn btn-primary" name="login" value="Login">
                      </div>
                  </div>
              </div>
            </div>
          </form>

          <!-- Forgot password form -->
          <form method="post" id="forgotform">
            <div class="modal" id="forgotModal" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h5 class="pull-left"> Enter your email to reset your password: </h5>
                      </div>

                      <div class="modal-body">
                        <!-- forgot password message from PHP file -->
                        <div id="forgotMessage">

                        </div>

                        <div class="form-group">
                          <label for="forgotEmail" class="sr-only">Email:</label>
                          <input class="form-control" type="text" name="forgotEmail" id="forgotEmail" placeholder="E-mail" maxlength="30" />
                        </div>

                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-success pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                          <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                          <input type="submit" class="btn btn-primary" name="submit" value="submit">
                      </div>
                  </div>
              </div>
            </div>
          </form>

      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
              <h2>About Online Notes App</h2>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>

          </div>
        </div>
      </div>

    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
              <h2>About Online Notes App</h2>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>
              <p>Remian to be done.</p>

          </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Me</h2>
                <p>Feel free to email me to provide some feedback, or just say hello!</p>
                <p><a href="mailto:huntingzhu@gmail.com">huntingzhu@gmail.com</a>
                  <p><a href="mailto:onlinenotes@hunting.thecompletewebhosting.com">onlinenotes@hunting.thecompletewebhosting.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="#contact" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                    </li>
                    <li>
                        <a href="#contact" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>

                </ul>
            </div>
        </div>
      </div>

    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Online Notes 2017 by Hunting</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Ajax JavaScript -->
    <script src="js/index.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/onlinenotes.js"></script>



</body>

</html>
