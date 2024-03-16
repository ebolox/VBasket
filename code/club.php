<?php
  include('logic.php');

  $model = "club";
  $club = get_item_tab();
  $action = $_POST["action"];

  $filename = "logo_big.jpg";
  $file_url = "assets/images/" . $filename;

  $town_options = get_towns();
?>
  <div id="club_form" class="vb-content vb-form mt-4">

    <?= contextual_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $club["id"]); ?>
      <div class="form-row">
        <div class="col-md-5 text-center">

          <div class="vb-image">
            <img id="club_img" class="img-fluid" src="<?= $file_url ?>" />
          </div>

        </div>
        <div class="col-md-7">

          <?= field_text ($model, "name", "Nome", $club["name"]); ?>
          <?= field_dropdown ($model, "town", "Comune", $club["town"], $town_options); ?>
<?php
  if ($_POST["action"] == "edit") {
?>
          <?= field_text ($model, "place", "Luogo", $club["place"]); ?>
          <?= field_text ($model, "address", "Indirizzo", $club["address"]); ?>
          <?= field_text ($model, "email", "Email", $club["email"]); ?>
          <?= field_text ($model, "phone", "Telefono", $club["phone"]); ?>
          <?= field_text ($model, "phone_alt", "Tel. alternativo", $club["phone_alt"]); ?>
          <?= field_text ($model, "website", "Sito web", $club["website"]); ?>
          <?= field_text ($model, "facebook", "Facebook", $club["facebook"]); ?>
<?php
  }
?>
        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/book.js"></script>
