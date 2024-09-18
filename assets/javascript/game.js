$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var object_id = $("#form_id").val();

  var init_object = action == "init_object" ? true : false;

  // Gestione campi di testo
  $.each(["name", "round", "time_start", "time_stop"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val(), init_object); });
  });

  // Gestione campi squadra
  $.each(["type", "field", "team", "opponent"],  function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      value = $(this).data("value");

      set_value ($(this));
      update_object (model, object_id, param, value, init_object);
    });
  });

  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").blur( function () { switch_to_edit(event, $(this)); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  // Inizializza il calendario Pikaday
  var picker_date_on = init_pikaday (model, object_id);
});