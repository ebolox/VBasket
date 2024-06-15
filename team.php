<?php
  // Se arriviamo alla pagina dall'eboard
  if (!(isset($_GET) && !empty($_GET["watch"])) && !(isset($_POST) && $_POST["action"] == "create_object")) { include('logic.php'); }

  $model = "team";
  $action = $_POST["action"];
  $object = get_object_tab();

  // Lista id, nome delle società
  $club_options = get_clubs();

  // Componenti della team
  $members = get_team_members($object["id"]);
  $coaches = [];
  $assistants = [];
  $staffs = [];
  $players = [];

  for ($c = 0; $c < count($members) - 1; $c++) {
    $member = $members[$c];

    if ($member['role'] == 'coach') {
      $coaches[] = $c;
    } elseif ($member['role'] == 'assistant') {
      $assistants[] = $c;
    } elseif ($member['role'] == 'staff') {
      $staffs[] = $c;
    } elseif ($member['role'] == 'player') {
      $players[] = $c;
    }
  }
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-7 text-center">

          <div class="vb-image">
            <img id="<?= $model ?>_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-5 text-right">

          <ul class="form-label">
            <li>Nome</li>
<?php
  if ($action != "init_object") {
?>
            <li>Abbreviazione</li>
            <li>Società</li>
            <li>Prima maglia</li>
            <li>Seconda maglia</li>
            <li>Componenti</li>
          </ul>
<?php
  }
?>
        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $object["id"]); ?>
      <?= tab_toolbar ($action); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
<?php
  if ($action != "init_object") {
?>
            <li><?= vb_text ($model, "name_short", $object["name_short"]); ?></li>
            <li><?= vb_dropdown ($model, "club", $object["club"], $club_options); ?></li>
            <li><?= vb_color ($model, "jersey_first", $object["jersey_first"]); ?></li>
            <li><?= vb_color ($model, "jersey_second", $object["jersey_second"]); ?></li>
            <li class="btn-boolean" id="roster_btn">
              <div class="d-inline mr-4"><?= account_marker ("coach", role_short("coach")) ?><b><?= count($coaches) ?></b></div>
              <div class="d-inline mr-4"><?= account_marker ("assistant", role_short("assistant")) ?><b><?= count($assistants) ?></b></div>
              <div class="d-inline mr-4"><?= account_marker ("staff", role_short("staff")) ?><b><?= count($staffs) ?></b></div>
              <div class="d-inline"><?= account_marker ("player", "00") ?><b><?= count($players) ?></b></div>
            </li>
<?php
  }
?>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <?= modal_base('team'); ?>
  <script src="assets/javascript/team.js"></script>
  <style>.vb-content { overflow-y: initial; }</style>
