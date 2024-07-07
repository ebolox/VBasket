<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include_once("logic.php");
  }

  $model = "screen";
?>
  <div id="<?= $model ?>_content" class="vb-content vb-list mt-4">

    <?= form_navbar ($model, array(), false); ?>

    <div class="row">
      <div id="<?= $model ?>_recept" class="col">
        <h5>Carica le immagini</h5>
        <div class="drag-in"></div>
      </div>
      <div id="<?= $model ?>_archive" class="col">
          <h5>Immagini presenti</h5>
        <div class="drag-out">
<?php
  $directory = "public/screen/";
  $files = array_diff(scandir($directory), ['..', '.']);

  $response = [];
  foreach ($files as $file) {
    $file_path = $directory . $file;
    $file_type = mime_content_type($file_path);
    $response[] = [
      "name" => $file,
      "type" => $file_type,
      "url" => $file_path
    ];
  }

  echo json_encode($response);
?>
        </div>
      </div>
    </div>

  </div>
  <script src="assets/javascript/<?= $model ?>.js"></script>