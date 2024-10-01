$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  object_id = $("#form_id").val();
  
  // Gestione campi di testo
  $.each(["name", "name_short"],  function (i, param) {
    $("#" + model + "_" + param).on("blur", function () { update_object (model, object_id, param, $(this).val()); });
  });

  // Gestione campi con dropdown
  $("#btn_" + model + "_object_type").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_objectable (model, object_id, $(this).data("value"));
  });
  $("#btn_" + model + "_object_id").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_object (model, object_id, "object_id", $(this).data("value"));
  });

  // Gestione campi booleani
  $.each(["main", "archived"],  function (i, param) {
    $("#" + model + "_" + param).click(function () {
      set_boolean (event, $(this));
      update_object (model, object_id, param, $(this).data("value"));
    });
  });

  // Gestione area drag e immagine
  model_img = $("#" + model + "_img");

  // Area drag file se non stiamo inizializzando
  if (action == "init_object") {
    model_img.removeClass("vb-image").addClass("vb-file-add");
    model_img.find("img").hide();
    model_img.find("svg").show();
  }
});