<?php
  include('logic.php');

  $model = "media";

  // Sezione da mostrare
  $section = get_section_to_view((isset($_GET) && !empty($_GET["section"])) ? $_GET["section"] : "image");

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar($model, array("print", "new", "delete"), $section) ?>

    <div id="<?= $model ?>_list">
<?php
  }
?>

    <?= get_media($section) ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
    </div>
  </div>
  <script>
    var model = "<?= $model ?>";
    var section = "<?= $section ?>";
  </script>
  <script src="assets/javascript/<?= $section ?>.js"></script>
<?php
  }
?>