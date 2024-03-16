<?php
  $account_id = get_account_id();
  $account_image = get_image("account", $account_id, array("main" => false));
  $account_name = compose_account_name($account_id);

  $account_btn = '<a id="navlink_account" class="nav-link" href="#"><i class="bi bi-person-lines-fill"></i></a>';
  $account_script = '';
  if (isset($account_image)) {
    $account_btn = '<div id="navlink_account" class="btn-link" title="' . $account_name . '" /></div>';
    $account_script = '<script>$("#navlink_account").css("background-image", "url(\'assets/images/' . $account_image .'\')");</script>';
  }
?>  
  <div id="ui_navbar">
    <div class="container d-flex flex-column flex-md-row align-items-center pr-2 pl-2 pt-1 pb-1 px-md-3 mb-3 mb-md-0 bg-white">
      <nav class="row w-100">
        <div class="col-2 text-right">      
          <?= $account_btn; ?>
        </div>
        <div class="col-2">
          <a id="navlink_home" class="p-2 text-dark" href="#"><img id="logo" src="assets/images/logo_big.jpg" /></a>
        </div>
        <div class="col row">
          <a id="navlink_calendar" class="col navlink active" href="#">Calendario</a>
          <a id="navlink_registry" class="col navlink" href="#">Anagrafica</a>
          <a id="navlink_activity" class="col navlink" href="#">Attività</a>
          <a id="navlink_technique" class="col navlink" href="#">Area tecnica</a>
          <a id="navlink_book" class="col navlink" href="#">Rubrica</a>
        </div>
      </nav>
      <input type="hidden" id="account_id" name="account[id]" value="<?= $account_id; ?>" />
    </div>
  </div>
  <?= $account_script; ?>