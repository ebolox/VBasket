<?php
  include('logic.php');

  $model = "game";

  // Liste valore, nome delle colonne e attributi del pulsante
  $section_attributes = array(
    "btn_color" => "btn-primary"
  );
  $section_options = array(
    array("value" => "club", "label" => "Società"),
    array("value" => "field", "label" => "Campi di gioco")
  );

  $section_tag = ($_SERVER["REQUEST_METHOD"] === "POST") ? $_POST["section_tag"] : "club";

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_button_bar" class="row vb-navbar btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">

    <div class="col"></div>
    <div class="col-6 text-left">
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "section", "Sezione", "club", $section_options, $section_attributes); ?>
      </div>
    </div>
    <div class="col"></div>

  </div>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= contextual_navbar($model, array("print", "edit", "new", "delete"), "club"); ?>

    <div id="<?= $model; ?>_list">
<?php
  }
?>

    <?= get_book($section_tag); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
    </div>
  </div>
  <script>var model = "book";</script>
  <script src="assets/javascript/section.js"></script>
<?php
  }
?>