// PARTE COMUNE start
var defenders = [];
var offenders = [];
var roles = ["PM", "G", "AP", "AG", "C"];
var field_delta = {
  "white": 115,
  "parquet": 120,
  "blue": 115
};

var menu_selector = $("#menu_selector");
var hidden_selector = $("input[name='menu[selector]']");
var radio_player_phase = $("#player_phase");
var radio_action_phase = $("#action_phase");
var board = $("#technique_board");
var player_buttons = $("#player_button_bar");
var action_buttons = $("#action_button_bar");
var field_type = $("#btn_field_type");
var field_size = $("#btn_field_size");
var basket_delta = field_delta["white"]; // Pixel dal bordo superiore del campo
var player_b = 30;
var player_h = 15;
var action_buttons = $("#action_button_bar");
var action_click = 0; // Variabile per tenere traccia dei click "movimento palla"
var posX, posY = false;

$(document).ready( function () {

  // Caricando la pagina
  menu_selected (menu_selector.find(".btn").first());
  set_radio_value (radio_player_phase.find(".btn").first());
  set_radio_value (radio_action_phase.find(".btn").first());
  board.show();

  // Gestisce i menù contestuali per l'elemento selezionato
  menu_selector.find(".btn").click(function () { menu_selected ($(this)); });

  // Gestione del value di pulsanti, dropdown, checkbox e radio
  radio_player_phase.find(".btn").click(function () { set_radio_value ($(this)); });
  radio_action_phase.find(".btn").click(function () { set_radio_value ($(this)); });

  selector_ids = ["player_orientation", "action_type", "field_type", "field_size"];
  for (a in selector_ids) {
    $("#btn_" + selector_ids[a]).find(".dropdown-menu > .dropdown-item").click(function () { set_value ($(this)); });
  }

  $("#player_number").click(function () {
    set_checked ($(this));
    set_number ();
  });

  $("#player_role").click(function () {
    set_checked ($(this));
    set_role ();
  });

  // Funzioni del menù contestuale Giocatore
  player_buttons.find("#player_action").click(function () { menu_selected (menu_selector.find(".btn[data-value='action_parameters']")); });
  player_buttons.find("#player_rotate_left").click(function () { player_rotate (event, $(this), "left"); });
  player_buttons.find("#player_rotate_right").click(function () { player_rotate (event, $(this), "right"); });
  player_buttons.find("#player_delete").click(function () { player_delete (event, $(this)); });

  // Funzioni del menù contestuale Azione
  action_buttons.find("#action_player").click(function () { menu_selected (menu_selector.find(".btn[data-value='player_parameters']")); });
  action_buttons.find("#action_continue").click(function () { action_continue (event); });
  action_buttons.find("#action_delete").click(function () { action_delete (event); });

  // Gestiscono il campo su cui disegnare
  field_type.find(".dropdown-menu > .dropdown-item").click(function () { setTimeout(set_field, 200); });
  field_size.find(".dropdown-menu > .dropdown-item").click(function () { setTimeout(set_field, 200); });
});

// Gestisce i menù contestuali per l'elemento selezionato
function menu_selected (selected) {

  menu_value = selected.attr("data-value");
  hidden_value = menu_value.replace("_parameters", "");

  // Aggiorniamo i parametri del pulsante
  $(".vb-menu").hide();
  $("#" + menu_value).css("display", "inline-flex");
  set_radio_value(selected);

  // Assegnamo l'evento onclick in base alla selezione
  board.off("click");
  board.click(function () { handle_creation () });
}

function handle_creation () {
  hidden_selector.val() == "player" ?
    player_create (event) :
    action_create (event);
}
// PARTE COMUNE end

// PLAYERS start

// Gestisce la creazione di un giocatore
function player_create (e) {
  player_phase = $("input[name='player[phase]']").val();
  player_orientation = $("input[name='player[orientation]']").val();

  // Blocchiamo la creazione se la squadra è completa
  if (player_phase == "defense") {
    if (defenders.length == 5) {
      alert("Difesa completa");
      return false;
    }
  } else {
    if (offenders.length == 5) {
      alert("Attacco completo");
      return false;
    }
  }

  // Nascondiamo il menù contestuale giocatore
  player_buttons.hide();

  posX = e.pageX - board.offset().left;
  posY = e.pageY - board.offset().top;
  angle = player_orientation == "ball" ? (player_phase == "offense" ? 0 : 180) : calculate_angle(e, board);

  player_info = {
    "x": posX,
    "y": posY,
    "angle": angle
  };

  // Giocatore aggiunto alla squadra
  player_phase == "defense" ?
    defenders.push(player_info) :
    offenders.push(player_info);

  // Si definisce il giocatore
  player = $("<div></div>");
  player.attr("id", "player_" + player_phase + "_" + (player_phase == "defense" ? defenders.length : offenders.length));
  player.addClass("player " + player_phase);
  player.css({
    left: posX,
    top: posY,
    transform: "rotate(" + angle + "deg)"
  });

  // Si crea e applica il numero di maglia
  // (inizialmente nascosto)
  jersey_nr = $("<i></i>");
  jersey_nr.addClass("bi bi-" + (player_phase == "defense" ? defenders.length : offenders.length) + "-circle-fill jersey_nr " + player_phase);
  player.append(jersey_nr);
  if ($("input[name='player[number]']").val() == "true")
    jersey_nr.css("display", "inline");

  // Si crea e applica la sigla del ruolo
  // (inizialmente nascosta)
  role_index = player_phase == "defense" ? defenders.length : offenders.length;
  jersey_role = $("<b class='jersey_role " + player_phase + "'>" + roles[role_index - 1] + "</b>");
  player.append(jersey_role);
  if ($("input[name='player[role]']").val() == "true")
    jersey_role.css("display", "inline");

  // Giocatore sul campo
  board.append(player);
  // Menù contestuale al click sul giocatore
  player.click(function () { player_menu (event, $(this)); });
  // Menù contestuale mostrato subito
  player_menu (event, player);

  // Si abilita il trascinamento del giocatore
  player.on('mousedown', function(event) { player_dragging_start(event, $(this)); });

  // Termina il trascinamento del giocatore
  board.on('mouseup', function(event) { player_dragging_end(event); });
}

// Gestisce il menù contestuale Giocatore
function player_menu (e, player) {

  if (player_buttons.css("display") == "block") {

    $("#player_handled").val("");
    player_buttons.hide();
  } else {

    player_info = player.attr("id").split("_");
    player_nr = parseInt(player_info[2] - 1);
    if (player_info[1] == "defense") {
      player_buttons.css({
        left: defenders[player_nr]["x"] + board.offset().left,
        top: (defenders[player_nr]["y"])
      });
    } else {
      player_buttons.css({
        left: offenders[player_nr]["x"] + board.offset().left,
        top: offenders[player_nr]["y"] + 180
      });
    }

    $("#player_handled").val(player_nr);
    player_buttons.show();
  }
  e.stopPropagation();
}

// Variabili globali per il trascinamento
var dragging = false; // Stato del trascinamento
var player_to_move = null; // Elemento "player" da trascinare

// Funzione per gestire l'inizio del trascinamento
function player_dragging_start (e, player_selected) {

  e.stopPropagation();
  board.off("click");
  player_buttons.hide();

  dragging = true;
  player_id = parseInt(player_selected.attr("id").replace("player_", "").replace("defense_", "").replace("offense_", "")) - 1;
  player_to_move = player_selected;
  player_to_move.addClass("dragging");

  // Calcola la differenza tra la posizione del mouse e la posizione del player
  var offsetX = e.pageX - player_to_move.offset().left;
  var offsetY = e.pageY - player_to_move.offset().top;

  // Imposta i listener per il movimento del mouse
  board.on('mousemove', function(e) {
    if (dragging) {
      var x = e.pageX - offsetX - board.offset().left;
      var y = e.pageY - offsetY - board.offset().top;
      var angle = player_orientation == "ball" ? (player_phase == "offense" ? 0 : 180) : calculate_angle(e, board);

      // Nuovi parametri del giocatore
      player_info = {
        "x": x,
        "y": y,
        "angle": angle
      };

      // Si aggiorna il giocatore nella rispettiva squadra
      player_phase == "defense" ?
        defenders[player_id] = player_info :
        offenders[player_id] = player_info;

      // Imposta la nuova posizione del player
      player_to_move.css({
        left: x,
        top: y,
        transform: "rotate(" + angle + "deg)"
      });
    }
  });
}

// Funzione per gestire la fine del trascinamento
function player_dragging_end (e) {

  e.stopPropagation();

  if (dragging) {
    player_id = player_to_move.attr("id");
    player_to_move.removeClass('dragging');
    player_to_move = null;
    dragging = false;

    // Mousedown sul giocatore per draggarlo nuovamente
    $("#" + player_id).on('mousedown', function(event) { player_dragging_start(event, $(this)); });
    // Rimuove il listener per il movimento del mouse
    board.off('mousemove').off('click');
    // Lavagna pronta ad aggiungere nuovi giocatori
    setTimeout("board.click( function () { handle_creation (); })", 500);
  }
}

function player_rotate (e, player, side) {

  player_nr = parseInt($("#player_handled").val());
  player_phase = $("input[name='player[phase]']").val();

  if (player_phase == "defense") {
    side == "right" ?
      defenders[player_nr]["angle"] += 15 :
      defenders[player_nr]["angle"] -= 15;
  } else {
    side == "right" ?
      offenders[player_nr]["angle"] += 15 :
      offenders[player_nr]["angle"] -= 15;
  }

  player_phase == "defense" ?
    angle = defenders[player_nr]["angle"] :
    angle = offenders[player_nr]["angle"];

  $("#player_" + player_phase + "_" + parseInt(player_nr + 1)).css({
    transform: "rotate(" + angle + "deg)"
  });
  
  e.stopPropagation();
}

function player_delete (e, player) {

  player_nr = parseInt($("#player_handled").val());
  player_phase = $("input[name='player[phase]']").val();

  player_phase == "defense" ?
    defenders.splice(player_nr, 1) :
    offenders.splice(player_nr, 1);

  player_buttons.hide();
  $("#player_" + player_phase + "_" + parseInt(player_nr + 1)).remove();

  e.stopPropagation();
}

// Gestisce il numero del giocatore
function set_number () {

  $('input[name="player[number]"]').val() == "true" ?
    $(".jersey_nr").show() :
    $(".jersey_nr").hide();
}

// Gestisce il ruolo del giocatore
function set_role () {

  $('input[name="player[role]"]').val() == "true" ?
    $(".jersey_role").show() :
    $(".jersey_role").hide();
}

// Gestiscono il campo su cui disegnare
function set_field () {

  field_size_actual = board.css("background-image").match("_half") ? "half" : "whole";
  param_type = $('input[name="field[type]"]').val();
  param_size = $('input[name="field[size]"]').val();
  field_url = "../vdc_basket/assets/images/field_" + param_type + (param_size == "half" ? "_half" : "") + ".jpg";

  var alter_field = true;
  if (param_size != field_size_actual) {
    alter_field = confirm("Per cambiare le dimensioni del campo è necessario cancellare tutto. Procedere?");

    if (alter_field) {
      $(".player").remove();
      player_buttons.hide();

      defenders = [];
      offenders = [];
    }
  }

  if (alter_field) {
    //Settiamo il delta canestro-bordocampo
    basket_delta = field_delta[param_type];

    //Settiamo sfondo e dimensioni del campo
    board.css("background-image", "url('" + field_url + "')");
    board.css("height", param_size == "half" ? "675px" : "1350px");
  }
}

// Calcola l'angolo tra canestro e giocatore
function calculate_angle (e, board) {
  player_phase = $("input[name='player[phase]']").val();

  // Tutte le posizioni orizzontali iniziano dal
  // lato sinistro dello schermo
  basket_x = parseInt($(window).outerWidth() / 2);
  basket_y = board.offset().top + basket_delta;

  player_x = e.pageX + player_b;
  player_y = e.pageY + player_h;

  triangle_b = basket_x - player_x;
  triangle_h = player_y - basket_y;

  // Calcolo dell'angolo maggiore in radianti
  angle_radians = Math.atan2(triangle_b, triangle_h);

  // Convertire l'angolo in gradi se necessario
  angle_degrees = angle_radians * (180 / Math.PI);
  if (player_phase == "defense") {
    angle_degrees += 180;
  }

  return angle_degrees;
}
// PLAYERS end

// ACTION start
var action_svg = document.getElementById("action_board");
var action_count = 0;
var action_line, action_start, action_end;

function action_create (event) {

  var action_id = "action_" + $(".actions").length;

  // Aggiungiamo il tag line alla lavagna
  $("#action_board").html($("#action_board").html() + '<line id="' + action_id + '" class="actions" x1="0" y1="0" x2="0" y2="0" stroke="black" stroke-width="3"></line>');

  // Resettiamo gli eventi della lavagna
  board.off("click");
  // Assegnamo l'evento di tracciatura movimento-palla all'area svg
  board.on('mousedown', function(event) { action_init (event, action_id); });
  board.on('mousemove', function(event) { action_draw (event, action_id); });
  board.on('mouseup', function(event) { action_close (event, action_id); });
}

// Funzione che gestisce i click nell'area SVG per disegnare un'azione
function action_init (event, action_id) {

  var svg_point = get_svg_point(event);
  action_line = document.getElementById(action_id);

  var action_phase = $("input[name='action[phase]']").val();
  var action_type = $("input[name='action[type]']").val();

  action_start = svg_point;
  action_count++;

  // Imposta i punti del segmento
  action_line.setAttribute("x1", action_start.x);
  action_line.setAttribute("y1", action_start.y);
  action_line.setAttribute("x2", action_start.x);
  action_line.setAttribute("y2", action_start.y);
  action_line.setAttribute("stroke", action_phase == "defense" ? "blue" : "red");
  if (action_type == "pass") {
    action_line.setAttribute("stroke-dasharray", "15,15");
  }
}

// Gestisce il mousemove durante la creazione di un'azione
function action_draw (event, action_id) {

  var svg_point = get_svg_point(event);
  action_line = document.getElementById(action_id);

  if (action_count === 1) {
    action_end = svg_point;

    // Imposta il punto finale del segmento
    action_line.setAttribute("x2", action_end.x);
    action_line.setAttribute("y2", action_end.y);
  }
}

// Chiude l'azione
function action_close (event, action_id) {

  var svg_point = get_svg_point(event);
  action_line = document.getElementById(action_id);

  var action_phase = $("input[name='action[phase]']").val();
  var action_type = $("input[name='action[type]']").val();

  if (action_count === 1) {
    action_end = svg_point;

    // Imposta il punto finale del segmento
    action_line.setAttribute("x2", action_end.x);
    action_line.setAttribute("y2", action_end.y);

    action_count = 0;
    action_line, action_start, action_end = null;

    // Resettiamo gli eventi della lavagna
    board.off("click");
    board.off("mousedown");
    board.off("mousemove");
    board.off("mouseup");
    // Assegnamo l'evento di tracciatura movimento-palla all'area svg
    board.on('click', function(event) { action_create (event); });
    // Menù contestuale al click sull'azione
    $("#" + action_id).click(function () { action_menu (event, $(this)); });
    // Menù contestuale mostrato subito
    action_menu (event, $("#" + action_id));
  }
}

// Gestisce il menù contestuale Azione
function action_menu (e, action) {

  if (action_buttons.css("display") == "block") {

    $("#action_handled").val("");
    action_buttons.hide();
  } else {

    action_info = player.attr("id").split("_");
    action_nr = parseInt(player_info[1] - 1);
    action_buttons.css({
      left: parseInt(action.attr("x2")) + board.offset().left,
      top: parseInt(action.attr("y2")) - board.offset().top
    });

    $("#action_handled").val(action_nr);
    action_buttons.show();
  }
  e.stopPropagation();
}

// Continua l'azione creando una polilinea
function action_continue (event, action_id) {
}

// Cancella l'azione
function action_delete (event, action_id) {
  
}

// Funzione per ottenere le coordinate corrette all'interno dell'SVG
function get_svg_point(event) {

  var point = action_svg.createSVGPoint();
  point.x = event.clientX;
  point.y = event.clientY;

  return point.matrixTransform(action_svg.getScreenCTM().inverse());
}
// ACTION end