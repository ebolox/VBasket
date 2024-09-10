$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  object_id = $("#form_id").val();

  // Gestione upload immagine
  $("#" + model + "_img").click( function(){ $("#" + model + "_img_file").trigger("click"); });
  $("#" + model + "_img_file").on("change", function (e) { preload_image(e, model + "_img", model, object_id, true); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").change( function () { switch_to_edit(event, $(this)); });
});