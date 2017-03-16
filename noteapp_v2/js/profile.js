// Ajax call to updateusername.php
$("#updateUsernameForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: datatopost,
        success: function(data){
          if(data){
              $("#usernameMessage").html(data);
              window.location = "profile.php";
          }
        },
        error: function(){
            $("#usernameMessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call to update username. Please try again later.</div>");

        }

    });

});

// Ajax call to updatepassword.php
$("#updatePasswordForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data != 'success'){
              $("#passwordMessage").html(data);
            } else{
              $("#passwordMessage").html("<div class='alert alert-success'>Your password has been updated successfully.</div>");
              window.location = "index.php";
            }
        },
        error: function(){
            $("#passwordMessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call to update password. Please try again later.</div>");

        }

    });

});



// Ajax call to updateemail.php
$("#updateEmailForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: datatopost,
        success: function(data){
          if(data != 'success'){
            $("#emailMessage").html(data);
          } else{
            $("#emailMessage").html("<div class='alert alert-success'>Your Email has been updated successfully.</div>");
            window.location = "index.php";
          }
        },
        error: function(){
            $("#emailMessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call to update email. Please try again later.</div>");

        }

    });

});
