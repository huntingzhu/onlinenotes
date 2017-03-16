// Define variables;
var activeNote = 0;
var editMode = false;

// Load loadnotes.php at the beginning;
$(document).ready(function() {
  // load notes on page load: AJAX call to loadnotes.php;
  $.ajax({
    url: "loadnotes.php",
    success: function(data) {
      $('#notesList').html(data);
      loadNoteFunc();
    },
    error: function() {
      $("#alertMessage").text("There was an issue in the Ajax call of loadnotes.php!");
      $("#alert").fadeIn();
    }

  });
});

// Add a new note: Ajax call to createnote.php;
$("#addNote").click(function() {
  $.ajax({
    url: "createnotes.php",
    success: function(data) {
      if(data == 'error') {
        // console.log("error");
        $("#alertMessage").text("There was an issue inserting the new note!");
        $("#alert").fadeIn();
      } else {
        // Update activeNote to the id of the new note;
        activeNote = data;
        // console.log(activeNote);
        $("#notePadRow textarea").val("");

        // Show and hide elements;
        showHide(['#notePadRow', '#allNotes', '#done'], ['#notesRow', '#addNote', '#edit', '#doneEdit']);
        $("#notePadRow textarea").focus();
      }
    },
    error: function() {
      $("#alertMessage").text("There was an issue in the Ajax call of createnotes.php!");
      $("#alert").fadeIn();
    }
  });
});
// type note: Ajax call to updatenotes.php;
// click on all notes button;
$('#allNotes').click(function() {
  $.ajax({
    url: "loadnotes.php",
    success: function(data) {
      $('#notesList').html(data);
      loadNoteFunc();
      showHide(["#addNote", "#edit", "#notesRow"], ["#allNotes", "#notePadRow", '#done', '#doneEdit']);

    },
    error: function() {
      $("#alertMessage").text("There was an issue in the Ajax call of loadnotes.php!");
      $("#alert").fadeIn();
    }

  });
});

// Click on done after editing: load notes again;
$('#done').click(function() {
  // console.log(activeNote);
  $.ajax({
    url: "updatenotes.php",
    type: "POST",
    // We need to send the current note content with its note_id to the php file;
    data: {note: $("#notePadRow textarea").val(), note_id: activeNote},
    success: function(dataReturned) {
      if(dataReturned == 'error') {
        $("#alertMessage").text("There was an issue in the Ajax call of updatenotes.php! Try again later!");
        $("#alert").fadeIn();
      }
    },
    error: function() {
      $("#alertMessage").text("There was an issue in the Ajax call of updatenotes.php!");
      $("#alert").fadeIn();
    }

  });

  $.ajax({
    url: "loadnotes.php",
    success: function(data) {
      $('#notesList').html(data);
      loadNoteFunc();
      showHide(["#addNote", "#edit", "#notesRow"], ["#allNotes", "#notePadRow", '#done', '#doneEdit']);
      // $('#notesList').fadeIn();
    },
    error: function() {
      $("#alertMessage").text("There was an issue in the Ajax call of loadnotes.php!");
      $("#alert").fadeIn();
    }

  });
});

// click on edit: go to edit mode (show delete buttons, ..)
$("#edit").click(function() {
  // Switch to edit mode;
  editMode = true;

  // Reduce the width of note-header;
  $(".note-header").removeClass("col-xs-11 col-sm-11");
  $(".note-header").addClass("col-xs-7 col-sm-9");

  // Show and hide elements;
  showHide(["#doneEdit", ".delete"], ["#edit", "#done"]);


});

// click on doneEdit;
$("#doneEdit").click(function() {
  // Switch to edit mode;
  editMode = false;

  // Expand the width of note-header;
  $(".note-header").removeClass("col-xs-7 col-sm-9");
  $(".note-header").addClass("col-xs-11 col-sm-11");

  // Show and hide elements;
  showHide(["#edit"], [".delete", "#doneEdit", "#done"]);


});



// functions;

// click on delete;
function loadDeleteFunc() {
  $(".delete button").click(function() {
    var deleteDiv = $(this).parent();
    console.log(deleteDiv);
    console.log(deleteDiv.next());

    // Send Ajax call to deletenotes.php
    $.ajax({
      url: "deletenotes.php",
      type: "POST",
      // We need to send the current note content with its note_id to the php file;
      data: {note_id: deleteDiv.next().attr("id")},
      success: function(dataReturned) {
        if(dataReturned == 'error') {
          $("#alertMessage").text("There was an issue in the Ajax call of deletenotes.php! Try again later!");
          $("#alert").fadeIn();
        } else {
          deleteDiv.parent().fadeOut(300, function() { deleteDiv.parent().remove(); });
        }
      },
      error: function() {
        $("#alertMessage").text("There was an issue in the Ajax call of deletenotes.php!");
        $("#alert").fadeIn();
      }

    });
  });
}

// Click on a note;
// Note that ajax will not wait for the compilation of the code below; so has to put it into ajax;
function loadNoteFunc() {
  $(".note-header").click(function() {
    if(!editMode) { // Test if it is not in editMode;
      // Update activeNote variable to id of note;
      activeNote = $(this).attr("id");  // id means note_id;

      // Fill text area;
      $("#notePadRow textarea").val($(this).find(".note-text").text());

      // Show and hide elements;
      showHide(['#notePadRow', '#allNotes', '#done'], ['#notesRow', '#addNote', '#edit', '#doneEdit']);
      $("#notePadRow textarea").focus();

    }
  });
  loadDeleteFunc(); // load the function of delete button too;
}






// Show and Hide elements;
// @para array1 is an array of elements which are to be shown;
//       array2 is an array of elements which are to be hidden;
function showHide(array1, array2) {
  var i;
  for(i = 0; i < array1.length; i++) {
    $(array1[i]).show();
  }

  for(i = 0; i < array2.length; i++) {
    $(array2[i]).hide();
  }
}

// This is used to hidden some item;
function hideItem(item) {
  $(item).hide();
}
