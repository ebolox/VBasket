$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var object_id = $("#form_id").val();

  var radio_training_type = $("#training_type");
  var radio_training_field = $("#training_field");

  // Gestione campi di testo
  $.each(["name", "time_start", "time_stop"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val()); });
  });

  // Gestione campi con dropdown
  $.each(["field", "team", "type"],  function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      set_value ($(this));
      update_object (model, object_id, param, $(this).data("value"));
    });
  });

  // Gestione pulsanti Tipo e Campo di allenamento
  radio_training_type.find(".btn").click(function () { set_radio_value ($(this)); });
  radio_training_field.find(".btn").click(function () { set_radio_value ($(this)); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  // Inizializza il calendario Pikaday
  var picker_date_on = init_pikaday (model, object_id);
});