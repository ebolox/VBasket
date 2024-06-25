<?php
  // Se arriviamo alla pagina dall'eboard
  if (!(isset($_GET) && !empty($_GET["watch"])) && !(isset($_POST) && $_POST["action"] == "create_object")) { include('logic.php'); }

  $model = "account";
  $object = get_object_tab();
  $action = $_POST["action"];
  $filename = "logo_big.jpg";

  if ($action != "init_object") {

    // Nome account
    $named_code = $object["named"];
    $named_format = extend_account_name_code($object["named"]);
    $named_full = extend_account_name($object["named"], $object["name_first"], $object["name_last"], $object["nickname"]);

    // Foto account
    $sql_img = "SELECT * FROM images WHERE object_type = 'account' AND object_id = " . $object["id"] . " AND main = 1";
    $result = $db_conn->query($sql_img);
    $img = $result->fetch_array();
    if (!empty($img)) {
      $filename = $img['filename'];
    }
  }

  $file_url_supposed = "assets/images/" . $filename;
  $file_url = file_exists($file_url_supposed) ? $file_url_supposed : "assets/images/logo_big.jpg";
    
  // Tipo di tesserato
  $account_type_options = array(
    array("value" => "admin", "label" => "Amministratore"),
    array("value" => "manager", "label" => "Dirigente"),
    array("value" => "coach", "label" => "Coach"),
    array("value" => "player", "label" => "Atleta"),
    array("value" => "staff", "label" => "Staff")
  );

  // Come chiamo sto tesserato
  $named_options = array(
    array("value" => "n", "label" => "Soprannome"),
    array("value" => "f+l", "label" => "Nome Cognome"),
    array("value" => "f+l+s", "label" => "Nome C."),
    array("value" => "l+f", "label" => "Cognome Nome"),
    array("value" => "l+f+s", "label" => "Cognome N.")
  );

  // Sesso del tesserato
  $sex_options = array(
    array("value" => "f", "label" => "Femmina"),
    array("value" => "m", "label" => "Maschio")
  );
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-7 text-center">

          <?= field_image($model, $file_url) ?>

        </div>
        <div class="col-md-5 text-right">

          <ul class="form-label">
            <li>Cognome</li>
            <li>Nome</li>
<?php
  if ($action == "init_object") {
?>
            <li class="d-none">Compare come</li>
<?php
  } else {
?>
            <li>Soprannome</li>
            <li>Sesso</li>
            <li>Data di nascita</li>
            <li>Documento d'identità</li>
            <li>Visita di idoneità</li>
            <li>Indirizzo</li>
            <li>Email</li>
            <li>Telefono</li>
            <li>Compare come</li>
            <li>Tipo di profilo</li>
<?php
  }
?>
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
<?php
  if ($action == "init_object") {
?>
            <li class="d-none"><input type="hidden" id="<?= $model ?>_named", name="<?= $model ?>[named]" value="l+f" /></li>
<?php
  } else {
?>
            <li><?= vb_text ($model, "nickname", $object["nickname"]); ?></li>
            <li><?= vb_dropdown ($model, "sex", $object["sex"], $sex_options); ?></li>
            <li><?= vb_date ($model, "birth_date", format_to_ddmmyyyy($object["birth_date"])); ?></li>
            <li><?= vb_text ($model, "document_id", $object["document_id"]); ?></li>
            <li><?= vb_date ($model, "sport_fitness", format_to_ddmmyyyy($object["sport_fitness"])); ?></li>
            <li><?= vb_text ($model, "address", $object["address"]); ?></li>
            <li><?= vb_text ($model, "email", $object["email"]); ?></li>
            <li><?= vb_text ($model, "phone", $object["phone"]); ?></li>
            <li><?= vb_dropdown ($model, "named", $object["named"], $named_options); ?></li>
            <li><?= vb_dropdown ($model, "account_type", $object["account_type"], $account_type_options); ?></li>
<?php
  }
?>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/account.js"></script>
