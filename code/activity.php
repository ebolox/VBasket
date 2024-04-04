<?php
  include('logic.php');

  $model = "activity";

  // Sezione da mostrare
  $section = get_section_to_view("game");

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar($model, array("print", "new", "delete"), "game"); ?>

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
<?php
  }
?>
  <script>var model = "activity";</script>
  <script src="assets/javascript/section.js"></script>