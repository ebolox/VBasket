<?php
  include_once("logic.php");
  
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
  <div class="vb-content vb-list mt-2">
    <div class="vb-tab-title text-uppercase text-center color-sea underlined pb-1 mb-3">
      <i class="bi bi-list-check mr-2"></i><?= $lang_it[$model . "_" . $activity_type] ?>
    </div>

    <div class="row">

      <!-- Dati presences -->
      <input type="hidden" id="<?= $model ?>_id" name="<?= $model ?>[id]" value="<?= $presences["id"] ?>" />
      <input type="hidden" id="<?= $model ?>_late_ids" name="<?= $model ?>[late_ids]" value="<?= $ids["late_ids"] ?>" />
      <input type="hidden" id="<?= $model ?>_missing_ids" name="<?= $model ?>[missing_ids]" value="<?= $ids["missing_ids"] ?>" />
      <input type="hidden" id="<?= $model ?>_present_ids" name="<?= $model ?>[present_ids]" value="<?= $ids["present_ids"] ?>" />

      <!-- Dati attività -->
      <input type="hidden" id="<?= $model ?>_activity_type" name="<?= $model ?>[activity_type]" value="<?= $activity_type ?>" />
      <input type="hidden" id="<?= $model ?>_activity_id" name="<?= $model ?>[activity_id]" value="<?= $activity_id ?>" />
      <input type="hidden" id="<?= $model ?>_team_id" name="<?= $model ?>[team_id]" value="<?= $activity["team_id"] ?>" />

    </div>
    <div id="data_presences" class="row">
<?php
  if (is_mobile()) {
?>
      <ul>
        <li>
          <i class="bi bi-calendar-event ml-2 mr-1"></i>
          <span><?= $activity["date_on"] ?></span>
        </li>
        <li>
          <i class="bi bi-clock ml-2 mr-1"></i>
          <span><?= $activity["time_start"] ?></span>
        </li>
        <li>
          <i class="bi bi-clock-history ml-2 mr-1"></i>
          <span><?= $activity["time_stop"] ?></span>
        </li>
      </ul>
      <ul>
        <li>
          <i class="bi bi-microsoft-teams ml-2 mr-1"></i>
          <span><?= $activity["team"] ?></span>
        </li>
        <li>
          <i class="bi bi-clipboard-data ml-2 mr-1"></i>
          <span><?= strtolower($lang_it[$activity["type"]]) ?></span>
        </li>
        <li>
          <i class="bi bi-geo-alt ml-2 mr-1"></i>
          <span><?= $activity["field"] ?></span>
        </li>
      </ul>
<?php
  } else {
?>
      <div class="col-1" style="min-width: 140px;">
        <i class="bi bi-calendar-event ml-2 mr-1"></i>
        <span><?= $activity["date_on"] ?></span>
      </div>

      <div class="col-1">
        <i class="bi bi-clock ml-2 mr-1"></i>
        <span><?= $activity["time_start"] ?></span>
      </div>

      <div class="col-1">
        <i class="bi bi-clock-history ml-2 mr-1"></i>
        <span><?= $activity["time_stop"] ?></span>
      </div>

      <div class="col-2">
        <i class="bi bi-clipboard-data ml-2 mr-1"></i>
        <span><?= strtolower($lang_it[$activity["type"]]) ?></span>
      </div>

      <div class="col-3">
        <i class="bi bi-microsoft-teams ml-2 mr-1"></i>
        <span><?= $activity["team"] ?></span>
      </div>

      <div class="col">
        <i class="bi bi-geo-alt ml-2 mr-1"></i>
        <span><?= $activity["field"] ?></span>
      </div>
<?php
  }
?>

    </div>
    <table id="list_presences" class="vb-report mt-4">
      <thead>
        <tr>
          <th class="presence name-last"><?= $lang_it["name-last"] ?></th>
          <?php if (!is_mobile()) { ?>
          <th class="presence name-first"><?= $lang_it["name-first"] ?></th>
          <?php } ?>
          <th class="presence present"><?= $lang_it["present"] ?></th>
          <th class="presence late"><?= $lang_it["late"] ?></th>
          <th class="presence missing"><?= $lang_it["missing"] ?></th>
        </tr>
      </thead>

      <tbody>
<?php
  foreach ($actors as $actor) {
    if ($actor["role"] == "player") {
      $name_last = isset($actor["name_last"]) ? ((is_mobile() && strlen($actor["name_last"]) > 15) ? substr($actor["name_last"], 0, 7) . "..." : $actor["name_last"]) : "-";
      $name_first = isset($actor["name_first"]) ? ((is_mobile() && strlen($actor["name_first"]) > 15) ? substr($actor["name_first"], 0, 7) . "..." : $actor["name_first"]) : "-";
      $birth_year = isset($actor["birth_date"]) ? "(" . substr($actor["birth_date"], 2, 2) . ")" : "-";


      $btn_icon = icon("bi bi-record-circle", ["is_clickable" => true]);
?>
        <tr data-actor-id="<?= $actor["id"] ?>">
          <?php if (is_mobile()) { ?>
          <td class="presence name-last"><sup class="mr-1"><?= $birth_year ?></sup><?= $name_last ?> <?= $name_first ?></td>
          <?php } else { ?>
          <td class="presence name-last"><sup class="mr-1"><?= $birth_year ?></sup><?= $name_last ?></td>
          <td class="presence name-first"><?= $name_first ?></td>
          <?php } ?>
          <td class="btn-off presence present"><?= $btn_icon ?></td>
          <td class="btn-off presence late"><?= $btn_icon ?></td>
          <td class="btn-off presence missing"><?= $btn_icon ?></td>
        </tr>
<?php
    }
  }
?>
      </tbody>

      <tfoot>
        <tr>
          <th class="presence"<?= is_mobile() ? "" : " colspan=2" ?>><?= $lang_it["total"] ?> <?= strtolower($lang_it["players"]) ?>: <?= count($actors) ?></th>
          <th class="presence present"></th>
          <th class="presence late"></th>
          <th class="presence missing"></th>
        </tr>
      </tfoot>
    </table>

  </div>
  <script src="assets/javascript/<?= $model ?>.js"></script>
