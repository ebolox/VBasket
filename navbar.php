<?php
  // Includiamo la classe Pluralizer
  require_once("ext/rachid/pluralizer.php");

  global $vb;
  $rachid = init_pluralizer();

  $account_id = get_account_id();
  $account_image = get_image("account", $account_id, array("main" => false));
  $account_name = compose_account_name($account_id);

  $account_btn = '<a id="navlink_account" class="navlink btn-link" href="#"><i class="bi bi-person-lines-fill"></i></a>';
  $account_script = '<script>';
  if (isset($account_image)) {
    $account_btn = '<div id="navlink_account" class="navlink btn-link" title="' . $account_name . '" /></div>';
    $account_script .= '$("#navlink_account").css("background-image", "url(\'assets/images/' . $account_image .'\')");';
  }
  $account_script .= '</script>';

  $activity_attributes = array("btn_color" => "btn-vb", "btn_hidden" => true, "btn_group" => false, "label_icon" => true);
  $activity_options = array();
  foreach ($vb["activity"] as $sect) {
    array_push($activity_options, array("value" => $sect, "label" => $lang_it[$rachid->pluralize($sect)]));
  }

  $book_attributes = array("btn_color" => "btn-vb", "btn_hidden" => true, "btn_group" => false, "label_icon" => true);
  $book_options = array();
  foreach ($vb["book"] as $sect) {
    array_push($book_options, array("value" => $sect, "label" => $lang_it[$rachid->pluralize($sect)]));
  }
?>  
  <div id="ui_navbar">
    <div class="container d-flex flex-column flex-md-row align-items-center pr-2 pl-2 pt-1 pb-1 px-md-3 mb-3 mb-md-0 bg-white">
      <nav class="row w-100">
        <div class="col-2">
          <a id="navlink_home" class="p-2 text-dark" href="#"><img id="logo" src="assets/images/logo_big.jpg" /></a>
        </div>
        <div class="col">
          <div class="navlink mt-3 mr-4 d-inline-block">
            <a id="navlink_calendar" class="navlink btn-link active mr-1" href="#">
              <i class="bi bi-calendar-week mr-2"></i>
              <span class="mr-2">Calendario</span>
            </a>
          </div>
          <div class="navlink mt-3 mr-4 d-inline-block">
            <a id="navlink_technique" class="navlink btn-link mr-1" href="#">
              <i class="bi bi-easel mr-2"></i>
              <span class="mr-2">Area tecnica</span>
            </a>
          </div>
          <div class="navlink mt-3 mr-4 d-inline-block">
            <a id="navlink_activity" class="navlink btn-link mr-1" href="#">
              <i class="bi bi-activity mr-2"></i>
              <span class="mr-2">Attività</span>
            </a>
          <?= button_icon_dropdown ("activity", "selector", "bi bi-caret-down-fill", "", $activity_options, $activity_attributes) ?>
          </div>
          <div class="navlink mt-3 d-inline-block">
            <a id="navlink_book" class="navlink btn-link mr-1" href="#">
              <i class="bi bi-journal-richtext mr-2"></i>
              <span class="mr-2">Rubrica</span>
            </a>
          <?= button_icon_dropdown ("book", "selector", "bi bi-caret-down-fill", "", $book_options, $book_attributes) ?>
          </div>
        </div>
        <div class="col-2">
          <?= $account_btn; ?>
        </div>
      </nav>
      <input type="hidden" id="account_id" name="account[id]" value="<?= $account_id; ?>" />
    </div>
  </div>
  <?= $account_script; ?>