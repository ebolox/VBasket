$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var item_id = $("#form_id").val();

  var init_item = action == "init_item" ? true : false;

  // Gestione campi di testo
  $.each(["name", "round", "time_start", "time_stop"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_item (model, item_id, param, $(this).val(), init_item); });
  });

  // Gestione campi squadra
  $.each(["type", "field", "team", "opponent"],  function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      value = $(this).data("value");

      set_value ($(this));
      update_item (model, item_id, param, value, init_item);
    });
  });

  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").change( function () { switch_to_edit(event, $(this)); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, item_id);

  // Pikaday initialization
  var picker_date_on = init_pikaday (model, item_id);
});