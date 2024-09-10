<?php
  include('logic.php');

  $model = "book";

  // Sezione da mostrare
  $section = get_section_to_view((isset($_GET) && !empty($_GET["section"])) ? $_GET["section"] : "club");

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar($model, array("print", "new", "delete"), $section) ?>

    <div id="<?= $model ?>_list">
<?php
  }
?>

    <?= get_book($section) ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
    </div>
  </div>
  <script>
    var model = "book";
    var section = "<?= $section ?>";
  </script>
  <script src="assets/javascript/section_list.js"></script>
<?php
  }
?>