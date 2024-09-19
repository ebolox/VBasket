$(document).ready( function () {

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

  // Inizializza il calendario Pikaday
  var picker_date_on = init_pikaday (model, object_id);
});