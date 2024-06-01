<?php
  include('logic.php');

  $model = "activity";

  // Sezione da mostrare
  $section = get_section_to_view ((isset($_GET) && !empty($_GET["section"])) ? $_GET["section"] : "game");

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar ($model, array("print", "new", "delete"), "game"); ?>

    <div id="<?= $model; ?>_list">
<?php
  }
?>

    <?= get_activities ($section); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $rachid = init_pluralizer();
?>
    </div>
  </div>
  <div id="eboard_popup"></div>
  <script>
    var model = "activity";
    var section = "<?= $section; ?>";
  </script>
  <script src="assets/javascript/section.js"></script>
<?php
  }
?>