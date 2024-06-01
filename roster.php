<?php
  include('logic.php');
?>

  <div class="roster">
<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $team_id = isset($_POST["team_id"]) ? $_POST["team_id"] : 999999;
    $game_id = isset($_POST["game_id"]) ? $_POST["game_id"] : 999999;

    global $sql_roster;

    // Le info della squadra
    $team = do_ask_easy ("Select * FROM teams WHERE id=" . $team_id);

    // La lista giocatori
    $members = do_ask ($sql_roster . " WHERE r.team_id=" . $team_id);

    $team_title = '<i class="bi bi-microsoft-teams ml-2 mr-2"></i>' . $team["name"] ;
    $team_buttons = button_icon ("bi bi-pencil", "primary", array("id" => "team_edit", "value" => $team_id, "shape" => "circle", "margin" => "ml-2"));
    $team_buttons .= button_icon ("bi bi-arrow-left-right", "primary", array("id" => "team_change", "value" => $game_id, "shape" => "circle", "margin" => "ml-2"));
?>
    <ul>
<?php
    foreach ($members as $mmb) {
      $role = $mmb["role"] == "player" ?
                '<span class="jersey mr-2">' . (!empty($mmb["jersey_nr"]) ? $mmb["jersey_nr"] : "-") . '</span>' :
                '<span class="staff mr-2" style="font-size: var(--size-s);">' . mb_ucfirst(mb_substr($mmb["role"], 0, 2)) . '</span>';
      $name = mb_strtoupper($mmb["name_last"]) . " " . $mmb["name_first"];
      $btn_edit = button_icon ("bi bi-pencil", "primary", array("value" => $mmb["id"], "shape" => "circle", "margin" => "ml-4", "invisible" => true));
?>
      <li data-id="<?= $mmb["id"] ?>"><?= $role ?><?= $name ?><?= $btn_edit ?></li>
<?php
    }
?>
    </ul>

<script>
  // Aggiorna il nome squadra e relativi pulsanti
  $("#modal_team_label").html('<?= $team_title ?>');
  $("#modal_team_toolbar").html('<?= $team_buttons ?>');

  set_modal_team_events ("<?= $team_id ?>");
</script>
<?php
  } else {
?>
    Squadra non compilata
<?php
  }
?>
  </div>