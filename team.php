<?php
  // Se arriviamo alla pagina dall'eboard
  if (!(isset($_GET) && !empty($_GET["watch"])) && !(isset($_POST) && $_POST["action"] == "create_object")) { include('logic.php'); }

  $model = "team";
  $action = $_POST["action"];
  $object = get_object_tab();

  // Lista id, nome delle società
  $club_options = get_clubs();
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-8 text-center">

          <div class="vb-image">
            <img id="<?= $model ?>_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-4 text-right">

          <ul class="form-label">
            <li>Nome</li>
<?php
  if ($action != "init_object") {
?>
            <li>Abbreviazione</li>
            <li>Società</li>
            <li>Prima maglia</li>
            <li>Seconda maglia</li>
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
            <li><?= vb_text ($model, "jersey_first", $object["jersey_first"]); ?></li>
            <li><?= vb_text ($model, "jersey_second", $object["jersey_second"]); ?></li>
<?php
  }
?>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/team.js"></script>
