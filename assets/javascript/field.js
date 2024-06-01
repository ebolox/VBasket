$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  object_id = $("#form_id").val();

  // Cambia l'immagine aggiornando il db
  change_picture (model);

  // Gestione campo di testo
  $("#" + model + "_name").change( function () { update_object (model, object_id, param, $(this).val()); });

  // Gestione campi con dropdown
  $("#btn_" + model + "_town").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_object (model, object_id, "town", $(this).data("value"));
  });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  if (action == "edit") {

    // Gestione campi di testo
    $.each([" place", "address", "gps", "email", "phone", "notes"],  function (i, param) {
      $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val()); });
    });
  }
});