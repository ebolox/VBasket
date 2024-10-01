$(document).ready( function () {

  if (action != "init_object") {
    // Gestione campi di testo
    $.each(["name", "time_start", "time_stop"], function (i, param) {
      $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val()); });
    });

    // Gestione campi con dropdown
    $.each(["field", "team", "type"], function (i, param) {
      $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
        update_object (model, object_id, param, $(this).data("value"));
      });
    });
  }

  // Gestione campi con dropdown
  $.each(["field", "team", "type"], function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      set_value ($(this));
    });
  });

  $("#" + model + "_weekly").click( function () {
    set_boolean (event, $(this));
  });

  // Inizializza il calendario Pikaday
  var picker_date_on = init_pikaday (model, object_id);
});