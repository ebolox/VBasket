$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var object_id = $("#form_id").val();

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);
});