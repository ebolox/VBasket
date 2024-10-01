<?php
  // Se arriviamo alla pagina dall'eboard
  if (!(isset($_GET) && !empty($_GET["watch"])) && !(isset($_POST) && $_POST["action"] == "create_object")) { include('logic.php'); }

  $model = "account";
  $object = get_object_tab();
  $action = $_POST["action"];
  $filename = "papero.jpg";

  // Nome account
  $named_code = $object["named"];
  $named_format = extend_account_name_code($object["named"]);
  $named_full = extend_account_name($object["named"], $object["name_first"], $object["name_last"], $object["nickname"]);

  // Foto account
  $filename = get_main_file ($model, $object["id"]);

  $object["purpose"] = $object["account_type"] == "player" ? "registration" : "documentation";

  $file_url_supposed = "public/images/" . $filename;
  $file_url = file_exists($file_url_supposed) ? $file_url_supposed : "public/images/papero.jpg";

    // Le squadre associate al profilo
  $associated_teams = get_account_teams ($object["id"]);
  $team_class = "play-with-" . count($associated_teams) . "-teams";

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

          <?= account_mandatory_data($object) ?>
        </div>
        <div class="col-md-5 text-right">

          <ul class="form-label" data-toggle="main data">
            <li class="form-title"><?= $lang_it["main data"]; ?><i class="bi bi-chevron-up vb ml-2 mr-1"></i></li>
            <li>Tipo di profilo</li>
            <li>Cognome</li>
            <li>Nome</li>
            <li>Visita di idoneità</li>
            <li class="<?= $team_class ?>">Squadre</li>
          </ul>
          <ul class="form-label hidden" data-toggle="personal data">
            <li class="form-title"><?= $lang_it["personal data"] ?><i class="bi bi-chevron-down vb ml-2 mr-1"></i></li>
            <li>Sesso</li>
            <li>Data di nascita</li>
            <li>Documento d'identità</li>
            <li>Soprannome</li>
            <li>Compare come</li>
          </ul>
          <ul class="form-label hidden" data-toggle="contact details">
            <li class="form-title"><?= $lang_it["contact details"] ?><i class="bi bi-chevron-down vb ml-2 mr-1"></i></li>
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

          <ul class="form-data" data-toggle="main data">
            <li class="form-title"></li>
            <li><?= vb_dropdown ($model, "account_type", $object["account_type"], $account_type_options); ?></li>
            <li><?= vb_text ($model, "name_last", $object["name_last"]); ?></li>
            <li><?= vb_text ($model, "name_first", $object["name_first"]); ?></li>
            <li><?= vb_date ($model, "sport_fitness", format_to_ddmmyyyy($object["sport_fitness"])); ?></li>
            <li class="<?= $team_class ?>"><?= show_account_teams ($associated_teams); ?></li>
          </ul>
          <ul class="form-data hidden" data-toggle="personal data">
            <li class="form-title"></li>
            <li><?= vb_dropdown ($model, "sex", $object["sex"], $sex_options); ?></li>
            <li><?= vb_date ($model, "birth_date", format_to_ddmmyyyy($object["birth_date"])); ?></li>
            <li><?= vb_text ($model, "document_id", $object["document_id"]); ?></li>
            <li><?= vb_text ($model, "nickname", $object["nickname"]); ?></li>
            <li><?= vb_dropdown ($model, "named", $object["named"], $named_options); ?></li>
          </ul>
          <ul class="form-data hidden" data-toggle="contact details">
            <li class="form-title"></li>
            <li><?= vb_text ($model, "address", $object["address"]); ?></li>
            <li><?= vb_text ($model, "email", $object["email"]); ?></li>
            <li><?= vb_text ($model, "phone", $object["phone"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <?= modal_base('account_teams'); ?>
  <script src="assets/javascript/section_tab.js"></script>
  <script src="assets/javascript/account.js"></script>
