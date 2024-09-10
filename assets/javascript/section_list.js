// Icona dropdown Cambio sezione
var section_selector = $("#section_selector + .dropdown-menu");
  
$(document).ready( function () {

  // Si imposta l'altezza della lista
  $("#" + model + "_list").css("max-height", parseInt($(window).innerHeight() - 200) + "px");

  // Gestione icona dropdown Cambio sezione
  section_selector.find(".dropdown-item[data-value='" + section + "']").hide();
  section_selector.find(".dropdown-item").click( function () { update_section_by_list_toolbar (model, $(this)); });

  // Pulsanti contestuali alla Sezione
  $("#" + model + "_new").click( function () { init_object (); });
  $("#" + model + "_print").click( function () { print_screen ($(this)); });

  // Link per aggiungere primo elemento alla Sezione
  $("#section_new").click( function () { init_object (); });

  if (model == "activity") {
    // Click su icone tabellone elettronico
    rows.find("td.cell-eboard").find("i.bi-calendar-x").click( function () { eboard_popup (event, $(this)); });
    rows.find("td.cell-eboard").find("i.bi-calendar-check").click( function () { eboard_popup (event, $(this)); });
    rows.find("td.cell-eboard").find("i.bi-calendar-plus").click( function () { eboard_tab (event, $(this)); });
  }
});

// Apre la scheda per un tabellone nuovo
function eboard_tab (event, btn) {
  event.stopPropagation();

  window.open("eboard.php?game=" + btn.data("id"), '_blank');
}

// Apre la scheda di un tabellone già associato
function eboard_popup (event, btn) {
  event.stopPropagation();

  eboard_popup = $("#eboard_popup");

  if (eboard_popup.text().trim().length > 0 || eboard_popup.children().length > 0) {

    eboard_popup.empty();
  } else {

    eboard_id = btn.data("id");
    buttons = '<button type="button" class="btn btn-sm btn-primary" onclick="eboard_tab($(this), "' + eboard_id + '");">Scheda</button>';
    buttons += '<button type="button" class="btn btn-sm btn-primary" onclick="eboard_show($(this), "' + eboard_id + '");">Schermo</button>';

    eboard_popup.popover({
      container: "body",
      title: "Tabellone elettronico",
      content: buttons,
      placement: "auto"
    });

    eboard_popup.popover("show");
  }
}