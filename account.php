<?php
  // Se arriviamo alla pagina dall'eboard
  if (!(isset($_GET) && !empty($_GET["watch"]))) { include('logic.php'); }

  $model = "account";
  $object = get_object_tab();
  $action = $_POST["action"];
  $filename = "logo_big.jpg";

  if ($action == "edit") {

    // Nome account
    $named_code = $account["named"];
    $named_format = extend_account_name_code($account["named"]);
    $named_full = extend_account_name($account["named"], $account["name_first"], $account["name_last"], $account["nickname"]);

    // Foto account
    $sql_img = "SELECT * FROM images WHERE object_type = 'account' AND object_id = " . $account["id"] . " AND main = 1";
    $result = $db_conn->query($sql_img);
    $img = $result->fetch_array();
    if (!empty($img)) {
      $filename = $img['filename'];
    }
  }

  $file_url_supposed = "assets/images/" . $filename;
  $file_url = file_exists($file_url_supposed) ? $file_url_supposed : "assets/images/logo_big.jpg";
    
  // Ruolo
  $role_options = array(
    array("value" => "admin", "label" => "Amministratore"),
    array("value" => "manager", "label" => "Dirigente"),
    array("value" => "coach", "label" => "Coach"),
    array("value" => "athlete", "label" => "Atleta"),
    array("value" => "staff", "label" => "Staff")
  );

  // Lista id, nome delle squadre
  $team_options = get_teams();
  $team_attributes = array("label_icon" => true);
  $team_icon = "<i class=\"bi bi-microsoft-teams text-dark\"></i>";
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-8 text-center">

          <div class="vb-image">
            <img id="<?= $model; ?>_img" class="img-fluid" src="<?= $file_url; ?>" />
          </div>

        </div>
        <div class="col-md-4 text-right">

          <ul class="form-label">
            <li>Cognome</li>
            <li>Nome</li>
            <li>Soprannome</li>
            <li>Data di nascita</li>
            <li>Documento d'identità</li>
            <li>Visita di idoneità</li>
            <li>Indirizzo</li>
            <li>Email</li>
            <li>Telefono</li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $object["id"]); ?>
      <?= tab_toolbar ($action); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= vb_text ($model, "name_last", $object["name_last"]); ?></li>
            <li><?= vb_text ($model, "name_first", $object["name_first"]); ?></li>
            <li><?= vb_text ($model, "nickname", $object["nickname"]); ?></li>
            <li><?= vb_dropdown ($model, "named", $object["named"], $side_options); ?></li>
            <li><?= vb_date ($model, "birth_date", format_to_ddmmyyyy($object["birth_date"])); ?></li>
            <li><?= vb_text ($model, "document_id", $object["document_id"]); ?></li>
            <li><?= vb_date ($model, "sport_fitness", format_to_ddmmyyyy($object["sport_fitness"])); ?></li>
            <li><?= vb_text ($model, "address", $object["address"]); ?></li>
            <li><?= vb_text ($model, "email", $object["email"]); ?></li>
            <li><?= vb_text ($model, "phone", $object["phone"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/account.js"></script>
