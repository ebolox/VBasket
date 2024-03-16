<?php
  include('logic.php');

  $model = "field";
  $field = get_item_tab();
  $action = $_POST["action"];

  $filename = "logo_big.jpg";
  $file_url = "assets/images/" . $filename;

  $town_options = get_towns();
?>
  <div id="field_form" class="vb-content vb-form mt-4">

    <?= contextual_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $field["id"]); ?>
      <div class="form-row">
        <div class="col-md-5 text-center">

          <div class="vb-image">
            <img id="field_img" class="img-fluid" src="<?= $file_url ?>" />
          </div>

        </div>
        <div class="col-md-7">

          <?= field_text ($model, "name", "Nome", $field["name"]); ?>
          <?= field_dropdown ($model, "town", "Comune", $field["town"], $town_options); ?>
<?php
  if ($_POST["action"] == "edit") {
?>
          <?= field_text ($model, "place", "Luogo", $field["place"]); ?>
          <?= field_text ($model, "address", "Indirizzo", $field["address"]); ?>
          <?= field_text ($model, "gps", "Coordinate GPS", $field["gps"]); ?>
          <?= field_text ($model, "phone", "Telefono", $field["phone"]); ?>
          <?= field_text ($model, "notes", "Note", $field["notes"]); ?>
<?php
  }
?>
        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/book.js"></script>
