<?php
  include('logic.php');

  account_logged();

  $account_id = get_account_id ();
  if (!empty($account_id)) {
    $account_image = get_image ("account", $account_id, array("main" => false));
    $account_name = compose_account_name ($account_id);
    $ui_icon = "bi bi-calendar-week";
    $ui_value = "ui";
  } else {
    $ui_icon = "bi bi-person-fill";
    $ui_value = "login";
  }

  $model = "eboard";
  $game_id = (isset($_GET) && !empty($_GET["game"])) ? $_GET["game"] : ((isset($_POST) && !empty($_POST["game"])) ? $_POST["game"] : 1);

  $object = get_eboard ($game_id);
  $config = get_eboard_config ($object["id"]);

  // Pulsante Audio: opzioni e attributi
  $audio_attributes = array(
    "label" => "<i class=\"bi bi-music-note-list\"></i>",
    "size" => "btn-sm ",
    "icon_class" => "bi bi-file-music text-success mr-1"
  );
  $audio_options = array(
    array("value" => "audio_1", "label" => "NBA gingle"),
    array("value" => "audio_2", "label" => "Miami Defense")
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

  <link rel="stylesheet" href="assets/stylesheets/ui_standard.css">
  <link rel="stylesheet" href="assets/stylesheets/ui_element.css">
  <link rel="stylesheet" href="assets/stylesheets/eboard.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<?php
  /* Schermo eboard : inizio */

  $teams = get_game_teams ($game_id);

  // Valori
  $ta_id = !empty($teams["a"]["id"]) ? $teams["a"]["id"] : 999999;
  $ta_name = !empty($teams["a"]["name"]) ? $teams["a"]["name"] : "Squadra A";
  $tb_id = !empty($teams["b"]["id"]) ? $teams["b"]["id"] : 999998;
  $tb_name = !empty($teams["b"]["name"]) ? $teams["b"]["name"] : "Squadra B";
  $ta_points = !empty($object["ta_points"]) ? $object["ta_points"] : 0;
  $ta_fouls = !empty($object["ta_fouls"]) ? (int)$object["ta_fouls"] : 0;
  $ta_timeout = !empty($object["ta_timeout"]) ? (int)$object["ta_timeout"] : 0;
  $ta_service = empty($object["service"]) ? true : false;
  $tb_points = !empty($object["tb_points"]) ? $object["tb_points"] : 0;
  $tb_fouls = !empty($object["tb_fouls"]) ? (int)$object["tb_fouls"] : 0;
  $tb_timeout = !empty($object["tb_timeout"]) ? (int)$object["tb_timeout"] : 0;
  $tb_service = empty($object["service"]) ? false : true;
  $quarter = !empty($object["quarter"]) ? $object["quarter"] : 1;
  $timer_primary = !empty($object["timer_primary"]) ? $object["timer_primary"] : "10:00";
  $timer_secondary = !empty($object["timer_secondary"]) ? $object["timer_secondary"] : "24";
  $arrow = empty($object["arrow"]) ? true : false;
?>
  <div class="container">
    <div class="row">

      <div class="col">

        <div id="<?= $model ?>_content" class="container mt-4 font-<?= $config["font"] ?>">
          <input type="hidden" id="<?= $model ?>_id" name="<?= $model ?>[id]" value="<?= $object["id"] ?>" />
          <input type="hidden" id="game_id" name="game[id]" value="<?= $object["game_id"] ?>" />
          <div class="row">

            <div class="col text-center">
              <h2 id="ta_name" class="box-team" data-id="<?= $ta_id ?>"><?= $ta_name ?></h2>
              <h1 id="ta_points" class="box-points red"><?= $ta_points ?></h1>
              <div class="box-fouls">
                <h3 class="d-inline">Falli</h3>
                <span id="ta_fouls" class="red">
                  <?= eboard_dots (5, $ta_fouls); ?>
                </span>
              </div>
            </div>

            <div class="col-2 text-center">
              <div class="box-quarter">
                <h3 class="mt-2 mb-0">Periodo</h3>
                <h2 id="quarter" class="orange"><?= $quarter ?></h1>
              </div>
              <div class="box-arrow">
                <i id="arrow" class="bi bi-arrow-<?= $arrow ? "left" : "right"; ?>-circle green"></i>
              </div>
            </div>
      
            <div class="col text-center">
              <h2 id="tb_name" class="box-team" data-id="<?= $tb_id ?>"><?= $tb_name ?></h2>
              <h1 id="tb_points" class="box-points red"><?= $tb_points ?></h1>
              <div class="box-fouls">
                <h3 class="d-inline">Falli</h3>
                <span id="tb_fouls" class="red">
                  <?= eboard_dots (5, $tb_fouls); ?>
                </span>
              </div>
            </div>
      
          </div>
          <div class="row mt-5">
      
            <div class="col text-center">
              <div class="box-timeout mb-4">
                <h3 class="d-inline">Time-out</h3>
                <span id="ta_timeout" class="green">
                  <?= eboard_dots (2, $ta_timeout); ?>
                </span>
              </div>
              <div class="box-service mb-4">
                <h3 class="d-inline">Servizio</h3>
                <span id="ta_service" class="orange">
                  <i class="bi bi-circle<?= $ta_service ? "-fill" : ""; ?> ml-4"></i>
                </span>
              </div>
            </div>
      
            <div class="col-6 text-center">
              <h1 id="timer_primary" class="box-timer-primary orange"><?= $timer_primary ?></h1>
            </div>
      
            <div class="col text-center">
              <div class="box-timeout mb-4">
                <h3 class="d-inline">Time-out</h3>
                <span id="tb_timeout" class="green">
                  <?= eboard_dots (2, $tb_timeout); ?>
                </span>
              </div>
              <div class="box-service mb-4">
                <h3 class="d-inline">Servizio</h3>
                <span id="tb_service" class="orange">
                  <i class="bi bi-circle<?= $tb_service ? "-fill" : ""; ?> ml-4"></i>
                </span>
              </div>
            </div>
      
          </div>
        </div>
        <div id="<?= $model ?>_secondary" class="box-timer-secondary font-<?= $config["font"] ?><?= $object["timer_secondary"] <= 5 ? " bg-red" : " bg-green" ?>">
          <h1 id="timer_secondary"><?= $timer_secondary ?></h1>
        </div>
<?php
  /* Schermo eboard : fine */

  /* Toolbar eboard : inizio */
?>
        <div id="<?= $model ?>_toolbar" class="container mt-2 vb-navbar ">
          <div class="row">
      
            <div class="col">
              <div class="form-group mb-0">
                <?= button_icon ($ui_icon, "primary", array("id" => "btn_ui", "value" => $ui_value, "size" => "btn-sm", "margin" => "ml-2 mr-2")); ?>
              </div>
              <div class="form-group mb-0">
                <?= button_icon ("bi bi-gear-fill", "primary", array("id" => "btn_config", "size" => "btn-sm", "margin" => "ml-2 mr-2")); ?>
              </div>
              <div class="form-group mb-0">
                <?= button_icon ("bi bi-music-note-beamed", "primary", array("id" => "btn_effects", "size" => "btn-sm", "margin" => "ml-2 mr-2")); ?>
              </div>
              <div class="form-group mb-0 ml-3">
                <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons" id="<?= $model ?>_sign">
                  <label class="btn btn-success active">
                    <input type="radio" name="option" data-value="+" autocomplete="off" checked><i class="bi bi-plus"></i>
                  </label>
                  <label class="btn btn-success">
                    <input type="radio" name="option" data-value="-" autocomplete="off"><i class="bi bi-dash"></i>
                  </label>
                </div>
              </div>
              <div class="form-group mb-0 ml-4 float-right">
                <button type="button" id="<?= $model ?>_reset" class="btn btn-primary btn-sm ml-2">Inizio gara</button>
              </div>
              <div class="form-group mb-0 float-right">
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
                  <?= button_icon ("bi bi-pause-fill", "primary", array("id" => $model . "_timer_pause", "value" => "pause", "size" => "btn-sm", "margin" => "ml-1")); ?>
                  <?= button_icon ("bi bi-play-fill", "primary", array("id" => $model . "_timer_play", "value" => "play", "size" => "btn-sm", "margin" => "ml-1")); ?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
<?php
  /* Toolbar eboard : fine */
?>
  <?= modal_base('team'); ?>
<?php
  /* Sidebar Configurazione : inizio */

  $font_attributes = array("btn_size" => "small");
  $font_options = array(
    array("value" => "font-digital-7", "label" => "Digital-7"),
    array("value" => "font-led-dot-matrix", "label" => "Led dot"),
    array("value" => "font-scoreboard", "label" => "Scoreboard")
  );

  $settings = [
    ["tag" => "timer_primary",   "label" => "Tempo gara",   "checked" => $config["timer_primary"]],
    ["tag" => "timer_secondary", "label" => "Tempo possesso", "checked" => $config["timer_secondary"]],
    ["tag" => "team",    "label" => "Squadre",   "checked" => $config["team"]],
    ["tag" => "points",  "label" => "Punteggio", "checked" => $config["points"]],
    ["tag" => "quarter", "label" => "Periodo",   "checked" => $config["quarter"]],
    ["tag" => "fouls",   "label" => "Falli",     "checked" => $config["fouls"]],
    ["tag" => "timeout", "label" => "Time-out",  "checked" => $config["timeout"]],
    ["tag" => "arrow",   "label" => "Freccia",   "checked" => $config["arrow"]], 
    ["tag" => "service", "label" => "Servizio",  "checked" => $config["service"]]
  ];
?>
  <nav id="<?= $model ?>_sidebar" class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <div id="eboard_config">
        <h5><i class="bi bi-gear-fill mr-2"></i>Configurazione</h5>
        <ul class="nav flex-column">
          <li class="nav-item">
            <div class="form-label float-right">Caratteri</div>
            <div class="form-data"><?= vb_dropdown ("eboard_config", "font", "font-" . $config["font"], $font_options, $font_attributes); ?></div>
          </li>
          <li class="nav-item">
            <div class="form-label float-right">Componenti</div>
            <div class="form-data">
              <ul>
<?php
  foreach ($settings as $set) {
?>
                <li class="btn-boolean" data-tag="<?= $set["tag"]; ?>">
                  <?= icon_selected ($set["checked"]); ?>
                  <span><?= $set["label"]; ?></span>
                  <input type="hidden" name="eboard_config[<?= $set["tag"]; ?>]" value="<?= $set["checked"] ?>" />
                </li>
<?php
  }
?>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <div id="eboard_effects">
        <h5><i class="bi bi-music-note-beamed mr-2"></i>Audio e Video</h5>
        <div class="mt-3">
          <div>
            <button class="btn btn-sm btn-primary btn-sound" value="audio_1">Gingle NBA</button>
            <audio id="player_audio_1" class="vb-player" src="audio/nba_sound.ogg"></audio>
          </div>
          <div class="mt-2">
            <button class="btn btn-sm btn-primary btn-sound" value="audio_2">Coro Defense</button>
            <audio id="player_audio_2" class="vb-player" src="audio/miami_defense.ogg"></audio>
          </div>
          <div class="mt-2">
            <button class="btn btn-sm btn-primary btn-sound" value="audio_3">Sirena</button>
            <audio id="player_audio_3" class="vb-player" src="audio/long_buzzer.ogg"></audio>
          </div>
      </div>
    </div>
  </nav>

  <script src="assets/javascript/ui.js"></script>
  <script src="assets/javascript/eboard.js"></script>
  <script>
    // Componenti nascosti
<?php
  foreach ($settings as $set) {
    if (empty($set["checked"])) {
?>
    $(".box-<?= $set["tag"]; ?>").hide();
<?php
    }
  }
?>
  </script>

  <style>

  </style>

</body>
</html>
