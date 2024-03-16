<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include_once("logic.php");
  }

  $model = "calendar";

  // Liste valore, nome delle opzioni e attributi del pulsante Campo
  $field_attributes = array("btn_color" => "btn-primary");
  $field_options = array(
    array("value" => "all", "label" => "Tutti"),
    array("value" => "a", "label" => "Altobelli"),
    array("value" => "b", "label" => "Bucci Pieraccini")
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Orario
  $hour_attributes = array("btn_color" => "btn-primary");
  $hour_options = array(
    array("value" => "sport", "label" => "Sportivo"),
    array("value" => "morning", "label" => "Mattina"),
    array("value" => "all", "label" => "Tutto")
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Attività
  $activity_attributes = array("btn_color" => "btn-primary");
  $activity_options = array(
    array("value" => "all", "label" => "Tutte"),
    array("value" => "games", "label" => "Solo partite"),
    array("value" => "trainings", "label" => "Solo allenamenti"),
    array("value" => "events", "label" => "Solo eventi")
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Squadre
  $team_attributes = array("btn_color" => "btn-primary");
  $team_opts = array(
    array("value" => "handled", "label" => "Gestite"),
    array("value" => "all", "label" => "Tutte")
  );
  $team_db = get_teams();
  $team_options = $team_opts + $team_db;
?>
  <div id="<?= $model ?>_button_bar" class="row vb-navbar btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

    <div class="col"></div>
    <div class="col-6 text-left">
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "fields", "Campo", "all", $field_options, $field_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "hours", "Orario", "sport", $hour_options, $hour_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "teams", "Squadre", "handled", $team_options, $team_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "activities", "Attività", "all", $activity_options, $activity_attributes); ?>
      </div>
    </div>
    <div class="col"></div>

  </div>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= contextual_navbar($model, array("print", "new"), false); ?>
    <input type="hidden" name="activity[type]" value />
    <input type="hidden" name="activity[id]" value />

    <div id="<?= $model ?>_board">

      <table border=0>
        <thead>
          <tr>
            <th colspan=2></th>
<?php
  $week_days = get_week();

  foreach ($week_days as $i => $day) {
?>
            <th class="cal-day-<?= $i ?>" colspan=2><?= $day ?></th>
<?php
  }
?>
          </tr>
          <tr>
            <th colspan=2></th>
<?php
  for ($i = 0; $i <= 6; $i++) {
?>
            <th class="cell-limit" colspan=2></th>
<?php
  }
?>
          </tr>
        </thead>
        <tbody>
<?php
  for ($i = 10; $i < 24; $i++) {
    
    $hour = sprintf('%02d', $i);
    $shown = $i < 16 ? " style=\"display: none;\"" : "";
?>
          <tr id="hour_<?= $i ?>"<?= $shown ?>>
            <td><span class="hours"><?= $i ?></span><span class="minutes">00</span></td>
						<td class="cell-limit"></td>
<?php
    foreach ($week_days as $index => $day) {
?>
            <td id="field_1_<?= ($index + 1) ?>_<?= $i ?>" class="field-1"></td>
            <td id="field_2_<?= ($index + 1) ?>_<?= $i ?>" class="field-2"></td>
<?php
    }
?>
          </tr>
<?php
  }
?>
        </tbody>
      </table>

    </div>
		<div id="activity_board"></div>
  </div>
  <script src="assets/javascript/calendar.js"></script>