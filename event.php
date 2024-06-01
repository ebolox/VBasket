<?php
  include('logic.php');

  $model = "event";
  $object = get_object_tab();
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
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model, false); ?>
      <div class="form-row">
        <div class="col-md-8 text-center">

          <div class="vb-image">
            <img id="game_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-4 text-right">

          <ul class="form-label">
            <li>Nome</li>
            <li>Nome abbreviato</li>
            <li>Tipo</li>
            <li>Campo</li>
            <li>Comune</li>
            <li>Sede</li>
            <li>Data</li>
            <li style="display: none;">Frequenza</li>
            <li style="display: none;">Giorno</li>
            <li>Ora inizio</li>
            <li>Ora fine</li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $object["id"]); ?>
      <?= tab_title_ghost (); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
            <li><?= vb_text ($model, "name_short", $object["name_short"]); ?></li>     
            <li><?= vb_dropdown ($model, "type", $object["type"], $type_options); ?></li>
            <li><?= vb_dropdown ($model, "field", $object["field_id"], $field_options); ?></li>
            <li><?= vb_dropdown ($model, "town", $object["town"], $town_options); ?></li>
            <li><?= vb_text ($model, "place", $object["place"]); ?></li>
            <li><?= vb_date ($model, "date_on", format_to_ddmmyyyy($object["date_on"])); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "frequence", $object["frequence"], $frequence_options); ?></li>
            <li style="display: none;"><?= vb_dropdown ($model, "week_day", $object["week_day"], $week_day_options); ?></li>
            <li><?= vb_text ($model, "time_start", $object["time_start"]); ?></li>
            <li><?= vb_text ($model, "time_stop", $object["time_stop"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/event.js"></script>
