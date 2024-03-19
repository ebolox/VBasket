<?php
  include('logic.php');

  $model = "activity";

  // Liste valore, nome delle colonne e attributi del pulsante
  $section_attributes = array(
    "btn_color" => "btn-primary"
  );
  $section_options = array(
    array("value" => "training", "label" => "Allenamento"),
    array("value" => "game", "label" => "Partita"),
    array("value" => "event", "label" => "Evento")
  );

  $section = ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["section"])) ? $_POST["section"] : "game";

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= contextual_navbar($model, array("print", "edit", "new", "delete"), "game"); ?>

    <div id="<?= $model; ?>_list">
<?php
  }
?>

    <?= get_activity($section); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
    </div>
  </div>
  <script>var model = "activity";</script>
  <script src="assets/javascript/section.js"></script>
<?php
  }
?>