/* 
	 Name of Work Unit:  Functions.js
	 Purpose of Work Unit:  JavaScript functions for the project.
	 Author: Peter Lucan	Student Number: C00228946	Date: 14/03/2021
	 Description: This page contains functions that show or hide the password fields.
*/

function showPass() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

function showPassAndConfirm() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  var y = document.getElementById("password2");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}