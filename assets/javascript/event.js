$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var object_id = $("#form_id").val();

  // Gestione campi di testo
  $.each(["name", "name_short", "place", "time_start", "time_stop"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val()); });
  });

  // Gestione campi squadra
  $.each(["type", "field", "town"],  function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      value = $(this).data("value");

      set_value ($(this));
      update_object (model, object_id, param, value);
    });
  });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  // Pikaday initialization
  var picker_date_on = init_pikaday (model, object_id);
});