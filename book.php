<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET" || ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] != "delete_object")) {
    include('logic.php');
  }

  $model = "book";

  // Sezione da mostrare
  $section = get_section_to_view((isset($_GET) && !empty($_GET["section"])) ? $_GET["section"] : "club");
?>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar($model, array("print", "new", "delete"), $section) ?>

    <div id="<?= $model ?>_list">

    <?= get_book($section) ?>

    </div>
  </div>
  <script>
    var model = "book";
    var section = "<?= $section ?>";
  </script>
  <script src="assets/javascript/section_list.js"></script>