<?php
  include('logic.php');

  $model = "account";
  $account = get_account();
  $action = $_POST["action"];
  $filename = "logo_big.jpg";

  if ($action == "edit") {

    // Nome account
    $named_code = $account["named"];
    $named_format = extend_account_name_code($account["named"]);
    $named_full = extend_account_name($account["named"], $account["name_first"], $account["name_last"], $account["nickname"]);

    // Foto account
    $sql_img = "SELECT * FROM images WHERE object_type = 'account' AND object_id = " . $account["id"] . " AND main = 1";
    $result = $db_conn->query($sql_img);
    $img = $result->fetch_array();
    if (!empty($img)) {
      $filename = $img['filename'];
    }
  }

  $file_url_supposed = "assets/images/" . $filename;
  $file_url = file_exists($file_url_supposed) ? $file_url_supposed : "assets/images/logo_big.jpg";
    
  // Ruolo
  $role_options = array(
    array("value" => "admin", "label" => "Amministratore"),
    array("value" => "manager", "label" => "Dirigente"),
    array("value" => "coach", "label" => "Coach"),
    array("value" => "athlete", "label" => "Atleta"),
    array("value" => "staff", "label" => "Staff")
  );

  // Lista id, nome delle squadre
  $team_options = get_teams();
  $team_icon = "<i class=\"bi bi-microsoft-teams text-dark\"></i>";
  $team_attributes = array("label_icon" => true);
?>
  <div id="account_form" class="vb-content vb-form mt-4">

    <?= contextual_navbar($model, array("print", "new", "delete"), false); ?>

    <form>

      <?= form_variables($action, $model, $account["id"]); ?>
      <div class="form-row">
        <div class="col-md-5 text-center">

          <div class="vb-image">
            <img id="account_img" class="img-fluid" src="<?= $file_url ?>" />
            <input type="file" id="account_img_file" class="d-none">
          </div>

        </div>
        <div class="col-md-7">

          <?= field_text ($model, "name_last", "Cognome", $account["name_last"]); ?>
          <?= field_text ($model, "name_first", "Nome", $account["name_first"]); ?>
<?php
  if ($action == "edit") {
?>
          <?= field_text ($model, "nickname", "Soprannome", $account["nickname"]); ?>
          <?= field_date ($model, "birth_date", "Data di nascita", $account["birth_date"], array("icon" => "fas fa-calendar")); ?>
          <?= field_text ($model, "email", "Email", $account["email"]); ?>
          <?= field_text ($model, "phone", "Telefono", $account["phone"]); ?>
<?php
  }
?>
          <?= field_dropdown ($model, "role", "Ruolo", $account["role"], $role_options); ?>
<?php
  if ($_POST["action"] == "edit") {
?>
          <?= field_text ($model, "document_id", "Documento", $account["document_id"]); ?>
          <?= field_date ($model, "sport_fitness", "Visita di idoneità", $account["sport_fitness"], array("icon" => "fas fa-calendar")); ?>
<?php
  }
?>
        </div>
      </div>
<?php
  if ($action == "edit") {
?>
      <div class="form-row mt-3 ml-3">

        <div class="form-group">
          <div id="btn_account_named" class="btn-group vb-btn-dropdown" role="group" aria-label="Nome da usare">
            <input type="hidden" name="account[named]" value="<?= $named_code; ?>" />
            <div class="btn-group btn-group-prepend" role="group">
              <button id="account_named" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $named_format; ?>
              </button>
              <div class="dropdown-menu" aria-labelledby="account[named]">
                <a class="dropdown-item" href="#" data-value="n">Soprannome</a>
                <a class="dropdown-item" href="#" data-value="f+l">Nome Cognome</a>
                <a class="dropdown-item" href="#" data-value="f+l+s">Nome C.</a>
                <a class="dropdown-item" href="#" data-value="l+f">Cognome Nome</a>
                <a class="dropdown-item" href="#" data-value="l+f+s">Cognome N.</a>
              </div>
            </div>
            <button id="account_alias" class="btn btn-secondary text-dark" disabled><?= $named_full; ?></button>
          </div>
        </div>
        <div class="form-group ml-3">
          <?= button_dropdown ($model, "team_a", $team_icon, $account["team_a"], $team_options, $team_attributes); ?>
        </div>
        <div class="form-group ml-3">
          <?= button_dropdown ($model, "team_b", $team_icon, $account["team_b"], $team_options, $team_attributes); ?>
        </div>
        <div class="form-group ml-3">
          <?= button_dropdown($model, "team_c", $team_icon, $account["team_c"], $team_options, $team_attributes); ?>
        </div>
  
      </div>
<?php
  }
?>
    </form>
  </div>
  <script src="assets/javascript/account.js"></script>
