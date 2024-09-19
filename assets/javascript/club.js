$(document).ready( function () {

  // Gestione campi di testo
  $.each(["name", "place", "address", "phone", "email", "phone_alt", "website", "facebook", "instagram", "youtube"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_object (model, object_id, param, $(this).val()); });
  });

  // Gestione campi con dropdown
  $("#btn_" + model + "_town").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_object (model, object_id, "town", $(this).data("value"));
  });
});