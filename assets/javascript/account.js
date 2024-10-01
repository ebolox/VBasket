$(document).ready( function () {

  named = $("input[name='account[named]']").val();
  name_first = $("#" + model + "_name_first").val();
  name_last = $("#" + model + "_name_last").val();
  nickname = $("#" + model + "_nickname").val();

  // Gestione campi di testo
  $.each(["name_last", "name_first", "nickname", "email", "phone", "document_id"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_account (param, $(this).val()); });
  });

  // Gestione campi con dropdown
  $.each(["named", "account_type", "sex"],  function (i, param) {
    $("#" + model + "_" + param).siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
      set_value ($(this));
      update_account (param, $(this).data("value"));

      if (param == "named") { set_account_name (); }
    });
  });

  // Gestione campi con dropdown
  //$("#btn_" + model + "_named").find(".dropdown-menu > .dropdown-item").click(function () {
  //  set_value ($(this));
  //  update_account ("named", $(this).data("value"));
  //  set_account_name ();
  //});

  // Pikaday initialization
  var picker_sport_fitness = init_pikaday (model, "sport_fitness");
  var picker_birth_date = init_pikaday (model, "birth_date");

  // Pulsanti gestione squadre associate
  $("#account_team_modify").click( function () {

    account_id = $("input[name='account[id]']").val();
    account_name = name_last + " " + name_first;
    modal_account_teams (account_id, account_name, true);
  });

  // Gestione modale account_teams
  set_modal_account_teams_events ();
});

// Aggiorna il nome account
function set_account_name () {

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

// Assegna gli eventi ai pulsanti della modale squadre del profilo
function set_modal_account_teams_events () {

  // De/Selezione squadra
  $("#list_account_teams tr").click( function () { toggle_team ($(this)); });

  $("#modal_account_teams button.close").click( function () { modal_hide ("modal_account_teams"); });
}

function toggle_team (tr) {
console.log(tr.attr("id"));
  team_id = parseInt(tr.attr("id").replace("team_", ""));
  btn = tr.find("td:first i.bi");
  field_team_ids = $("input[name='account[team_ids]']");

  team_ids_string = field_team_ids.val();
  team_ids = team_ids_string.split(",");

  icon_on = "bi-check-lg text-success";
  icon_off = "bi-x-lg text-warning";

  if (btn.attr("class").match("check")) {

    team_ids = team_ids.filter(function(value) {
      return value !== team_id;
    });

    btn.removeClass(icon_on).addClass(icon_off);
  } else {

    team_ids[team_ids.length] = team_id;

    btn.removeClass(icon_off).addClass(icon_on);
  }

  field_team_ids.val(team_ids.join(","));
}

// Aggiorna i dati dell'account
function update_account (param, value) {

  params = {
    account_id: $("#form_id").val(),
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