var calendar_fields = $("input[name='calendar[fields]']");
var calendar_hours = $("input[name='calendar[hours]']");
var calendar_teams = $("input[name='calendar[teams]']");
var calendar_activities = $("input[name='calendar[activities]']");
var activity_type = $("input[name='activity[type]']");
var activity_id = $("input[name='activity[id]']");
var activity_classes = ".activity-event, .activity-game, .activity-training";

// Modale scelta attività da creare
var activity_modal_title = "Quale attività vuoi creare?";
var activity_modal_choices = [
  { "label": "Allenamento", "class": "btn-primary", "click": "show_modal_choice(false); get_item_tab('new', 'training');" },
  { "label": "Partita", "class": "btn-primary", "click": "show_modal_choice(false); get_item_tab('new', 'game');" },
  { "label": "Evento", "class": "btn-primary", "click": "show_modal_choice(false); get_item_tab('new', 'event');" }
];

$(document).ready( function () {
  // Gestione dropdown Attività
  btn_calendar_activity = $("#btn_calendar_activities").find(".dropdown-menu > .dropdown-item");
  btn_calendar_activity.click( function () {
    opt_clicked = $(this);
    tag = set_dropdown ("calendar", "activities", opt_clicked, btn_calendar_activity);
    update_calendar(tag, calendar_teams.val());
  });

  // Gestione dropdown Squadre
  btn_calendar_team = $("#btn_calendar_teams").find(".dropdown-menu > .dropdown-item");
  btn_calendar_team.click( function () {
    opt_clicked = $(this);
    tag = set_dropdown ("calendar", "teams", opt_clicked, btn_calendar_team);
    update_calendar(calendar_activities.val(), tag);
  });

  // Gestione dropdown Campo
  btn_calendar_field = $("#btn_calendar_fields").find(".dropdown-menu > .dropdown-item");
  btn_calendar_field.click( function () {
    opt_clicked = $(this);
    tag = set_dropdown ("calendar", "fields", opt_clicked, btn_calendar_field);
    show_calendar_for_field(tag);
  });

  // Gestione dropdown Campo
  btn_calendar_hour = $("#btn_calendar_hours").find(".dropdown-menu > .dropdown-item");
  btn_calendar_hour.click( function () {
    opt_clicked = $(this);
    tag = set_dropdown ("calendar", "hours", opt_clicked, btn_calendar_hour);
    show_calendar_for_hour(tag);
  });

  // Pulsanti Calendario
  $("#calendar_new").data("toggle", "modal");
  $("#calendar_new").data("target", "#modal_choice");
  $("#calendar_new").click( function () { show_modal_choice (true, activity_modal_title, activity_modal_choices); });
  $("#calendar_print").click( function () { print_item_tab (); });

  // Modale #modal_choice
  $("#modal_choice button.close").click( function () { show_modal_choice (false); });

  // Inizializziamo il calendario
  // con ogni attività su ogni campo delle squadre gestite
  update_calendar(calendar_activities.val(), calendar_teams.val());
});

// Attacca le attività sul calendario
function apply_activities () {
	$(activity_classes).each( function () {
		cell_id = $(this).attr("id").replace("act_", "");
    time_start = parseInt($(this).attr("data-time-start"));
    time_last = parseInt($(this).attr("data-time-last"));
		cell_x = parseFloat($("#" + cell_id).offset().left);
		cell_y = parseFloat($("#" + cell_id).offset().top + time_start);
console.log("cell_id: " + cell_id + " | cell_x: " + cell_x + " | cell_y: " + cell_y);
		$(this).offset({top: cell_y, left: cell_x});
		$(this).css("height", time_last + "px");
    $(this).click( function (cell_id) { alert(cell_id); });
	});
}

// Mostra il calendario col campo scelto
function show_calendar_for_field (tag) {

  if (tag == "all") {
    colspan = 2;
	tag_hidden_field = "none";
  } else {
    colspan = 1;
	tag == "a" ?
	  tag_hidden_field = "b" :
	  tag_hidden_field = "a";
  }

  // Adatta le celle Giorno in larghezza
  $("#calendar_board table thead th:not(:first-child)").attr("colspan", colspan);

  // Mostra le celle della/e palestra/e desiderata
  $("#calendar_board table tbody td").show();
  if (tag_hidden_field != "none") {
    $("#calendar_board table tbody td.field-" + tag_hidden_field).hide();
  }
}

// Mostra il calendario con l'orario scelto
function show_calendar_for_hour (tag) {

  hour_rows = $("#calendar_board table tbody tr");
  hours = {
    "morning": [10, 11, 12, 13, 14, 15],
    "sport": [16, 17, 18, 19, 20, 21, 22, 23]
  };

  if (tag == "all") {
    hour_rows.show();
  } else {

    hour_rows.hide();

    // Mostra le righe dell'orario desiderato
    hour_rows.each( function () {
      hour = parseInt($(this).attr("id").replace("hour_", ""));
  
      if (hours[tag].indexOf(hour) >= 0) {
        $(this).show();
      }
    });
  }
}

// Aggiorna le attività del calendario
function update_calendar (activity_tag, team_tag) {

  // Elimina le attività presenti
  $(activity_classes).remove();

  params = {
    action: "get_calendar_by",
    activity_tag: activity_tag,
    team_tag: team_tag,
    account_id: $("#account_id").val()
  };

  update_frontend("activity_board", "logic.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_team_results complete"); },
    onLoading: function () { console.log("update_team_results loading"); }
  });
}