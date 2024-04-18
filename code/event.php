<?php
  include('logic.php');

  $model = "event";
  $event = get_item_tab();
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

  $town_options = get_towns();
?>
  <div id="event_form" class="vb-content vb-tab mt-4">

    <?= form_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $event["id"]); ?>
      <div class="form-row">
        <div class="col-md-4 text-center">

          <div class="vb-image">
            <img id="event_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-8">

          <ul class="form-label">
            <li>Nome</li>
            <li>Nome abbreviato</li>
            <li>Tipo</li>
            <li>Campo</li>
            <li>Comune</li>
            <li>Luogo</li>
            <li>Data</li>
            <li style="display: none;">Frequenza</li>
            <li style="display: none;">Giorno</li>
            <li>Ora inizio</li>
            <li>Ora fine</li>
          </ul>
          <ul class="form-data">
            <li><?= vb_text ($model, "name", $event["name"]); ?></li>
            <li><?= vb_text ($model, "name_short", $event["name_short"]); ?></li>
            <li><?= vb_dropdown ($model, "type", $event["type"], $type_options); ?></li>
            <li><?= vb_dropdown ($model, "field", $event["field_id"], $field_options); ?></li>
            <li><?= vb_dropdown ($model, "town", $event["town"], $town_options); ?></li>
            <li><?= vb_text ($model, "place", $event["place"]); ?></li>
            <li><?= vb_date ($model, "date_on", format_to_ddmmyyyy($event["date_on"])); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "frequence", $event["frequence"], $frequence_options); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "week_day", $event["week_day"], $week_day_options); ?></li>
            <li><?= vb_text ($model, "time_start", $event["time_start"]); ?></li>
            <li><?= vb_text ($model, "time_stop", $event["time_stop"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/event.js"></script>
