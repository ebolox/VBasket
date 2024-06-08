$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var object_id = $("#form_id").val();

  var init_object = action == "init_object" ? true : false;

  if (init_object) {

    // Gestione campo Nome
    //$("#" + model + "_name").change( function () { update_object (model, object_id, param, $(this).val(), init_object); });
  } else {

    // Gestione campi di testo
    $.each(["name", "name_short", "jersey_first", "jersey_second"],  function (i, param) {
      $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val(), init_object); });
    });

    // Gestione campi squadra
    $.each(["club"],  function (i, param) {
      $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
        value = $(this).data("value");

        set_value ($(this));
        update_object (model, object_id, param, value, init_object);
      });
    });
  }

  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").change( function () { switch_to_edit(event, $(this)); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);
});