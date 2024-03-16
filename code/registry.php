<?php
  include('logic.php');

  $model = "registry";

  // Liste id, nome delle squadre e attributi del pulsante
  $team_attributes = array("btn_color" => "btn-primary", "select_all" => "Tutti");
  $team_options = get_teams();

  // Liste valore, nome delle colonne e attributi del pulsante
  $column_attributes = array(
    "label" => "Colonne",
    "select_all" => "Tutte",
    "icon_class" => "bi bi-eye text-success mr-1"
  );
  $column_options = array(
    array("value" => "role", "label" => "Ruolo"),
    array("value" => "birth", "label" => "Millesimo"),
    array("value" => "phone", "label" => "Telefono"),
    array("value" => "email", "label" => "Email"),
    array("value" => "document", "label" => "Documento"),
    array("value" => "fitness", "label" => "Idoneità"),
    array("value" => "team", "label" => "Squadre")
  );

  $team_id = ($_SERVER["REQUEST_METHOD"] === "POST") ? $_POST["team_id"] : "";

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
  <div id="<?= $model; ?>_button_bar" class="row vb-navbar btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

    <div class="col"></div>
      <div class="col-6 text-left">
        <div class="form-group mb-0 ml-3">
        <?= dropdown_multiselect($model, "columns", $column_options, $column_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <?= button_dropdown($model, "teams", "Tesserati", "all", $team_options, $team_attributes); ?>
      </div>
      <div class="form-group mb-0 ml-3">
        <button type="button" id="<?= $model; ?>_select_all" class="btn btn-primary" value="all">Seleziona tutti</button>
      </div>
    </div>
    <div class="col"></div>

  </div>
  <div id="<?= $model; ?>_content" class="vb-content vb-list mt-4">

    <?= contextual_navbar($model, array("print", "edit", "new", "delete"), false); ?>

    <div id="<?= $model; ?>_list">
<?php
  }
?>

    <?= get_registry_by_team($team_id); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
    </div>
  </div>
  <script src="assets/javascript/registry.js"></script>
<?php
  }
?>