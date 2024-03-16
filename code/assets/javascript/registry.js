$(document).ready( function () {

  $("#registry_list").css("max-height", parseInt($(window).innerHeight() - 200) + "px");

  // Gestione dropdown Colonne
  btn_registry_options = $("#btn_registry_columns").find(".dropdown-menu > .dropdown-item");
  btn_registry_options.click( function () {
    opt_clicked = $(this);
    opt_hidden = update_btn_columns (event, opt_clicked);
    update_table_columns (opt_clicked, opt_hidden);
  });

  // Gestione dropdown Tesserati
  btn_registry_teams = $("#btn_registry_teams").find(".dropdown-menu > .dropdown-item");
  btn_registry_teams.click( function () {
    opt_clicked = $(this);
    team_id = update_teams (event, opt_clicked);
    get_registry_by_team (team_id);
  });

  // Gestione seleziona tutti i tesserati
  $("#registry_select_all").click( function () { registry_select_all () });

  // Pulsante Edita account
  $("#registry_new").click( function () { get_account_tab ("new") });
  $("#registry_edit").click( function () { get_account_tab ("edit") });
  $("#registry_delete").click( function () { delete_account () });
});

// Aggiorna la dropdown Colonne al click su un'opzione
function update_btn_columns (e, btn) {
  e.stopPropagation();

  icon = btn.find("i");
  opt_hidden = btn.attr("class").match("hidden");
  checked = "bi bi-eye text-success mr-1";
  unchecked = "bi bi-eye-slash text-danger mr-1";

  opts = btn.val() == "all" ?
    btn_registry_options :
    btn;

  if (opt_hidden) {
    opts.removeClass("hidden");
    opts.each( function () {
      $(this).find("i").attr("class", checked);
    });
  } else {
    opts.addClass("hidden");
    opts.each( function () {
      $(this).find("i").attr("class", unchecked);
    });
  }

  return opt_hidden;
}

// Aggiorna la tabella al click su opzione dropdown Colonne
function update_table_columns (btn, btn_hidden) {

  cols = btn.val() == "all" ?
    btn_registry_options :
    btn;

  cols.each( function () {
    col_class = $(this).val();
    btn_hidden ?
      $(".registry-" + col_class).show() :
      $(".registry-" + col_class).hide();
  });
}

// Aggiorna la dropdown Tesserati al click su un'opzione
function update_teams (e, btn) {
  e.stopPropagation();

  btn_registry_teams.each( function () {
    $(this).removeClass("text-success");
  });
  btn.addClass("text-success");

  team_checked = btn.text();
  $("#registry_teams").text(team_checked);

  team_id = btn.attr("data-value");
  $("input[name='registry[teams]']").val(team_id);

  return team_id;
}

// Aggiorna la tabella al click su opzione dropdown Tesserati
function get_registry_by_team (team_id) {

  params = {
    action: "get_registry_by_team",
    team_id: team_id
  };

  update_frontend("registry_list", "registry.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_team_results complete"); },
    onLoading: function () { console.log("update_team_results loading"); }
  });
}

// Seleziona o deseleziona tutti i tesserati a tabella
function registry_select_all () {

  if ($("#registry_select_all").val() == "all") {
    val = "none";
    txt = "Deseleziona tutti";
    selected = true;
  } else {
    val = "all";
    txt = "Seleziona tutti";
    selected = false;
  }

  $("#registry_select_all").val(val);
  $("#registry_select_all").text(txt);
  $("#registry_list > table > tbody > tr").each( function () { item_selected ("registry", $(this), selected); });
}