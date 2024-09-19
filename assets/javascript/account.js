$(document).ready( function () {

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
});

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