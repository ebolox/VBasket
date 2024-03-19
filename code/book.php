<?php
  include('logic.php');

  $model = "game";

  $section = ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["section"])) ? $_POST["section"] : "club";

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= contextual_navbar($model, array("print", "edit", "new", "delete"), "club"); ?>

    <div id="<?= $model; ?>_list">
<?php
  }
?>

    <?= get_book($section); ?>

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