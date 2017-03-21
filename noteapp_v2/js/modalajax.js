// Ajax Call for the sign up form
// Once the form is submitted
$("#signupform").submit(function(event){
  // Prevent default php processing
  event.preventDefault();
  // Collect user inputs
  var dataToPost = $(this).serializeArray();
  // console.log(dataToPost);
  // Send the info of the form to signup.php using AJAX;
  $.ajax({
    type: "POST",
    url: "signup.php",
    data: dataToPost,
    success: function(data) {
      if(data) {
        $("#signupMessage").html(data);
        // console.log(data);
      }
    },
    error: function() {
      $("#signupMessage").html("<div class='alert alert-danger'><p>There was an error with the ajax call.</p></div>");
    }
  });

});

// Ajax Call for the Login form
// Once the form is submitted
$("#loginform").submit(function(event){
  // Prevent default php processing
  event.preventDefault();
  // Collect user inputs
  var dataToPost = $(this).serializeArray();
  // console.log(dataToPost);
  // Send the info of the form to signup.php using AJAX;
  $.ajax({
    type: "POST",
    url: "login.php",
    data: dataToPost,
    success: function(data) {
      if(data == "success") {
        window.location = "loggedin.php";
      } else {
        $("#loginMessage").html(data);
      }
    },
    error: function() {
      $("#loginMessage").html("<div class='alert alert-danger'><p>There was an error with the ajax call during logging in.</p></div>");
    }
  });

});

// Ajax Call for the Forgot form
// Once the form is submitted
$("#forgotform").submit(function(event){
  // Prevent default php processing
  event.preventDefault();
  // Collect user inputs
  var dataToPost = $(this).serializeArray();
  // console.log(dataToPost);
  // Send the info of the form to signup.php using AJAX;
  $.ajax({
    type: "POST",
    url: "forgot_password.php",
    data: dataToPost,
    success: function(data) {
      $("#forgotMessage").html(data);
    },
    error: function() {
      $("#forgotMessage").html("<div class='alert alert-danger'><p>There was an error with the ajax call during forgot-password process.</p></div>");
    }
  });

});
