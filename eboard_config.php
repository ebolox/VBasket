<?php
  include('logic.php');

  $style_options = array(
    array("value" => "font-digital-7", "label" => "Digital-7"),
    array("value" => "font-led-dot-matrix", "label" => "Led dot"),
    array("value" => "font-scoreboard", "label" => "Scoreboard")
  );

  $badge_class = "badge badge-primary badge-pill";
?>
      <nav id="sidebar_eboard" class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <form class="vb-tab-right">
            <h5><i class="bi bi-tools mr-2"></i>Configurazione tabellone</h5>
            <ul class="nav flex-column">
              <li class="nav-item">
                <div class="form-label">Stile</div>
                <div class="form-data"><?= vb_dropdown ($model, "style", "font-scoreboard", $style_options); ?></div>
              </li>
              <li class="nav-item">
                <div class="form-label">Componenti</div>
                <div class="form-data">
                  <ul>
                    <li>
                      <span>Freccia</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li>
                      <span>Falli</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li>
                      <span>Time-out</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li>
                      <span>Servizi</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (false); ?></span>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </form>
        </div>
      </nav>