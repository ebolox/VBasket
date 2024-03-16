$(document).ready( function () {

  var action = $("#form_action").val();
  var model = $("#form_model").val();
  var item_id = $("#form_id").val();

  var radio_game_type = $("#game_type");
  var radio_game_field = $("#game_field");

  // Gestione campi di testo
  $.each(["name", "time_start", "time_stop"],  function (i, param) {
    $("#" + model + "_" + param).change( function () { update_item (model, item_id, param, $(this).val()); });
  });

  // Gestione campi squadra
  $("#btn_" + model + "_team").find(".dropdown-menu > .dropdown-item").click( function () {
    team_id = $(this).attr("data-value");

    set_value ($(this));
    update_item (model, item_id, param, team_id);
  });

  // Gestione pulsanti Tipo e Campo di allenamento
  radio_game_type.find(".btn").click(function () { set_radio_value ($(this)); });
  radio_game_field.find(".btn").click(function () { set_radio_value ($(this)); });

  // Gestione pulsanti form
  set_tab_buttons (action, model, item_id);

  // Pikaday initialization
  var picker_date_on = new Pikaday({
    field: $("#" + model + "_date_on")[0],
    format: "DD/MM/YYYY",
    //toString(date, format) { pikaday_to_string (date); },
    //parse(dateString, format) { pikaday_parse (dateString); },
    i18n: calendar_words,
    onSelect: function(date) {
      //$("#" + model + "_date_on").val(date.toString());
    }
  });
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