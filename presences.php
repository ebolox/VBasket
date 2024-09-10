<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include_once("logic.php");
  }
  global $lang_it;

  $model = "presence";
  $object = get_object_tab();
  $object_type = $object["presences"]["activity_type"];
  $object_id = $object["presences"]["activity_id"];

  // Squadre associate all'utente loggato
  $related_teams = handled_teams ($_SESSION["account_id"]);
?>
  <div class="vb-content vb-list mt-2">
    <div class="vb-tab-title text-uppercase text-center color-sea underlined pb-1 mb-3">
      <i class="bi bi-list-check mr-2"></i><?= $lang_it[$model . "_" . $object_type] ?>
    </div>
<?php
  if (count($related_teams) > 0) {

    $roster_team = get_team_members ($related_teams[0]["team_id"]);
?>
    <div class="row">
      <div class="col mb-4">
        <span class="mr-4">Squadra</span>
<?php
    if (count($related_teams) == 1) {
?>
        <span><?= $related_teams[0]["team_name"] ?></span>
        <input type="hidden" name="<?= $model ?>[team_id]" value="<?= $related_teams[0]["team_id"] ?>" />
<?php
    } else {
?>
        <select id="<?= $model ?>_team_id" name="<?= $model ?>[team_id]">
          <?php foreach ($related_teams as $team) { ?>
            <option value="<?= $team["team_id"] ?>"><?= $team["team_name"] ?></option>
          <?php } ?>
        </select>
<?php
    }
?>  
      </div>

    </div>
        


    <table id="list_presence">
      <thead>
        <tr>
          <th class="presence name-last">Cognome</th>
          <th class="presence name-first">Nome</th>
          <th class="presence present">Pre</th>
          <th class="presence late">Rit</th>
          <th class="presence missing">Ass</th>
        </tr>
      </thead>

      <tbody>
<?php
    foreach ($roster_team as $member) {
      if ($member["role"] == "player") {
        $name_last = isset($member["name_last"]) ? $member["name_last"] : "-";
        $name_first = isset($member["name_first"]) ? $member["name_first"] : "-";
        $birth_year = isset($member["birth_date"]) ? "(" . substr($member["birth_date"], 2, 2) . ")" : "-";
?>
        <tr>
          <td class="presence name-last"><sup class="mr-1"><?= $birth_year ?></sup><?= $name_last ?></td>
          <td class="presence name-first"><?= $name_first ?></td>
          <td class="presence present"></td>
          <td class="presence late"></td>
          <td class="presence missing"></td>
        </tr>
<?php
    }
    }
?>
      </tbody>
    </table>
<?php
  } else {
?>
    <div>Nessuna squadra associata</div>
<?php
  }
?>
  </div>
  <script src="assets/javascript/<?= $model ?>.js"></script>
