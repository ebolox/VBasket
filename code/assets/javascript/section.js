$(document).ready( function () {

  $("#" + model + "_list").css("max-height", parseInt($(window).innerHeight() - 200) + "px");

  // Gestione dropdown Sezione
  btn_section = $("#btn_" + model + "_section").find(".dropdown-menu > .dropdown-item");
  btn_section.click( function () {
    opt_clicked = $(this);
    section_tag = update_section (event, opt_clicked);
    get_section (section_tag);
  });

  // Pulsanti Area
  $("#" + model + "_new").click( function () { get_item_tab (model, "new") });
  $("#" + model + "_edit").click( function () { get_item_tab (model, "edit") });
  $("#" + model + "_delete").click( function () { delete_item (model); });
});

// Aggiorna la lista
// al click su opzione dropdown Sezione
function get_section (section_tag) {

  params = {
    action: "get_book",
    section_tag: section_tag
  };

  update_frontend(model + "_list", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_" + model + "_results complete"); },
    onLoading: function () { console.log("update_" + model + "_results loading"); }
  });
}

// Aggiorna la dropdown Sezione di rubrica
// al click su un'opzione
function update_sction (e, btn) {

  btn_section.each( function () {
    $(this).removeClass("text-success");
  });
  btn.addClass("text-success");

  section_name = btn.text();
  $("#" + model + "_section").text(section_name);

  section_tag = btn.attr("data-value");
  $("input[name='" + model + "[section]']").val(section_tag);

  return section_tag;
}