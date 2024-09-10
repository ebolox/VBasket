<?php
  include('logic.php');

  $model = "file";
  $object = get_object_tab();
  $action = $_POST["action"];

  if ($action != "init_object") {
    // Opzioni Oggetti associabili
    $objectable_options = array(
      array("value" => "training", "label" => $lang_it["training"]),
      array("value" => "technique", "label" => $lang_it["technique"]),
      array("value" => "event", "label" => $lang_it["event"]),
      array("value" => "field", "label" => $lang_it["field"]),
      array("value" => "game", "label" => $lang_it["game"]),
      array("value" => "account", "label" => $lang_it["account"]),
      array("value" => "screen", "label" => $lang_it["screen"]),
      array("value" => "club", "label" => $lang_it["club"]),
      array("value" => "team", "label" => $lang_it["team"]),
      array("value" => "other m", "label" => $lang_it["other m"])
    );

    $objectables = get_objectables($object["object_type"], $object["object_id"]);
  }
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-7 text-center">

          <div id="<?= $model ?>_img" class="vb-image vb-file-add">
            <?= icon_upload() ?>
            <img class="img-fluid" src="public/<?= $object["filename"] ?>" />
          </div>

        </div>
        <div class="col-md-5 text-right">

          <ul class="form-label">
            <li>Nome</li>
<?php
  if ($action != "init_object") {
?>
            <li>Nome abbreviato</li>
            <li>Associato a</li>
            <li>ID</li>
            <li>Archiviato</li>
            <li>Creazione</li>
            <li>Ultima modifica</li>
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
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
<?php
  if ($action != "init_object") {
?>
            <li><?= vb_text ($model, "name_short", $object["name_short"]); ?></li>     
            <li><?= vb_dropdown ($model, "object_type", $object["object_type"], $objectable_options); ?></li>
            <li><?= vb_dropdown ($model, "object_id", $object["object_id"], $objectables); ?></li>
            <li><?= vb_boolean ($model, "archived", $object["archived"]); ?></li>
            <li><?= $object["created_at"]; ?></li>
            <li><?= $object["modified_at"]; ?></li>
<?php
  }
?>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/<?= $model ?>.js"></script>
