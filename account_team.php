<?php
  include('logic.php');

  global $lang_it;

  $account_id = $_POST["account_id"];
  $account_name = $_POST["account_name"];

  $teams = get_teams();
  $account_teams = get_account_teams($account_id);
  $team_ids = array_column($account_teams, 'team_id');

  $current_year = date("Y");
  $next_year = $current_year + 1;
  $modal_title = '<i class="bi bi-list-ul ml-2 mr-2"></i>' . $lang_it["associated teams"] . ' a ' .$account_name;

  $table_title = $lang_it["season"] . ' ' . $current_year . '/' . $next_year;
?>
  <h5 class="text-center"><?= $table_title ?></h5>
  <table id="list_account_teams">
<?php
  foreach($teams as $team) {

    $btn_icon = in_array($team["value"], $team_ids) ?
      icon("bi bi-check-lg", ["icon_class" => "success", "is_clickable" => true]) :
      icon("bi bi-x-circle", ["icon_class" => "warning", "is_clickable" => true]);
?>
    <tr id="team_<?= $team["value"] ?>">
      <td><?= $team["label"] ?><td>
      <td><?= $btn_icon ?><td>
    </tr>
<?php
  }
?>
  </table>

<script>
  // Aggiorna il nome squadra e relativi pulsanti
  $("#modal_account_teams_label").html('<?= $modal_title ?>');

  set_modal_account_teams_events ();
</script>