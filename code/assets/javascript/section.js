$(document).ready( function () {

  // Si imposta l'altezza della lista
  $("#" + model + "_list").css("max-height", parseInt($(window).innerHeight() - 200) + "px");

  // Modale: parametri per i pulsanti di scelta Sezione
  var section_title = "Cosa vuoi vedere?";
  var section_choices = [];
  if (model == "activity") {
    section_choices = [
      { "tag": "training", "label": "Allenamento", "class": "btn-primary", "click": "show_modal_choice(false); update_section('" + model + "', $(this));" },
      { "tag": "game", "label": "Partita", "class": "btn-primary", "click": "show_modal_choice(false); update_section('" + model + "', $(this));" },
      { "tag": "event", "label": "Evento", "class": "btn-primary", "click": "show_modal_choice(false); update_section('" + model + "', $(this));" }
    ];
  } else if (model == "book") {
    section_choices = [
      { "tag": "club", "label": "Società", "class": "btn-primary", "click": "show_modal_choice(false); update_section($(this));" },
      { "tag": "field", "label": "Campi di gioco", "class": "btn-primary", "click": "show_modal_choice(false); update_section($(this));" }
    ];
  }

  // Gestione dropdown Cambio sezione
  $("#section_selector + .dropdown-menu").find(".dropdown-item").click( function () { update_section (model, $(this)); });

  // Pulsanti contestuali alla Sezione
  $("#" + model + "_new").click( function () { init_item (); });
  $("#" + model + "_print").click( function () { print_screen ($(this)); });

  // Gestione righe della tabella
  rows = $("#" + model + "_list > table > tbody > tr");

  // Click sulla riga: de/seleziona
  rows.click( function () { item_selected (model, $(this)); });

  // Mouseover sulla riga: mostra/nasconde i pulsanti contestuali
  rows.mouseenter( function () { show_toolbar ($(this), true); });
  rows.mouseleave( function () { show_toolbar ($(this), false); });

  // Click su pulsanti contestuali
  rows.find("button.btn-edit").click( function () { edit_item (event, $(this)); });
  rows.find("button.btn-delete").click( function () { delete_item (event, $(this)); });
});

// Aggiorna la lista
// al click su opzione dropdown Sezione
function get_section (model, section) {

  params = {
    action: "get_" + section,
    section: section
  };

  update_frontend(model + "_list", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_" + section + "_results complete"); },
    onLoading: function () { console.log("update_" + section + "_results loading"); }
  });
}

// Assegna gli eventi a righe e pulsanti
function set_table_events (model) {

  // Gestione righe della tabella
  rows = $("#" + model + "_list > table > tbody > tr");

  // Click sulla riga: de/seleziona
  rows.click( function () { item_selected (model, $(this)); });

  // Mouseover sulla riga: mostra/nasconde i pulsanti contestuali
  rows.mouseenter( function () { show_toolbar ($(this), true); });
  rows.mouseleave( function () { show_toolbar ($(this), false); });

  // Click su pulsanti contestuali
  rows.find("button.btn-edit").click( function () { edit_item (event, $(this)); });
  rows.find("button.btn-delete").click( function () { delete_item (event, $(this)); });
}

// Aggiorna titolo e lista della Sezione
function update_section (model, btn) {

  section_tag = btn.data("value");
  section_title = btn.text();

  // Aggiorna il titolo della Sezione
  $("#section_btn").attr("data-value", section_tag);
  $("#section_title").text(section_title);

  // Aggiorna la lista della Sezione
  get_section (model, section_tag);
}