<?php
  include('logic.php');
  $rachid = init_pluralizer();

  $model = "report_presences";
  $area = "report";
  //$object = get_object_tab();
  //$action = $_POST["action"];

  $team_attributes = array("btn_color" => "btn-primary");
  $team_opts = array(
    array("value" => "handled f p", "label" => $lang_it["handled f p"]),
    array("value" => "all f p", "label" => $lang_it["all f p"])
  );
  $team_db = get_teams();
  $team_options = $team_opts + $team_db;

  // Liste valore, nome delle opzioni e attributi del pulsante Periodo
  $period_attributes = array("btn_color" => "btn-primary");
  $period_options = array(
    array("value" => "start_year", "label" => $lang_it["from start season"]),
    array("value" => "current_week", "label" => $lang_it["current week"]),
    array("value" => "current_month", "label" => $lang_it["current month"]),
    array("value" => "preview_month", "label" => $lang_it["preview month"])
  );

  $team_id = $team_db[0]["value"];
  $team_name = $team_db[0]["label"];
  $actors = get_team_members($team_id);

  $sql_activities_for_team = $sql_trainings . " WHERE t_team.id=" . $team_id . " AND d.date_on >= '" . date("Y") . "-09-01'";
  $activities = do_ask($sql_activities_for_team);
  $activity_ids = array_column($activities, 'id');

  // Si cerca nella tabella presences una corrispondenza
  $sql_existing_presences = $sql_presences . " WHERE activity_type='training' and activity_id in (" . implode(",", $activity_ids) . ")";
  $result_presences = $db_conn->query($sql_existing_presences);
  $presences = array();
  while ($row = $result_presences->fetch_assoc()) {
    $presences[] = $row;
  }

  // Calcolo totali e assegnazione per ogni partecipante
  foreach ($actors as $i => $actor) {
    if ($actor["role"] == "player") {

      $name_last = isset($actor["name_last"]) ? ((is_mobile() && strlen($actor["name_last"]) > 15) ? substr($actor["name_last"], 0, 7) . "..." : $actor["name_last"]) : "-";
      $name_first = isset($actor["name_first"]) ? ((is_mobile() && strlen($actor["name_first"]) > 15) ? substr($actor["name_first"], 0, 7) . "..." : $actor["name_first"]) : "-";
      $birth_year = isset($actor["birth_date"]) ? "(" . substr($actor["birth_date"], 2, 2) . ")" : "-";
      $actors[$i]["name_full"] = '<sup class="mr-1">' . $birth_year . '</sup>' . $name_last . ' ' . $name_first;

      // Totali presenze personali
      $actors[$i]["presences"] = 0;
      $actors[$i]["lates"] = 0;
      $actors[$i]["missings"] = 0;
      $actors[$i]["carried_out"] = 0;

      foreach ($presences as $presence) {
        $present_ids = (isset($presence["present_ids"]) && !empty($presence["present_ids"])) ? json_decode($presence["present_ids"], true) : array();
        $late_ids = (isset($presence["late_ids"]) && !empty($presence["late_ids"])) ? json_decode($presence["late_ids"], true) : array();
        $missing_ids = (isset($presence["missing_ids"]) && !empty($presence["missing_ids"])) ? json_decode($presence["missing_ids"], true) : array();

        if (isset($present_ids) && !empty($present_ids) && in_array($actor["id"], $present_ids)) {
          $actors[$i]["presences"]++;
          $actors[$i]["carried_out"]++;
        }
        if (isset($late_ids) && !empty($late_ids) && in_array($actor["id"], $late_ids)) {
          $actors[$i]["lates"]++;
          $actors[$i]["carried_out"]++;
        }
        if (isset($missing_ids) && !empty($missing_ids) && in_array($actor["id"], $missing_ids)) {
          $actors[$i]["missings"]++;
        }
      }
    }
  }

  // Totali personali
  // attività effettuate ed in percentuale
  foreach ($actors as $i => $actor) {
    if ($actor["role"] == "player") {

      $actor_presences = $actor["presences"] + $actor["lates"];
      $actors[$i]["presences_percentage"] = ($actor_presences == 0 || $actor["carried_out"] == 0) ? 0 : number_format((($actor_presences / $actor["carried_out"]) * 100), 2);
    } else {

      $actors[$i]["carried_out"] = 0;
      $actors[$i]["presences_percentage"] = 0;
    }
  }
  $actors_percentage = $actors;

  usort($actors_percentage, function($a, $b) {
    return $b['presences_percentage'] <=> $a['presences_percentage'];
  });

  // Totali generali
  $totals = array(
    "scheduled" => count($activities),
    "carried_out" => count($presences),
    "presences" => 0,
    "lates" => 0,
    "missings" => 0,
    "presences_percentage" => 0
  );

  foreach ($actors as $actor) {
    if ($actor["role"] == "player") {
      $totals["presences"] += $actor["presences"] + $actor["lates"];
      $totals["lates"] += $actor["lates"];
      $totals["missings"] += $actor["missings"];
    }
  }
?>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar($area, array("print"), $model) ?>

    <div id="<?= $model ?>_button_bar" class="row vb-navbar btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

      <div class="col text-left">
        <div class="form-group mb-0 ml-3">
          <?= button_dropdown($model, "teams", $lang_it["teams"], "handled f p", $team_options, $team_attributes); ?>
        </div>
        <div class="form-group mb-0 ml-3">
          <?= button_dropdown($model, "period", $lang_it["period"], "start_year", $period_options, $period_attributes); ?>
        </div>
      </div>

    </div>

    <table id="report_presences" class="vb-report mt-4">
      <thead>
        <tr>
          <th><?= $lang_it["scheduled m p"] ?></th>
          <th><?= $lang_it["carried out m p"] ?></th>
          <th><?= $lang_it["ranking"] ?></th>
          <th><?= $lang_it["players"] ?></th>
          <th><?= $lang_it["presences"] ?></th>
          <th><?= $lang_it["lates"] ?></th>
          <th><?= $lang_it["missings"] ?></th>
          <th><?= $lang_it["presences"] ?> in %</th>
          <th><?= $lang_it["ranking"] ?> per %</th>
        </tr>
      </thead>

      <tbody>
<?php
  foreach ($actors as $pos => $actor) {
    if ($actor["role"] == "player") {

      // L'indice dell'elemento corrispondente in $actors_percentage è la posizione in graduatoria ... -1
      $pos_percentage = array_search($actor['id'], array_column($actors_percentage, 'id'));
?>
        <tr data-actor-id="<?= $actor["id"] ?>">
          <td><?= $totals["scheduled"] ?></td>
          <td><?= $actor["carried_out"] ?></td>
          <td><?= ($pos + 1) ?>°</td>
          <td class="text-left"><?= $actor["name_full"] ?></td>
          <td><?= $actor["presences"] ?></td>
          <td><?= $actor["lates"] ?></td>
          <td><?= $actor["missings"] ?></td>
          <td><?= $actor["presences_percentage"] ?></td>
          <td><?= ($pos_percentage + 1) ?>°</td>
        </tr>
<?php
    }
  }
?>
      </tbody>

      <tfoot>
        <tr>
          <th><?= $totals["scheduled"] ?></th>
          <th><?= $totals["carried_out"] ?></th>
          <th></th>
          <th></th>
          <th><?= $totals["presences"] ?></th>
          <th><?= $totals["lates"] ?></th>
          <th><?= $totals["missings"] ?></th>
          <th><?= $totals["presences_percentage"] ?>%</th>
          <th></th>
        </tr>
      </tfoot>
    </table>

  </div>
  <script src="assets/javascript/<?= $model ?>.js"></script>
