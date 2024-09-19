$(document).ready( function () {

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

  $("#roster_btn").click( function () { modal_team ($(this), true); });
});