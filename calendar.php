<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include_once("logic.php");
  }

  $model = "calendar";

  // Liste valore, nome delle opzioni e attributi del pulsante Campo
  $field_attributes = array("btn_color" => "btn-primary");
  $field_options = array(
    array("value" => "all m p", "label" => $lang_it["all m p"]),
    array("value" => "a", "label" => "Altobelli"),
    array("value" => "b", "label" => "Bucci Pieraccini")
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Orario
  $hour_attributes = array("btn_color" => "btn-primary");
  $hour_options = array(
    array("value" => "sport", "label" => $lang_it["sport agg m s"]),
    array("value" => "morning", "label" => $lang_it["morning"]),
    array("value" => "all m s", "label" => $lang_it["all m s"])
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Attività
  $activity_attributes = array("btn_color" => "btn-primary");
  $activity_options = array(
    array("value" => "all m f", "label" => $lang_it["all f s"]),
    array("value" => "games", "label" => $lang_it["only games"]),
    array("value" => "trainings", "label" => $lang_it["only trainings"]),
    array("value" => "events", "label" => $lang_it["only events"])
  );

  // Liste valore, nome delle opzioni e attributi del pulsante Squadre
  $team_attributes = array("btn_color" => "btn-primary");
  $team_opts = array(
    array("value" => "handled f p", "label" => $lang_it["handled f p"]),
    array("value" => "all f p", "label" => $lang_it["all f p"])
  );
  $team_db = get_teams();
  $team_options = $team_opts + $team_db;
?>
  <div id="<?= $model ?>_button_bar" class="row vb-navbar btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

    <div class="col"></div>
    <div class="col-10 text-left">
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "fields", $lang_it["field"], "all m p", $field_options, $field_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "hours", $lang_it["time"], "sport add m s", $hour_options, $hour_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "teams", $lang_it["teams"], "handled f p", $team_options, $team_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "activities", $lang_it["activity"], "all f p", $activity_options, $activity_attributes); ?>
      </div>
    </div>
    <div class="col"></div>

  </div>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar ($model, array("print", "new"), false); ?>
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
    $shown = $i < 15 ? " style=\"display: none;\"" : "";
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