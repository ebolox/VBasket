$(document).ready(function () {

  $("#login").click(function () { login_block(event); });

  $("#username, #password").click(function () { login_reset(); });

});

// Riporta input e button allo stato iniziale
function login_reset () {

  $("#username, #password").removeClass("failed");
  $("#login").removeClass("btn-danger").addClass("btn-success");
  $("#login").text("Accedi");
}

// Impedisce il login
function login_block (event) {

  if ($("#login").attr("class").indexOf("btn-danger") >= 0) {
    event.stopPropagation();
    return false;
  }
}