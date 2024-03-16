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
?>
  <div id="game_form" class="vb-content vb-form mt-4">

    <?= contextual_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $game["id"]); ?>
      <div class="form-row">
        <div class="col-md-5 text-center">

          <div class="vb-image">
            <img id="game_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-7">

          <?= button_select ($model, "type", "Tipo", $game["type"], $type_options); ?>
          <?= field_text ($model, "round", "Turno", $game["round"]); ?>
          <?= button_select ($model, "field", "Campo", $game["field"], $field_options); ?>
          <?= button_select ($model, "side", "Casa/Traferta", $game["side"], $side_options); ?>
          <?= button_dropdown ($model, "team", $team_icon, $game["team"], $team_options, $team_attributes); ?>
          <?= button_dropdown ($model, "opponent", $team_icon, $game["opponent"], $team_options, $team_attributes); ?>

          <?= button_dropdown ($model, "frequence", "Frequenza", $game["frequence"], $frequence_options, $frequence_attributes); ?>
          <?= button_dropdown ($model, "week_day", "Giorno", $game["week_day"], $week_day_options, $week_day_attributes); ?>
          <?= field_date ($model, "date_on", "Data", $game["date_on"], array("icon" => "fas fa-calendar")); ?>
          <?= field_text ($model, "time_start", "Inizio", $game["time_start"]); ?>
          <?= field_text ($model, "time_stop", "Fine", $game["time_stop"]); ?>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/game.js"></script>
