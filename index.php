<?php
  //include('db_connection.php');
  //include('logic.php');

  // Crea un campo con etichetta e button dropdown
  function button_dropdown ($model, $param, $label, $value = "", $options = [], $attributes = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $team_name = "";
    if (empty($value)) {
      $value = "";
    } else {
      if (!empty($attributes["select_all"])) {
        $team_name = $attributes["select_all"];
      } else {
        foreach($options as $opt) {
          if ($opt["value"] == $value) { $team_name = $opt["label"]; }
        }
      }
    }

    // Classe per versione con icona come etichetta
    $label_class = "";
    if (!empty($attributes["label_icon"])) { $label_class = " vb-btn-icon"; }

    // Colore pulsante
    $btn_color = "btn-success";
    if (!empty($attributes["btn_color"])) { $btn_color = "btn-primary"; }

    // Dimensioni pulsante
    $btn_size = "btn-sm ";
    if (!empty($attributes["btn_size"])) { $btn_size = $attributes[" btn_size"] == "large" ? "btn-lg " : ""; }

    $code = '<div id="btn_' . $field_id . '" class="input-group vb-btn-dropdown' . $label_class . '">';
    $code .= '<input type="hidden" name="' . $field_name . '" value="' . $value . '" />';
    $code .= '<button class="btn ' . $btn_size . 'btn-secondary text-white" disabled>' . $label . '</button>';
    $code .= '<div class="btn-group ' . str_replace("btn", "btn-group", $btn_size) . 'btn-group-append">';
    $code .= '<button id="' . $field_id . '" class="btn ' . $btn_size . $btn_color . ' text-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $team_name . '</button>';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_name . '">';
    $code .= '<a class="dropdown-item" href="#" data-value=""></a>';
    foreach ($options as $opt) {
      $code .= '<a class="dropdown-item" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . '</a>';
    }
    if (!empty($attributes["select_all"])) {
      $code .= '<div class="dropdown-divider"></div>';
      $code .= '<a class="dropdown-item" href="#" data-value="all">' . $attributes["select_all"] . '</a>';
    }
    $code .= '</div></div></div>';

    return $code;
  }

  function button_icon ($icon_class, $bg_color, $options) {

    $btn_id = (!empty($options) && !empty($options["btn_id"])) ? $options["btn_id"] : "";
    $btn_value = (!empty($options) && !empty($options["btn_value"])) ? $options["btn_value"] : "";
    $btn_class = (!empty($options) && !empty($options["btn_class"])) ? ' ' . $options["btn_class"] : "";
    $btn_margin = (!empty($options) && !empty($options["btn_margin"])) ? ' ' . $options["btn_margin"] : "";
    $btn_hidden = (!empty($options) && !empty($options["invisible"])) ? ' invisible' : "";
    $btn_disabled = (!empty($options) && !empty($options["disabled"])) ? ' disabled' : "";

    $code = '<button type="button" id="' . $btn_id . '" class="btn btn-outline-' . $bg_color . ' btn-icon btn-circle border-0' . $btn_margin . $btn_class . $btn_hidden . '" data-value="' . $btn_value . '"' . $btn_disabled . '>';
    $code .= '<i class="' . $icon_class . '"></i>';
    $code .= '</button>';

    return $code;
  }

  $model = "eboard";
  $timer = "20:00";
  $team_a = "Squadra A";
  $team_b = "Squadra B";

  // Liste valore, nome delle opzioni e attributi del pulsante Font
  $font_attributes = array("btn_color" => "btn-primary");
  $font_options = array(
    array("value" => "font-digital-7", "label" => "Digital-7"),
    array("value" => "font-led-dot-matrix", "label" => "Led dot"),
    array("value" => "font-scoreboard", "label" => "Scoreboard")
  );
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">

  <title>Valdicornia Basket</title>

  <link rel="shortcut icon" type="image/png" href="assets/images/logo_big.jpg">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="ext/fontawesome-free-6.5.1-web/css/fontawesome.css">

  <link rel="stylesheet" href="assets/stylesheets/ui.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

  <div class="container">
    <div class="row">

      <div class="col">

        <div id="<?= $model ?>_content" class="container mt-4 font-scoreboard">
          <div class="row">
      
            <div class="col text-center">
              <h2 id="t1_name"><?= $team_a ?></h2>
              <h1 id="t1_score" class="red">0</h1>
              <div>
                <h3 class="d-inline">Falli</h3>
                <span id="t1_foul" class="red">
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                </span>
              </div>
            </div>
      
            <div class="col-2 text-center">
              <i id="contested_ball" class="bi bi-arrow-left-circle green"></i>
            </div>
      
            <div class="col text-center">
              <h2 id="t2_name"><?= $team_b ?></h2>
              <h1 id="t2_score" class="red">0</h1>
              <div>
                <h3 class="d-inline">Falli</h3>
                <span id="t2_foul" class="red">
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                  <i class="bi bi-circle ml-4"></i>
                </span>
              </div>
            </div>
      
          </div>
          <div class="row mt-5">
      
            <div class="col text-center">
              <h3 class="d-inline">Time-out</h3>
              <span id="t1_timeout" class="green">
                <i class="bi bi-circle ml-4"></i>
                <i class="bi bi-circle ml-4"></i>
              </span>
            </div>
      
            <div class="col-6 text-center">
              <h1 id="timer" class="orange"><?= $timer ?></h1>
            </div>
      
            <div class="col text-center">
              <h3 class="d-inline">Time-out</h3>
              <span id="t2_timeout" class="green">
                <i class="bi bi-circle ml-4"></i>
                <i class="bi bi-circle ml-4"></i>
              </span>
            </div>
      
          </div>
        </div>

        <div id="<?= $model ?>_toolbar" class="container mt-2 vb-navbar ">
          <div class="row">
      
            <div class="col">
              <div class="form-group mb-0">
                <?= button_dropdown($model, "font", "Tabellone", "font-scoreboard", $font_options, $font_attributes); ?>
              </div>
              <div class="form-group mb-0 ml-3">
                <div class="input-group input-group-sm vb-field-text" id="<?= $model ?>_time_handler">
                  <div class="input-group-prepend" style="width: 60px;">
                    <span class="input-group-text text-white">Tempo</span>
                  </div>
                  <input type="text" class="form-control text-center h-32" id="<?= $model ?>_timer_min" name="<?= $model ?>_timer[min]" aria-describedby="<?= $model ?>_time_handler" size=3 placeholder="Min" value="20" />
                  <input type="text" class="form-control text-center h-32" id="<?= $model ?>_timer_sec" name="<?= $model ?>_timer[sec]" aria-describedby="<?= $model ?>_time_handler" size=3 placeholder="Sec" value="00" />
                  <div class="input-group-append w-32">
                    <button class="btn btn-sm btn-primary" type="button" id="<?= $model ?>_timer_reset">
                      <i class="bi bi-bootstrap-reboot"></i>
                    </button>
                  </div>
                  <?= button_icon ("bi bi-pause-fill", "primary", array("btn_id" => $model . "_timer_pause", "btn_value" => "pause", "btn_margin" => "ml-1")); ?>
                  <?= button_icon ("bi bi-play-fill", "primary", array("btn_id" => $model . "_timer_play", "btn_value" => "play", "btn_margin" => "ml-1")); ?>
                </div>
              </div>
              <div class="form-group mb-0 ml-4">
                <button class="btn btn-sm btn-primary btn-sound" data-value="NBA_Sound.mp3"><i class="bi bi-music-note-beamed mr-2"></i>NBA</button>
                <button class="btn btn-sm btn-primary btn-sound" data-value="NBA_Defense_Chant.mp3"><i class="bi bi-music-note-beamed mr-2"></i>Defense</button>
                <audio id="<?= $model ?>_player_audio" src=""></audio>
              </div>
              <div class="form-group mb-0 float-right">
                <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons" id="<?= $model ?>_mode">
                  <label class="btn btn-primary active">
                    <input type="radio" name="option" data-value="+" autocomplete="off" checked>Aumentare
                  </label>
                  <label class="btn btn-primary">
                    <input type="radio" name="option" data-value="-" autocomplete="off">Diminuire
                  </label>
                </div>

                <button type="button" id="<?= $model ?>_reset" class="btn btn-primary btn-sm ml-2">Inizio gara</button>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="assets/javascript/ui.js"></script>
  <script>
    $(document).ready(function() {

      // Chiama la funzione countdown all'avvio del documento
      // countdown();

      // Eventi del tabellone
      $("#timer").click( function () { handle_countdown (); });
      $("#t1_score, #t2_score").click( function () { handle_score ($(this)); });
      $("#t1_foul, #t2_foul, #t1_timeout, #t2_timeout").click( function () { handle_dot ($(this)); });
      $("#contested_ball").click( function () { handle_arrow (); });

      /* Toolbar */
      // Selettore Stile font
      btn_font = $("#btn_<?= $model ?>_font").find(".dropdown-menu > .dropdown-item");
      btn_font.click( function () {
        set_dropdown ("<?= $model ?>", "font", $(this), btn_font);
        $("#<?= $model ?>_content").attr("class", "container mt-4 " + $(this).data("value"));
      });

      // Pulsanti gestione Tempo
      $("#<?= $model ?>_timer_reset").click( function () { set_timer (); });
      $("#<?= $model ?>_timer_play").click( function () { handle_countdown (); });
      $("#<?= $model ?>_timer_pause").click( function () { handle_countdown (true); });

      // Effetto click su elementi "contabili"
      $("#<?= $model ?>_mode label.btn").click( function () { handle_mode ($(this)); });

      // Pulsante Reset per inizio gara
      $("#<?= $model ?>_reset").click( function () {

        // Timer
        handle_countdown (true);
        set_timer ();

        // Punteggi
        $("#t1_score, #t2_score").text("0");

        // Falli e Time-out
        $("#t1_foul, #t2_foul, #t1_timeout, #t2_timeout").find("i").attr("class", "bi bi-circle ml-4");
      });
    });

    var sign = "+";
    var timer_id;
    var timer_on = true;

    // Funzione per diminuire il tempo di un secondo alla volta
    function countdown () {

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
        timer_id = setTimeout(countdown, 1000);
      } else {
        // Se il tempo è scaduto, esegui un'azione aggiuntiva
        alert("Tempo scaduto!");
      }
    }

    // Cambia il senso della freccia Palla contesa
    function handle_arrow () {

      arrow = $("#contested_ball");
      icon_left = "bi-arrow-left-circle";
      icon_right = "bi-arrow-right-circle";

      if (arrow.attr("class").match("left")) {
        arrow.removeClass(icon_left).addClass(icon_right);
      } else {
        arrow.removeClass(icon_right).addClass(icon_left);
      }
    }

    // Interrompe il countdown
    function handle_countdown (force_pause = false) {

      if (timer_on || force_pause) {
        clearTimeout(timer_id);
        timer_on = false;
      } else {
        countdown();
        timer_on = true;
      }
    }

    function handle_dot (dots) {

      if (sign == "+") {
        dot_to_handle = dots.find("i.bi-circle").first();
        dot_to_handle.removeClass("bi-circle").addClass("bi-circle-fill");
      } else {
        dots_to_handle = dots.find("i.bi-circle-fill").last();
        dots_to_handle.removeClass("bi-circle-fill").addClass("bi-circle");
      }
    }

    function handle_mode (btn) {

      $("#<?= $model ?>_mode label.btn").removeClass("active");
      $("#<?= $model ?>_mode label.btn > input").removeAttr("checked");

      btn.addClass("active");
      btn.find("input").attr("checked", "checked");

      // Si assegna il segno alla variabile
      sign = btn.find("input:checked").data("value");
    }

    function handle_score (score) {

      score_now = parseInt(score.text());
      score_new = sign == "+" ? (score_now + 1) : (score_now - 1);

      score.text(score_new);
    }

    // Aggiorna il tempo sulla base di minuti e secondi impostati
    function set_timer () {
      min = $("#<?= $model ?>_timer_min").val();
      sec = $("#<?= $model ?>_timer_sec").val();
      $("#timer").text(min + ":" + sec);
    }

    $('.btn-sound').click( function () {
      var audio_player = document.getElementById('<?= $model ?>_player_audio');
      var audio_file = $(this).data("value");

      audio_player.src = "audio/" + audio_file;
      audio_player.paused ?
        audio_player.play() :
        audio_player.pause();
    });
  </script>

  <style>
    .font-digital-7 {
      font-family: "Digital-7", Arial, sans-serif;
    }
    .font-led-dot-matrix {
      font-family: "Led dot-matrix", Arial, sans-serif;
    }
    .font-scoreboard {
      font-family: "Scoreboard", Arial, sans-serif;
    }

    h1 {
      font-size: 10rem;
    }

    h2 {
      font-size: 3rem;
    }

    #eboard_content {
      color: white;
      background-color: black;
      overflow-x: hidden;
    }

    #contested_ball {
      position: relative;
      top: 100px;
      font-size: 6rem;
    }

    .green { color: #3dca5e; }
    .orange { color: #ffc107; }
    .red { color: #f9051c; }

    .h-32 {
      height: 32px !important;
    }
    .w-32 {
      width: 32px !important;
    }

    .input-group > .input-group-append > .btn.btn-primary {
      border-color: #ced4da;
      border-top-right-radius: .2rem;
      border-bottom-right-radius: .2rem;
    }
    .input-group > .input-group-prepend > .input-group-text {
      background-color: var(--bluegrey);
      border: 0;
      border-radius: 0;
      opacity: .65;
    }

    #t1_score, #t2_score,
    #t1_foul, #t2_foul,
    #t1_timeout, #t2_timeout,
    #timer, #contested_ball {
      cursor: pointer;
    }
  </style>

</body>
</html>
