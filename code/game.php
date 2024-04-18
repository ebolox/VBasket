<?php
  include('logic.php');

  $model = "game";
  $game = get_item_tab();
  $action = $_POST["action"];

  // Lista id, nome delle squadre
  $team_options = get_teams();
  $team_attributes = array("label_icon" => true);
  $team_icon = "<i class=\"bi bi-microsoft-teams text-dark\"></i>";

  // Opzioni Tipo di gara
  $type_options = array(
    array("value" => "championship", "label" => "Campionato"),
    array("value" => "cup", "label" => "Coppa"),
    array("value" => "trophy", "label" => "Torneo"),
    array("value" => "friendly", "label" => "Amichevole"),
    array("value" => "other", "label" => "Altro")
  );

  // Opzioni Casa / Trasferta
  $side_options = array(
    array("value" => "home", "label" => "Casa"),
    array("value" => "guest", "label" => "Trasferta")
  );

  // Pulsanti scheda
  $navbar_btn = $action == "init_item" ? array("print", "save", "delete") : array("print", "delete");
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model, false); ?>
      <div class="form-row">
        <div class="col-md-4 text-center">

          <div class="vb-image">
            <img id="game_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-8">

          <ul class="form-label">
            <li>Competizione</li>
            <li>Turno</li>
            <li>Sede</li>
            <li>Campo</li>
            <li>Squadra</li>
            <li>Avversario</li>
            <li>Data</li>
            <li style="display: none;">Frequenza</li>
            <li style="display: none;">Giorno</li>
            <li>Ora inizio</li>
            <li>Ora fine</li>
            <li>Nome</li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables($action, $model, $game["id"]); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= vb_dropdown ($model, "type", $game["type"], $type_options); ?></li>
            <li><?= vb_text ($model, "round", $game["round"]); ?></li>
            <li><?= vb_dropdown ($model, "side", $game["side"], $side_options); ?></li>
            <li><?= vb_dropdown ($model, "field", $game["field_id"], $field_options); ?></li>
            <li><?= vb_dropdown ($model, "team", $game["team_id"], $team_options); ?></li>
            <li><?= vb_dropdown ($model, "opponent", $game["opponent_id"], $team_options); ?></li>
            <li><?= vb_date ($model, "date_on", format_to_ddmmyyyy($game["date_on"])); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "frequence", $game["frequence"], $frequence_options); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "week_day", $game["week_day"], $week_day_options); ?></li>
            <li><?= vb_text ($model, "time_start", $game["time_start"]); ?></li>
            <li><?= vb_text ($model, "time_stop", $game["time_stop"]); ?></li>
            <li><?= vb_text ($model, "name", $game["name"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/game.js"></script>
