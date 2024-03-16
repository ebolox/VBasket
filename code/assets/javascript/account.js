$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  item_id = $("#form_id").val();

  // Precarica l'immagine account
  change_picture (model);

  // Gestione campi di testo
  $.each(["name_last", "name_first"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_account (param, $(this).val()); });
  });

  // Gestione dropdown Ruolo
  $("#btn_" + model + "_role").find(".dropdown-menu > .dropdown-item").click(function () {
    set_value ($(this));
    update_account ("role", $(this).attr("data-value"));
    teams_by_role ($(this).attr("data-value"));
  });

  // Gestione pulsanti form
  set_tab_buttons (action, model, item_id);

  if (action == "edit") {

    // Gestione campi di testo
    $.each(["nickname", "email", "phone", "document_id"],  function (i, param) {
      $("#" + model + "_" + param).change( function () { update_account (param, $(this).val()); });
    });

    // Gestione campi con dropdown
    $("#btn_" + model + "_named").find(".dropdown-menu > .dropdown-item").click(function () {
      set_value ($(this));
      update_account ("named", $(this).attr("data-value"));
      set_account_name ();
    });

    // Gestione campi squadra
    $.each(["team_a", "team_b", "team_c"],  function (i, param) {
      $("#btn_" + model + "_" + param).find(".dropdown-menu > .dropdown-item").click(function () {
        team_id = $(this).attr("data-value");

        set_value ($(this));
        update_account (param, team_id);
        update_team_list (param, team_id);
      });
    });

    // Inizializziamo le dropdown squadra
    update_team_list ("team_a", $("input[name='account[team_a]']").val());

    // Mostriamo o nascondiamo le select squadra
    teams_by_role ($("input[name='account[role]']").val());

    // Pikaday initialization
    var picker_sport_fitness = new Pikaday({
      field: $("#" + model + "_sport_fitness")[0],
      format: "DD/MM/YYYY",
      //toString(date, format) { pikaday_to_string (date); },
      //parse(dateString, format) { pikaday_parse (dateString); },
      i18n: calendar_words,
      onSelect: function(date) {
        //$("#" + model + "_sport_fitness").val(date.toString());
        //
        //val = date.toString().split("/");
        //value = val[2] + "-" + val[1] + "-" + val[0];
        //
        //// Aggiorniamo il db
        //update_account ("sport_fitness", value);
      }
    });

    var picker_birth_date = new Pikaday({
      field: $("#" + model + "_birth_date")[0],
      format: "DD/MM/YYYY",
      //toString(date, format) { pikaday_to_string (date); },
      //parse(dateString, format) { pikaday_parse (dateString); },
      i18n: calendar_words,
      onSelect: function(date) {
        //$("#" + model + "_birth_date").val(date.toString());
      }
    });
  }
});

// Calendario Pikaday parse interno
function pikaday_parse (date_string) {
  // dateString is the result of `toString` method
  const parts = date_string.split('/');
  const day = parseInt(parts[0], 10);
  const month = parseInt(parts[1], 10) - 1;
  const year = parseInt(parts[2], 10);
  return new Date(year, month, day);
}

// Calendario Pikaday toString interno
function pikaday_to_string (calendar_date) {
  // you should do formatting based on the passed format,
  // but we will just return 'D/M/YYYY' for simplicity
  const day = calendar_date.getDate();
  const month = calendar_date.getMonth() + 1;
  const year = calendar_date.getFullYear();
  return `${day}/${month}/${year}`;
}

// Aggiorna i dati dell'account
function update_account (param, value) {

  params = {
    account_id: item_id,
    action: "update_account",
    param: param,
    value: value
  };

  update_backend("logic.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("update_account complete"); },
    onLoading: function() { console.log("update_account loading"); }
  });
}

// Aggiorna il nome account
function set_account_name () {

  named = $("input[name='account[named]']").val();
  name_first = $("#" + model + "_name_first").val();
  name_last = $("#" + model + "_name_last").val();
  nickname = $("#" + model + "_nickname").val();

  switch (named) {
    case "f+l":
      name_full = name_first + " " + name_last; break;
    case "f+l+s":
      name_full = name_first + " " + name_last[0] + "."; break;
    case "l+f":
      name_full = name_last + " " + name_first; break;
    case "l+f+s":
      name_full = name_last + " " + name_first[0] + "."; break;
    case "n":
      name_full = nickname; break;
    default:
      name_full = name_first + " " + name_last; break;
  }

  $("#" + model + "_alias").text(name_full);
}

// Nelle dropdown Squadre, le liste sono composte
// dalle sole squadre non ancora assegnate
function update_team_list (team, team_id) {

  switch (team) {
    case "team_b":
      team_a = "team_a";
      team_b = "team_c"; break;
    case "team_c":
      team_a = "team_a";
      team_b = "team_b"; break;
    default:
      team_a = "team_b";
      team_b = "team_c"; break;
  }

  team_a_id = $("input[name='account[" + team_a + "]']").val();
  team_b_id = $("input[name='account[" + team_b + "]']").val();
  $("#btn_" + model + "_team_a, #btn_" + model + "_team_b, #btn_" + model + "_team_c").find(".dropdown-menu > .dropdown-item").show();

  $("#btn_" + model + "_" + team).find(".dropdown-menu > .dropdown-item").each( function () {
    if ([team_a_id, team_b_id].indexOf($(this).attr("data-value")) >= 0) { $(this).hide(); }
  });

  $("#btn_" + model + "_" + team_a).find(".dropdown-menu > .dropdown-item").each( function () {
    if ([team_id, team_b_id].indexOf($(this).attr("data-value")) >= 0) { $(this).hide(); }
  });

  $("#btn_" + model + "_" + team_b).find(".dropdown-menu > .dropdown-item").each( function () {
    if ([team_id, team_a_id].indexOf($(this).attr("data-value")) >= 0) { $(this).hide(); }
  });
}

// Nelle dropdown Squadre, le liste sono composte
// dalle sole squadre non ancora assegnate
function teams_by_role (role) {
  btn_teams = $("#btn_" + model + "_team_a, #btn_" + model + "_team_b, #btn_" + model + "_team_c").parent();

  ["coach", "athlete"].indexOf(role) >= 0 ?
    btn_teams.show() :
    btn_teams.hide();
}