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

  // Gestione modale Sezione
  $("#section_btn").click( function () { show_modal_choice (true, section_title, section_choices); });

  // Pulsanti contestuali alla Sezione
  $("#" + model + "_new").click( function () { get_item_tab ("new", model); });
  $("#" + model + "_edit").click( function () { get_item_tab ("edit", model); });
  $("#" + model + "_delete").click( function () { delete_item (model); });
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

// Aggiorna titolo e lista della Sezione
function update_section (model, btn) {

  section_tag = btn.attr("data-value");
  section_title = btn.text();

  // Aggiorna il titolo della Sezione
  $("#section_btn").attr("data-value", section_tag);
  $("#section_title").text(section_title);

  // Aggiorna la lista della Sezione
  get_section (model, section_tag);
}