<?php
  include('logic.php');

  global $lang_it;

  // Oggetto presences
  $model = "presences";
  $presences = get_object_tab();

  $activity_type = $presences["activity_type"];
  $activity_id = $presences["activity_id"];

  // Oggetto attività
  $activity = get_activity ($activity_type, $activity_id);

  // Profili partecipanti all'attività
  $actors = get_team_members($activity["team_id"]);

  // Presenze iniziali
  $ids = array(
    "present_ids" => "", 
    "late_ids" => "",
    "missing_ids" => ""
  );
  foreach ($ids as $key => $val) {
    if (isset($presences[$key]) && !empty($presences[$key])) {
      $ids[$key] = str_replace(array('[', ']'), '', $presences[$key]);
    }
  }
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-8 text-center">

          <div class="vb-image">
            <img id="game_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-4 text-right">

          <ul class="form-label">
            <li><?= $lang_it["activity"] ?></li>
            <li><?= $lang_it["type"] ?></li>
            <li><?= $lang_it["team"] ?></li>
            <li><?= $lang_it["presences"] ?></li>
            <li><?= $lang_it["lates"] ?></li>
            <li><?= $lang_it["missings"] ?></li>
            <li><?= $lang_it["date"] ?></li>
            <li><?= $lang_it["time_start"] ?></li>
            <li><?= $lang_it["time_stop"] ?></li>
            <li><?= $lang_it["field"] ?></li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $presences["id"]); ?>
      <?= tab_toolbar ($action); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= $activity_type ?></li>
            <li><?= $activity["type"] ?></li>
            <li><?= $activity["team_name"] ?></li>
            <li><?= $presences["presence_ids"] ?></li>
            <li><?= $presences["late_ids"] ?></li>
            <li><?= $presences["missing_ids"] ?></li>
            <li><?= $activity["date"] ?></li>
            <li><?= $activity["time_start"] ?></li>
            <li><?= $activity["time_stop"] ?></li>
            <li><?= $activity["field"] ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/presence.js"></script>
