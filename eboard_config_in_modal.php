<?php
  include('logic.php');

  $style_options = array(
    array("value" => "font-digital-7", "label" => "Digital-7"),
    array("value" => "font-led-dot-matrix", "label" => "Led dot"),
    array("value" => "font-scoreboard", "label" => "Scoreboard")
  );

  $li_class = "list-group-item d-flex justify-content-between align-items-center";
  $badge_class = "badge badge-primary badge-pill";
?>
      <div class="vb-content vb-tab mt-4">

        <div class="vb-tab-left">

          <h5 class="text-left">Configurazione tabellone</h5>
          <div class="form-row">
            <div class="col text-right">

              <ul class="form-label">
                <li>Stile</li>
                <li>Componenti</li>
              </ul>

            </div>
          </div>

        </div>
        <form class="vb-tab-right">

          <h5>&nbsp;</h5>
          <div class="form-row">
            <div class="col">

              <ul class="form-data">
                <li><?= vb_dropdown ($model, "style", "font-scoreboard", $style_options); ?></li>
                <li>
                  <ul class="list-group">
                    <li class="<?= $li_class ?>">
                      <span>Freccia</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li class="<?= $li_class ?>">
                      <span>Falli</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li class="<?= $li_class ?>">
                      <span>Time-out</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (); ?></span>
                    </li>
                    <li class="<?= $li_class ?>">
                      <span>Servizi</span>
                      <span class="<?= $badge_class ?>"><?= icon_selected (false); ?></span>
                    </li>
                  </ul>
                </li>
              </ul>

            </div>
          </div>

        </form>
      </div>