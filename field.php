<?php
  include('logic.php');

  $model = "field";
  $field = get_object_tab();
  $action = $_POST["action"];

  $filename = "logo_big.jpg";
  $file_url = "assets/images/" . $filename;

  $town_options = get_towns();
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model, false); ?>
      <div class="form-row">
        <div class="col-md-8 text-center">

          <div class="vb-image">
            <img id="game_img" class="img-fluid" src="assets/images/logo_big.jpg" />
          </div>

        </div>
        <div class="col-md-4 text-right">

          <ul class="form-label">
            <li>Nome</li>
            <li>Comune</li>
            <li>Luogo</li>
            <li>Indirizzo</li>
            <li>Coordinate GPS</li>
            <li>Telefono</li>
            <li>Note</li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $object["id"]); ?>
      <?= tab_title_ghost (); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data">
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
            <li><?= vb_dropdown ($model, "town", $object["town"], $town_options); ?></li>
            <li><?= vb_text ($model, "place", $object["place"]); ?></li>
            <li><?= vb_text ($model, "address", $object["address"]); ?></li>
            <li><?= vb_text ($model, "gps", $object["gps"]); ?></li>
            <li><?= vb_text ($model, "phone", $object["phone"]); ?></li>
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/book.js"></script>
