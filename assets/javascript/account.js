$(document).ready( function () {

  action = $("#form_action").val();
  model = $("#form_model").val();
  object_id = $("#form_id").val();

  // Gestione upload immagine
  change_picture (model);

  // Gestione pulsanti form
  set_tab_buttons (action, model, object_id);

  $(".btn-edit").click( function () { switch_to_edit(event, $(this).next()); });
  $(".btn-edit + input[type='text']").change( function () { switch_to_edit(event, $(this)); });

  if (action != "init_object") {

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
    account_id: object_id,
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