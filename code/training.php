<?php
  include('logic.php');

  $model = "training";
  $training = get_item_tab();
  $action = $_POST["action"];

  // Lista id, nome delle squadre
  $team_options = get_teams();
  $team_attributes = array("label_icon" => true);
  $team_icon = "<i class=\"bi bi-microsoft-teams text-dark\"></i>";

  // Opzioni Tipo di allenamento
  $type_options = array(
    array("value" => "technique", "label" => "Tecnico", "icon_class" => "dribbble"),
    array("value" => "athletic", "label" => "Atletico", "icon_class" => "stopwatch")
  );
?>
  <div id="training_form" class="vb-content vb-form mt-4">

    <?= contextual_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $training["id"]); ?>
      <div class="form-row">
        <div class="col-md-5 text-center">

          <div class="vb-image">
            <img id="training_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-7">

          <?= field_text ($model, "name", "Nome", $training["name"]); ?>
          <?= button_select ($model, "type", "Tipo", $training["type"], $type_options); ?>
          <?= button_dropdown ($model, "team", $team_icon, $training["team"], $team_options, $team_attributes); ?>
          <?= button_select ($model, "field", "Campo", $training["field"], $field_options); ?>
          <?= button_dropdown ($model, "frequence", "Frequenza", $training["frequence"], $frequence_options, $frequence_attributes); ?>
          <?= button_dropdown ($model, "week_day", "Giorno", $training["week_day"], $week_day_options, $week_day_attributes); ?>
          <?= field_date ($model, "date_on", "Data", $training["date_on"], array("icon" => "fas fa-calendar")); ?>
          <?= field_text ($model, "time_start", "Inizio", $training["time_start"]); ?>
          <?= field_text ($model, "time_stop", "Fine", $training["time_stop"]); ?>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/training.js"></script>
