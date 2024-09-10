<?php
  include('logic.php');

  $model = "club";
  $object = get_object_tab();
  $action = $_POST["action"];

  $filename = get_main_file ($model, $object["id"]);
  $file_url_supposed = "public/images/" . $filename;
  $file_url = file_exists($file_url_supposed) ? $file_url_supposed : "public/images/papero.jpg";

  $town_options = get_towns();

  // Settori (e relative squadre) della società
  $related_teams = get_club_teams_summary ($object["id"]);
  $club_sectors = array();
  global $team_sectors;
  foreach ($related_teams as $team) {
    foreach ($team_sectors as $key => $categories) {
      if (in_array($team["category_name"], $categories)) {
        if (!in_array($key, $club_sectors)) {
          $club_sectors[] = $key;
        }
        break;  // Exit inner loop once a match is found for efficiency
      }
    }
  }
?>
  <div class="vb-content vb-tab mt-4">

    <div class="vb-tab-left">

      <?= tab_title ($model); ?>
      <div class="form-row">
        <div class="col-md-7 text-center">

          <?= field_image($model, $file_url) ?>

        </div>
        <div class="col-md-5 text-right">

          <ul class="form-label tab-section section-main">
            <li>Nome</li>
            <li>Squadre</li>
            <li>Comune</li>
          </ul>
          <ul class="form-label tab-section">
            <li>Luogo</li>
            <li>Indirizzo</li>
            <li>Telefono</li>
            <li>Tel. alternativo</li>
            <li>Email</li>
            <li>Sito web</li>
            <li>Facebook</li>
            <li>Instagram</li>
            <li>YouTube</li>
          </ul>

        </div>
      </div>

    </div>
    <form class="vb-tab-right">

      <?= form_variables ($action, $model, $object["id"]); ?>
      <?= tab_toolbar ($action); ?>
      <div class="form-row">

        <div class="col-md-12">

          <ul class="form-data tab-section section-main">
            <li><?= vb_text ($model, "name", $object["name"]); ?></li>
            <li class="btn-boolean">
              <i class="bi bi-microsoft-teams mr-2"></i>
              <span><?= count($related_teams) ?></span>
              <span class="ml-3"><?= implode(',', $club_sectors) ?></span>
            </li>
            <li><?= vb_dropdown ($model, 'town', $object['town'], $town_options); ?></li>
          </ul>
          <ul class="form-data tab-section">
            <li><?= vb_text ($model, 'place', $object['place']); ?></li>
            <li><?= vb_text ($model, 'address', $object['address']); ?></li>
            <li><?= vb_text ($model, 'phone', $object['phone']); ?></li>
            <li><?= vb_text ($model, 'phone_alt', $object['phone_alt']); ?></li>
            <li><?= vb_text ($model, 'email', $object['email']); ?></li>
            <li><?= vb_text ($model, 'website', $object['website']); ?></li>
            <li><?= vb_text ($model, 'facebook', $object['facebook']); ?></li>
            <li><?= vb_text ($model, 'instagram', $object['instagram']); ?></li>
            <li><?= vb_text ($model, 'youtube', $object['youtube']); ?></li>
          </ul>

        </div>
      </div>

    </form>
  </div>
  <script src="assets/javascript/club.js"></script>
