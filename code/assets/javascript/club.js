$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  item_id = $("#form_id").val();

  // Cambia l'immagine aggiornando il db
  change_picture (model);

  // Gestione campo di testo
  $("#" + model + "_name").change( function () { update_item (model, item_id, param, $(this).val()); });

  // Gestione campi con dropdown
  $("#btn_" + model + "_town").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_item (model, item_id, "town", $(this).attr("data-value"));
  });

  // Gestione pulsanti form
  set_tab_buttons (action, model, item_id);

  if (action == "edit") {

    // Gestione campi di testo
    $.each([" place", "address", "website", "email", "phone", "phone_alt", "facebook"],  function (i, param) {
      $("#" + model + "_" + param).change( function () { update_item (model, item_id, param, $(this).val()); });
    });
  }
});