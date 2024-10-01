$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  object_id = $("#form_id").val();

  // Gestione upload immagine
  $("#" + model + "_img").click( function(){ $("#" + model + "_img_file").trigger("click"); });
  $("#" + model + "_img_file").on("change", function (e) { preload_image(e, model + "_img", model, object_id, true); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  // Assegnazione campi obbligatori
  set_mandatory_fields (model);

  // Gestione icona edit
  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").blur( function () { switch_to_edit(event, $(this)); });

  // Mostra/nasconde la sezione
  $("ul.form-label > li.form-title").click( function () {

    form_label = $(this).parent();
    form_name = form_label.data("toggle");
    form_data = $("ul.form-data[data-toggle='" + form_name + "']");
    form_toggle = $(this).find("i");

    if (form_label.attr("class").match("hidden")) {

      form_toggle.removeClass("bi-chevron-down").addClass("bi-chevron-up");
      form_label.removeClass("hidden");
      form_data.removeClass("hidden");
    } else {

      form_toggle.removeClass("bi-chevron-up").addClass("bi-chevron-down");
      form_label.addClass("hidden");
      form_data.addClass("hidden");
    }
  });
});