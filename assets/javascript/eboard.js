var model = "eboard";
var sign = "+";

/* Timer primario */
var timer_primary_id;
var timer_primary_on = true;
/* Timer secondario */
var timer_secondary;
var hold_time = 2000;
var timer_secondary_id;
var timer_secondary_on = true;

$(document).ready(function() {

  // Chiama la funzione countdown all'avvio del documento
  // countdown();

  // Eventi del tabellone
  $("#ta_name, #tb_name").click( function () { modal_team ($(this), true); });
  $("#timer_primary").click( function () { handle_countdown_primary (); });
  $("#quarter").click( function () { handle_counter ($(this)); });
  $("#ta_points, #tb_points").click( function () { handle_counter ($(this)); });
  $("#ta_fouls, #tb_fouls, #ta_timeout, #tb_timeout").click( function () { handle_dot ($(this)); });
  $("#arrow").click( function () { handle_arrow (); });
  $("#ta_service, #tb_service").click( function () { handle_service (); });
  $("#eboard_secondary").click( function () { handle_countdown_secondary (); });

  // Posizione verticale della freccia
  box_period_position ();

  // Gestione tempo di click
  $("#timer_secondary").on("mousedown", function() {
    timer_secondary = setTimeout(reset_secondary, hold_time);
  }).on("mouseup mouseleave", function() {
    clearTimeout(timer_secondary);
  });

  /* Toolbar */
  // Selettori elementi a schermo
  $("#btn_ui").click( function () { go_to("ui"); });
  $("#btn_config").click( function () { sidebar_collapse (model + "_sidebar", "config"); });
  $("#btn_effects").click( function () { sidebar_collapse (model + "_sidebar", "effects"); });

  // Pulsanti gestione Tempo
  $("#" + model + "_timer_reset").click( function () { set_timer (); });
  $("#" + model + "_timer_play").click( function () { handle_countdown_primary (); });
  $("#" + model + "_timer_pause").click( function () { handle_countdown_primary (true); });

  // Pulsante Segno
  $("#" + model + "_sign label.btn").click( function () { handle_sign ($(this)); });

  // Pulsante Reset per inizio gara
  $("#" + model + "_reset").click( function () { reset_board (); });

  /* sidebar Configurazione */
  // Gestione click booleano sui componenti
  $(".sidebar li.btn-boolean").click( function () { handle_components ($(this)); });

  // Selettore Stile font
  $("#eboard_config_font").siblings(".dropdown-menu").first().find(".dropdown-item").click( function () {
    value = $(this).data("value");

    set_value ($(this));

    // Font di tabellone principale e secondario
    $("#" + model + "_content").attr("class", "container mt-4 " + $(this).data("value"));
    $("#" + model + "_secondary").attr("class", $(this).data("value"));

    // Aggiorna il db
    update_eboard ("font", value.replace("font-", ""), true);
  });

  // Effetti audio
  $(".btn-sound").click( function () { handle_effect_audio (event, $(this)); });
});

// Posizione verticale della freccia
function box_period_position () {
  $(".box-quarter").first().is(":visible") ?
    $("#arrow").css("top", "0") :
    $("#arrow").css("top", "80px");
}

// Funzione per diminuire il tempo di un secondo alla volta
function countdown_primary () {

  // Ottieni il tempo attuale dal testo dell'elemento
  var time_string = $("#timer").text();
  var time_array = time_string.split(":");
  var minutes = parseInt(time_array[0]);
  var seconds = parseInt(time_array[1]);

  // Calcola il nuovo tempo
  if (seconds > 0 || minutes > 0) {
    if (seconds == 0) {
      minutes--;
      seconds = 59;
    } else {
      seconds--;
    }
    // Aggiorna il testo dell'elemento con il nuovo tempo
    $("#timer").text(minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0"));

    // Attendi un secondo e chiama nuovamente la funzione countdown
    timer_primary_id = setTimeout(countdown_primary, 1000);
  } else {
    // Se il tempo è scaduto, esegui un'azione aggiuntiva
    alert("Tempo scaduto!");
  }
}

// Funzione per diminuire il tempo di un secondo alla volta
function countdown_secondary () {

  // Ottieni il tempo attuale dal testo dell'elemento
  var seconds = parseInt($("#timer_secondary").text());

  // Calcola il nuovo tempo
  if (seconds > 0) {

    seconds--;

    // Aggiorna il testo dell'elemento con il nuovo tempo
    $("#timer_secondary").text(seconds.toString());

    // Aggiorna il testo dell'elemento con il nuovo tempo
    if (seconds <= 5) {
      $("#eboard_secondary").addClass("bg-red").removeClass("bg-green");
    } else {
      $("#eboard_secondary").removeClass("bg-red").addClass("bg-green");
    }

    // Attendi un secondo e chiama nuovamente la funzione countdown
    timer_secondary_id = setTimeout(countdown_secondary, 1000);
  } else {
    // Se il tempo è scaduto, esegui un'azione aggiuntiva
    alert("Tempo scaduto!");
  }
}

// Cambia il senso della freccia Palla contesa
function handle_arrow () {

  arrow = $("#arrow");
  icon_left = "bi-arrow-left-circle";
  icon_right = "bi-arrow-right-circle";

  if (arrow.attr("class").match("left")) {
    arrow.removeClass(icon_left).addClass(icon_right);
    value = 1;
  } else {
    arrow.removeClass(icon_right).addClass(icon_left);
    value = 0;
  }

  // Aggiorna db
  update_eboard ("arrow", value);
}

// Lancia il gingle audio
function handle_effect_audio (event, btn) {
  event.stopPropagation();

  var audio_id = btn.val();
  var player = $("#player_" + audio_id);

  // Stoppa tutti i player
  //$(".vb-player").each( function () { $(this)[0].pause(); });
console.log("#####>" + audio_id + "<#####");
  player[0].paused ? player[0].play() : player[0].pause();
}

// Gestione dei componenti mostrati
function handle_components (btn) {

  field = btn.find("input[type='hidden']").first();
  icon = btn.find("i.bi").first();
  tag = btn.data("tag");
  components = $(".box-" + tag.replace("_", "-"));

  if (field.val() == "1") {
    icon_class = "bi bi-x text-danger";
    new_value = 0;
    components.hide();
  } else {
    icon_class = "bi bi-check text-success";
    new_value = 1;
    components.show();
  }

  // Posizione verticale della freccia
  box_period_position ();

  icon.attr("class", icon_class);
  field.val(new_value);

  // Aggiorna db
  update_eboard (tag, new_value, true);
}

// Interrompe il countdown gara
function handle_countdown_primary (force_pause = false) {

  if (timer_primary_on || force_pause) {
    clearTimeout(timer_primary_id);
    timer_primary_on = false;
  } else {
    countdown_primary();
    timer_primary_on = true;
  }

  // Aggiorna db
  value = $("#timer_primary").text();
  update_eboard ("timer", value);
}

// Interrompe il countdown dei 24 secondi
function handle_countdown_secondary (force_pause = false) {

  if (timer_secondary_on || force_pause) {
    clearTimeout(timer_secondary_id);
    timer_secondary_on = false;
  } else {
    countdown_secondary();
    timer_secondary_on = true;
  }

  // Aggiorna db
  value = $("#timer_secondary").text();
  update_eboard ("timer_secondary", value);
}

// Gestione aumento/diminuzione i contatori
// di numeri interi decimali
function handle_counter (component) {

  counter_now = parseInt(component.text());
  counter_new = sign == "+" ? (counter_now + 1) : (counter_now - 1);

  component.text(counter_new);

  // Aggiorna db
  param = component.attr("id");
  update_eboard (param, counter_new);
}

// Gestione aumento/diminuzione falli e timeout
function handle_dot (dots) {

  if (sign == "+") {
    dots_to_handle = dots.find("i.bi-circle").first();
    dots_to_handle.removeClass("bi-circle").addClass("bi-circle-fill");
  } else {
    dots_to_handle = dots.find("i.bi-circle-fill").last();
    dots_to_handle.removeClass("bi-circle-fill").addClass("bi-circle");
  }

  // Aggiorna db
  param = dots.attr("id");
  value = dots.find("i.bi-circle-fill").length;
  update_eboard (param, value);
}

// Gestione Servizio
function handle_service () {
  ta_service = $("#ta_service i.bi");
  tb_service = $("#tb_service i.bi");
  value = ta_service.attr("class").match("bi-circle-fill");

  if (value) {
    ta_service.removeClass("bi-circle-fill").addClass("bi-circle");
    tb_service.removeClass("bi-circle").addClass("bi-circle-fill");
    value = "1";
  } else {
    ta_service.removeClass("bi-circle").addClass("bi-circle-fill");
    tb_service.removeClass("bi-circle-fill").addClass("bi-circle");
    value = "0";
  }

  // Aggiorna db
  update_eboard ("service", value);
}

// Gestione addizione/sottrazione al click
function handle_sign (btn) {

  $("#" + model + "_sign label.btn").removeClass("active");
  $("#" + model + "_sign label.btn > input").removeAttr("checked");

  btn.addClass("active");
  btn.find("input").attr("checked", "checked");

  // Si assegna il segno alla variabile
  sign = btn.find("input:checked").data("value");
}

// Assegna i valori impostati nella toolbar
function reset_board () {

  // Timer
  handle_countdown_primary (true);
  set_timer ();

  // Punteggi
  $("#ta_points, #tb_points").text("0");

  // Falli e Time-out
  $("#ta_fouls, #tb_fouls, #ta_timeout, #tb_timeout").find("i").attr("class", "bi bi-circle ml-4");
}

// Reimposta i secondi al valore predefinito
function reset_secondary() {
  $("#timer_secondary").text(24);
}

// Assegna gli eventi ai pulsanti della modale squadra
function set_modal_team_events (team_id) {
  game_id = $("#game_id").val();

  // Pulsanti Squadra
  $("#team_change").click( function () { go_to("ui", "watch=game&id=" + game_id); });
  $("#team_edit").click( function () { go_to("ui", "watch=team&id=" + team_id); });

  // Gestione righe della tabella
  accounts = $(".roster ul > li");

  // Click sulla edit account
  accounts.find("button.btn-icon").click( function () { go_to("ui", "watch=account&id=" + $(this).data("value")); });

  // Mouseover sulla riga: mostra/nasconde i pulsanti contestuali
  accounts.mouseenter( function () { show_toolbar ($(this), true); });
  accounts.mouseleave( function () { show_toolbar ($(this), false); });

  $("#modal_team button.close").click( function () { modal_hide ("modal_team"); });
}

// Aggiorna il tempo sulla base di minuti e secondi impostati
function set_timer () {
  min = $("#" + model + "_timer_min").val();
  sec = $("#" + model + "_timer_sec").val();
  $("#timer_primary").text(min + ":" + sec);

  // Aggiorna db
  update_eboard ("timer", min + ":" + sec);
}

// Aggiorna il db con l'ultimo click
function update_eboard (param, value, config = false) {

  params = {
    action: "update_object",
    model: config ? "eboard_config" : model,
    id: $("#eboard_id").val(),
    param: param,
    value: value
  };

  update_backend ("logic.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: false,
    onComplete: function() { console.log("update_" + model + " complete"); },
    onLoading: function() { console.log("update_" + model + " loading"); }
  });
}